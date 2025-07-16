import pandas as pd
import matplotlib.pyplot as plt
import seaborn as sns
from sklearn.preprocessing import StandardScaler
from sklearn.cluster import KMeans

#--Cleaning the data--
df= pd.read_json('http://127.0.0.1:8000/api/v1/vendor-cluster')
#type:ignore
df = pd.json_normalize(df['data'], sep='_')#type:ignore

df= df.rename(columns={'robusta_(60kg_bags)':'Robusta_(60kg_Bags)',
                        'arabica_(60kg_bags)':'Arabica_(60kg_Bags)',
                        'total_(60kg_bags)': 'Total_(60kg_Bags)',
                        'vendor_region':'Region',
                        'vendor_name':'Vendor',
                        'avgPricePerKg_UGX':'AvgPricePerKg_UGX',
                        'yearsActive':'YearsActive',
                        'vendor_organicCertified':'OrganicCertified',
                        'arabica_pct':'Arabica_pct',
                        'marketShare_pct':'MarketShare_pct',
                        }
                        )
print(df.columns)


# print("\nCleaned Data")
# print(df.head())

#Extracting features for clustering
features = ['Robusta_(60kg_Bags)', 'Arabica_(60kg_Bags)', 'AvgPricePerKg_UGX', 'YearsActive', 'MarketShare_pct', 'Arabica_pct', 'OrganicCertified']

X = df[features]

#---Using K-Means---
#Using the scaler
scaler = StandardScaler()
features_scaled = scaler.fit_transform(X)

#---Results----
kmeans = KMeans(n_clusters=3, random_state=42)
df['cluster'] =  kmeans.fit_predict(features_scaled)

cluster_summary = df.groupby('cluster')[[
    'Robusta_(60kg_Bags)', 'Arabica_(60kg_Bags)',
    'AvgPricePerKg_UGX', 'YearsActive', 'MarketShare_pct',
    'Arabica_pct', 'OrganicCertified','Total_(60kg_Bags)'
]].mean().round(1)
cluster_summary.reset_index(inplace=True)

cluster_summary= cluster_summary.sort_values('Total_(60kg_Bags)', ascending=False).reset_index(drop=True)
labels = ['High Volume Robusta Suppliers','Mid-Scale Conventional Suppliers','Small-Scale Arabica Specialists']
cluster_summary['label'] = labels[:len(cluster_summary)]
cluster_labels = dict(zip(cluster_summary['cluster'], cluster_summary['label']))
df['cluster_label'] = df['cluster'].map(cluster_labels)

# print("\nCluster Profiles: ")
# print(cluster_summary)

#Expoting the results
radial_data =(
    df.groupby('cluster_label')
    .agg({
        'Total_(60kg_Bags)': 'sum',
        'Vendor': lambda x: list(x.unique())
    })
    .rename(columns={'Total_(60kg_Bags)': 'total_bags'})
    .reset_index()
)
radial_data['vendor'] = radial_data['Vendor'].apply(lambda x: ', '.join(sorted(x)))
radial_data.to_json('public/data/vendor_cluster_radial_bar.json', orient='records')

stacked_data =(
    df.groupby('cluster_label')
    .agg({
        'Vendor': lambda x: list(x.unique()),
        'Robusta_(60kg_Bags)': 'sum',
        'Arabica_(60kg_Bags)': 'sum'
    })
    .rename(columns={'Robusta_(60kg_Bags)': 'robusta', 'Arabica_(60kg_Bags)': 'arabica'})
    .reset_index()   
)
stacked_data['vendor'] = stacked_data['Vendor'].apply(lambda x: ', '.join(sorted(x)))

stacked_data.to_json('public/data/vendor_cluster_stacked_bar.json', orient='records')


