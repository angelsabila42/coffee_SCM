import pandas as pd
import matplotlib.pyplot as plt
import numpy as np
import os

from datetime import datetime
from prophet import Prophet
from sklearn.metrics import mean_absolute_error, mean_squared_error, r2_score

#Smoothing Function for Poor performers
def smooth_series(series, window=2):
    return series.rolling(window=window, min_periods=1).mean()

#---Cleaning the dataset---#
#Converting years to datetime
df= pd.read_json('http://127.0.0.1:8000/api/v1/quantity-demand')
#type:ignore
df = pd.json_normalize(df['data'], sep='_')#type:ignore

df= df.rename(columns={'avgOrderSize_kg': 'AvgOrderSize',
                       'importer_name':'Importer',
                       'year':'Year',
                       'quantity_(60kg_bags)':'Quantity_(60kg_Bags)',
                       'importer_country':'Country',
                       'importer_continent':'Continent',
                       'yearsAsCustomer':'YearsAsCustomer',
                       'orderFreqPerYear':'OrderFreqPerYear'})

print(df.columns)

df['ds'] = df['Year'].apply(lambda x: datetime.strptime(x.split('-')[0] + '-07-01', '%Y-%m-%d'))
df['y'] = df['Quantity_(60kg_Bags)']

forecast_years = 5

# print("\nCleaned Data")
# print(df[['Importer', 'ds', 'y']].head())
# print(df.tail())

historical_df = df[['Importer','ds','y']].rename(columns={'ds': 'date', 'y':'actual'})
historical_df.to_json('public/data/historical_demand_data.json', orient='records', date_format='iso')

importers = df['Importer'].unique()
results = []
for imp in importers:
    data = df[df['Importer'] == imp].copy()

    #Splitting the data
    train = data[data['ds'] < '2022-07-01']
    test = data[data['ds'] >= '2022-07-01']

    if len(test) ==0:
        print(f" Skipping {imp} - no test data ")
        continue

    #Training
    model = Prophet()
    model.fit(train[['ds','y']])

    #Forecasting
    future_years = test['ds'].dt.year.unique()
    future_dates  = pd.to_datetime([f" {year}-07-01" for year in future_years])
    future = pd.concat([train[['ds']], pd.DataFrame({'ds':future_dates})], ignore_index=True)
    
    forecast =model.predict(future)

    #Merge Forecasts with actual data
    test_merged = test.merge(forecast[['ds','yhat']], on='ds', how='left')
    test_merged = test_merged.dropna(subset={'yhat'})
    if test_merged.empty:
        print(f"Skipping {imp} - no date match in forecast")
        continue

    #Evaluating
    mae = mean_absolute_error(test_merged['y'], test_merged['yhat'])
    rmse = np.sqrt(mean_squared_error(test_merged['y'], test_merged['yhat']))
    r2 = r2_score(test_merged['y'], test_merged['yhat'])

    results.append({
            'Importer': imp,
            'MAE': mae,
            'RMSE': rmse,
            'R2': r2,
        })

#Final Results
results_df = pd.DataFrame(results)

poor_model = results_df[results_df['R2'] < 0.6]
good_model = results_df[results_df['R2'] >= 0.6]

poor_model.to_csv('poor_importer.csv', index=False)
good_model.to_csv('good_importers.csv', index=False)

print("\nFirst set of poor importers")
print(poor_model)

#For the good Model
results_good= []
forecast_good_list= []

for imp in good_model['Importer']:
    print(f"\nFinal forecasting for the good importer: {imp}")
    data = df[df['Importer'] == imp].copy()

    #Training
    model_good = Prophet()
    model_good.fit(data[['ds','y']])

    #Forecasting
    last_date = data['ds'].max()
    future_dates = pd.date_range(start=last_date + pd.DateOffset(years=1), periods=forecast_years, freq='12MS')
    future = pd.DataFrame({'ds':future_dates})
    
    forecast =model_good.predict(future)
    forecast = forecast[['ds', 'yhat']].copy()
    forecast['Importer'] = imp

    forecast_good_list.append(forecast)

forecast_good_df = pd.concat(forecast_good_list, ignore_index=True)
forecast_good_df = forecast_good_df.rename(columns={'ds': 'date', 'yhat':'forecast'})

#To Json
forecast_good_df.to_json('public/data/forecast_good.json', orient='records', date_format='iso')


#Poor Model, Forecasting
forecast_log_list = []
for imp in poor_model['Importer']:
    print(f"\nRetraining {imp} with log transformed data + regressor")
    data = df[df['Importer'] == imp].copy()
    data['y_log'] = np.log1p(data['y'])

    if 'YearsAsCustomer' not in data.columns:
        print(f"Skipping {imp} - no YearsAsCustomer column")
        continue
        
    #Prophet With log y
    model_log = Prophet(changepoint_prior_scale=0.5)
    model_log.add_regressor('YearsAsCustomer')
    model_log.fit(data[['ds','y_log','YearsAsCustomer']].rename(columns={'y_log': 'y'}))

    #Forecasting
    last_date = data['ds'].max()
    future_years = pd.date_range(start=last_date + pd.DateOffset(years=1), periods=forecast_years, freq='12MS')
    future_log = pd.DataFrame({'ds':future_years})

    last_years_as_customer = int(data['YearsAsCustomer'].iloc[-1])
    future_log['YearsAsCustomer'] = [last_years_as_customer + i for i in range(1,forecast_years + 1)]

    forecast_log = model_log.predict(future_log)
    forecast_log['forecast'] = np.expm1(forecast_log['yhat'])
    forecast_log = forecast_log[['ds', 'forecast']]
    forecast_log['Importer'] = imp

    forecast_log_list.append(forecast_log)

forecast_log_df = pd.concat(forecast_log_list, ignore_index=True)
forecast_log_df = forecast_log_df.rename(columns={'ds': 'date', 'yhat':'forecast'})

#To Json
forecast_log_df.to_json('public/data/forecast_log.json', orient='records', date_format='iso')

#---Poor Model, Training for split---
results_log= []
for imp in poor_model['Importer']:
    print(f"\nRetraining {imp} with log transformed data + regressor")
    data = df[df['Importer'] == imp].copy()
    data['y_log'] = np.log1p(data['y'])
    
    #Splitting
    train = data[data['ds'] < '2022-07-01']
    test = data[data['ds'] >= '2022-07-01']

    if 'YearsAsCustomer' not in data.columns:
        print(f"Skipping {imp} - no YearsAsCustomer column")
        continue
        
    #Prophet With log y
    train_log =train[['ds','y_log', 'YearsAsCustomer']].rename(columns={'y_log':'y'})
    test_regressors = test[['ds','YearsAsCustomer']]

    model_eval = Prophet(changepoint_prior_scale=0.5)
    model_eval.add_regressor('YearsAsCustomer')
    model_eval.fit(train_log)

    future_log = pd.concat([train[['ds','YearsAsCustomer']], test_regressors], ignore_index=True)
    forecast_log = model_eval.predict(future_log)

    forecast_log['yhat_orig'] = np.expm1(forecast_log['yhat'])
    test_log = test.merge(forecast_log[['ds','yhat_orig']], on='ds', how='left').dropna()

    #Merge predictions
    mae_log = mean_absolute_error(test_log['y'], test_log['yhat_orig'])
    rmse_log = np.sqrt(mean_squared_error(test_log['y'], test_log['yhat_orig']))
    r2_log = r2_score(test_log['y'], test_log['yhat_orig'])

    results_log.append({
            'Importer': imp,
            'MAE': mae_log,
            'RMSE': rmse_log,
            'R2': r2_log,
        })


log_results_df = pd.DataFrame(results_log)
log_results_df.to_csv('log_regressor_improved.csv', index=False)
print("\nForecasting Poor log Model Results: ")
print(log_results_df)

poor_log_model = log_results_df[log_results_df['R2'] < 0.6]
good_log_model = log_results_df[log_results_df['R2'] >= 0.6]
print(poor_log_model)

poor_log_model.to_csv('poor_log_importer.csv', index=False)

#Smoothed + log + regressor for poor models
smoothed_log_results= []
for imp in poor_log_model['Importer']:
    print(f"\nRetraining {imp} with Smoothing log transformed data + regressor")
        
    data = df[df['Importer'] == imp].copy()
    data['y_log'] = smooth_series(np.log1p(data['y']))
    
    #Splitting
    # train = data[data['ds'] < '2022-07-01']
    # test = data[data['ds'] >= '2022-07-01']

    if 'YearsAsCustomer' not in data.columns:
        print(f"Skipping {imp} - no YearsAsCustomer column")
        continue
        
    #Prophet With log y
    test_regressors = test[['ds','YearsAsCustomer']]

    model_log_smoothed = Prophet(changepoint_prior_scale=0.5)
    model_log_smoothed.add_regressor('YearsAsCustomer')
    model_log_smoothed.fit(data[['ds','y_log', 'YearsAsCustomer']].rename(columns={'y_log':'y'}))

    last_date = data['ds'].max()
    future_dates = pd.date_range(start=last_date + pd.DateOffset(years=1), periods=forecast_years, freq='12MS')
    future_smooth =pd.DataFrame({'ds': future_dates})

    #For yearly increase
    last_years = int(data['YearsAsCustomer'].iloc[-1])
    future_smooth['YearsAsCustomer'] = [last_years + i for i in range(1,forecast_years + 1)]
    
    forecast_log = model_log_smoothed.predict(future_smooth)
    forecast_log['forecast'] = np.expm1(forecast_log['yhat'])
    forecast_log= forecast_log[['ds','forecast']]
    forecast_log['Importer'] = imp

    smoothed_log_results.append(forecast_log)
    
forecast_smoothed_df = pd.concat(smoothed_log_results, ignore_index=True)
forecast_smoothed_df = forecast_smoothed_df.rename(columns={'ds':'date'})
forecast_smoothed_df.to_json('public/data/forecast_smoothed.json', orient='records', date_format='iso')
    


