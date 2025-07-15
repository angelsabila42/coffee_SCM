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
df= pd.read_csv('demand_qtn.csv')
df= df.rename(columns={'AvgOrderSize_kg': 'AvgOrderSize'})

df['ds'] = df['Year'].apply(lambda x: datetime.strptime(x.split('-')[0] + '-07-01', '%Y-%m-%d'))
df['y'] = df['Quantity_(60kg_Bags)']


print("\nCleaned Data")
print(df[['Importer', 'ds', 'y']].head())
print(df.head())

historical_df = df[['Importer','ds','y']].rename(columns={'ds': 'date', 'y':'actual'})
historical_df.to_json('historcal_data.json', orient='records', date_format='iso')

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
    #future = model.make_future_dataframe(periods=len(test), freq='Y')
    #future['ds'] = future['ds'].dt.year.astype(str) + '-07-07'
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

#For the good Model
results_good= []
years_forecasted = 5
forecast_good_list= []

for imp in good_model['Importer']:
    print(f"\nFinal forecasting for the good importer: {imp}")
    data = df[df['Importer'] == imp].copy()

    #Training
    model_good = Prophet()
    model_good.fit(data[['ds','y']])

    #Forecasting
    last_date = data['ds'].max()
    future = model.make_future_dataframe(periods=5, freq='Y')
    future = future[future['ds'] > last_date]
    
    forecast =model_good.predict(future)
    forecast = forecast[['ds', 'yhat']].copy()
    forecast['Importer'] = imp

    forecast_good_list.append(forecast)

forecast_good_df = pd.concat(forecast_good_list, ignore_index=True)
forecast_good_df = forecast_good_df.rename(columns={'ds': 'date', 'yhat':'forecast'})

#To Json
forecast_good_df.to_json('forecast_good.json', orient='records', date_format='iso')


#Poor Model
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
    future_years = pd.date_range(start=last_date + pd.DateOffset(years=1), periods=5, freq='Y')
    future = future[future['ds'] > last_date]

    future_log = pd.concat([train[['ds','YearsAsCustomer']], test_regressors], ignore_index=True)
    forecast_log = model_log.predict(future_log)

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

    # model_log.plot(forecast_log)
    # plt.title(f"{imp} -Log + regressor Forecast")
    # plt.tight_layout()
    # plt.show()

log_results_df = pd.DataFrame(results_log)
print("\nForecasting Poor Model Results: ")
print(log_results_df)

#Smoothed + log for poor models
poor_log_model = log_results_df[log_results_df['R2'] < 0.6]
good_log_model = log_results_df[log_results_df['R2'] >= 0.6]

smoothed_log_results= []
for imp in poor_log_model['Importer']:
    print(f"\nRetraining {imp} with Smoothing log transformed data + regressor")
        
    data = df[df['Importer'] == imp].copy()
    data['y_log'] = smooth_series(np.log1p(data['y']))
    
    #Splitting
    train = data[data['ds'] < '2022-07-01']
    test = data[data['ds'] >= '2022-07-01']

    if 'YearsAsCustomer' not in data.columns:
        print(f"Skipping {imp} - no YearsAsCustomer column")
        continue
        
    #Prophet With log y
    train_log =train[['ds','y_log', 'YearsAsCustomer']].rename(columns={'y_log':'y'})
    test_regressors = test[['ds','YearsAsCustomer']]

    model_log_smoothed = Prophet(changepoint_prior_scale=0.5)
    model_log_smoothed.add_regressor('YearsAsCustomer')
    model_log_smoothed.fit(train_log)

    future_log = pd.concat([train[['ds','YearsAsCustomer']], test_regressors], ignore_index=True)
    forecast_log = model_log_smoothed.predict(future_log)

    forecast_log['yhat_orig'] = np.expm1(forecast_log['yhat'])
    test_log = test.merge(forecast_log[['ds','yhat_orig']], on='ds', how='left').dropna()

    #Merge predictions
    mae_log_smoothed = mean_absolute_error(test_log['y'], test_log['yhat_orig'])
    rmse_log_smoothed = np.sqrt(mean_squared_error(test_log['y'], test_log['yhat_orig']))
    r2_log_smoothed = r2_score(test_log['y'], test_log['yhat_orig'])

    smoothed_log_results.append({
            'Importer': mae_log_smoothed,
            'MAE': mae_log,
            'RMSE': rmse_log_smoothed,
            'R2': r2_log_smoothed,
        })

    # model_log_smoothed.plot(forecast_log)
    # plt.title(f"{imp} -Smoothed Log + regressor Forecast")
    # plt.tight_layout()
    # plt.show()

smoothed_log_df = pd.DataFrame(smoothed_log_results)
print("\nForecasting Smoothed Log results for Poor Models: ")
print(smoothed_log_df)


good_model.to_csv('good_importers.csv', index=False)
poor_model.to_csv('poor_importer.csv', index=False) 
log_results_df.to_csv('log_regressor_improved.csv', index=False)
smoothed_log_df.to_csv('smoothed_log_results.csv', index=False)
    


