import pandas as pd
import matplotlib.pyplot as plt
import seaborn as sns
import json
from sklearn.preprocessing import StandardScaler
from sklearn.cluster import KMeans

#--Cleaning the data--
df = pd.read_json('http://127.0.0.1:8000/api/v1/importer-demand')
#type:ignore
df = pd.json_normalize(df['data'], sep='_')#type:ignore

df= df.rename(columns={'robusta_(60kg_bags)':'Robusta_(60kg_Bags)',
                        'arabica_(60kg_bags)':'Arabica_(60kg_Bags)',
                        'total_(60kg_bags)': 'Total_(60kg_Bags)',
                        'importer':'Importer',
                        'country':'Country',
                        'continent':'Continent',
                        'yearsAsCustomer':'YearsAsCustomer',
                        'orderFreqPerYear':'OrderFreqPerYear',
                        'arabica_pct':'Arabica_pct',
                        'avgOrderSize':'AvgOrderSize',
                        }
                        )

#print(df[~df['Arabica_pct'].str.replace('.', '', regex=False).str.isnumeric()])
for col in ['Robusta_(60kg_Bags)', 'Arabica_(60kg_Bags)', 'Total_(60kg_Bags)',
            'YearsAsCustomer', 'OrderFreqPerYear', 'Arabica_pct', 'AvgOrderSize']:
    df[col] = pd.to_numeric(df[col], errors='coerce')

print("\nCleaned Data")
print(df.head())

#Extracting features for clustering
print("Available columns:", df.columns.tolist())

features = df[['Robusta_(60kg_Bags)', 'Arabica_(60kg_Bags)', 'Total_(60kg_Bags)', 'YearsAsCustomer', 'OrderFreqPerYear', 'Arabica_pct', 'AvgOrderSize']]

#---Using K-Means---
#Using the scaler
scaler = StandardScaler()
features_scaled = scaler.fit_transform(features)

#---Results----
kmeans = KMeans(n_clusters=3, random_state=42)
df['cluster'] =  kmeans.fit_predict(features_scaled)

for col in ['Arabica_pct','AvgOrderSize', 'Total_(60kg_Bags)']:
    df[col] = pd.to_numeric(df[col], errors='coerce').fillna(0)

cluster_summary = df.groupby('cluster')[[
    'Total_(60kg_Bags)', 'Robusta_(60kg_Bags)',
    'Arabica_(60kg_Bags)', 'AvgOrderSize', 'Arabica_pct'
]].mean().round(1)
cluster_summary.reset_index(inplace=True)

cluster_summary= cluster_summary.sort_values('Total_(60kg_Bags)', ascending=False).reset_index(drop=True)
labels = ['Large Mixed Buyers','Medium Buyers','Low Volume Buyers']
cluster_summary['label'] = labels[:len(cluster_summary)]
cluster_labels = dict(zip(cluster_summary['cluster'], cluster_summary['label']))

importers_by_cluster = df.groupby('cluster')['importer_name'].apply(list).to_dict()
top_importers = df.groupby('importer_name')['Total_(60kg_Bags)'].sum().reset_index()
top_importers = top_importers.sort_values(by='Total_(60kg_Bags)', ascending=True)

totals = {
    "Arabica": int(df['Arabica_(60kg_Bags)'].sum()),
    "Robusta": int(df['Robusta_(60kg_Bags)'].sum())
}

bar_data=[]
for index, row in cluster_summary.iterrows():
    bar_data.append({
        "cluster": int(row['cluster']),
        "Arabica_(60kg_Bags)": row['Arabica_(60kg_Bags)'],
        "Robusta_(60kg_Bags)": row['Robusta_(60kg_Bags)'],
        "AvgOrderSize": row['AvgOrderSize']
    })

radial_data =[]
for index, row in cluster_summary.iterrows():
    radial_data.append({
        "cluster": int(row['cluster']),
        "Total_(60kg_bags)": row['Total_(60kg_Bags)'],
        "Arabica_pct": row['Arabica_pct'],
        "AvgOrderSize": row['AvgOrderSize']
    })

with open('public/data/importer_radial_data.json', 'w') as f:
    json.dump(radial_data, f, indent=4)
with open('public/data/importer_cluster_labels.json', 'w') as f:
    json.dump(cluster_labels, f, indent=4)
with open('public/data/importer_by_cluster_labels.json', 'w') as f:
    json.dump(importers_by_cluster, f, indent=4)
with open('public/data/importer_clustered_bar.json', 'w') as f:
    json.dump(bar_data, f, indent=4)
with open('public/data/arabica_vs_robusta.json', 'w') as f:
    json.dump(totals, f, indent=4)

top_importers.to_json('public/data/top_importers.json', orient='records')

