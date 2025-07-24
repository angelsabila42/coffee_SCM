<!--Apex Charts cdn-->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<!--Apex bar chart-->
<script type ="text/javascript">
document.addEventListener('DOMContentLoaded', async () => {
  const data = await fetch('/data/top_importers.json').then(res => res.json());

  const categories = data.map(item => item.importer_name);
  const seriesData = data.map(item => item["Total_(60kg_Bags)"]);

var options = {
          series: [{
          data: seriesData,
          name: 'Total 60kg Bags',
        }],
          chart: {
          type: 'bar',
          height: 350
        },

        title: {
          text: 'Top Importers'
        },

        plotOptions: {
          bar: {
            borderRadius: 4,
            borderRadiusApplication: 'end',
            horizontal: true,
          }
        },
        dataLabels: {
          enabled: false
        },
        xaxis: {
          categories: categories,
        },
        tooltip: {
          y:{
            formatter: val => val.toLocaleString() + 'bags'
          }
        }
        };

        var chartB = new ApexCharts(document.querySelector("#chart-b"), options);
        chartB.render();
  });
        
</script>

<!--Apex donut chart-->
<script>
document.addEventListener('DOMContentLoaded', async() => {
  const pieData = await fetch('/data/arabica_vs_robusta.json').then(res => res.json());

  const labels = Object.keys(pieData);
  const values = Object.values(pieData);

var options = {
          series: values,
          labels: labels,
          chart: {
          type: 'donut',
        },
        dataLabels: {
        enabled: false 
         },
        tooltip: {
          y:{
            formatter: function (val) {
              return val.toLocaleString() + ' bags';
            }
          }
        },

        legend: {
              position: 'bottom'
            },

        fill: {
          colors:['#f59e0b','#8B5CF6']
        }, 

        title: {
          text: 'Arabica vs Robusta for Vendor categories'
        },   

       plotOptions: {
      pie: {   
        donut: {
          size: '75%',
          labels: {
            show: true,
            value: {
              show: false
            }
          }
        }
      }
    },
  
            responsive: [{
          breakpoint: 480,
          options: {
            chart: {
              width: 200
            },
            legend: {
              position: 'bottom'
            }
          }
        }]
        };

        var chartD = new ApexCharts(document.querySelector("#chart-d"), options);
        chartD.render();
        });  
</script>

<!--Apex Line Chart-->
<script>
document.addEventListener('DOMContentLoaded', () => {
  const historicalURL = "/data/historical_annual_sales.json";
  const forecastURL = "/data/forecasted_annual_sales.json";
  Promise.all([
    fetch(historicalURL).then(res => res.json()),
    fetch(forecastURL).then(res => res.json())
  ])
  .then(([historical, forecast]) => {

    const actualSeries = historical.map(row => ({
      x:new Date(row.ds),
      y: parseFloat(row.actual)
    }));

      /*const fittedSeries = historical.map(row => ({
      x:new Date(row.ds),
      y: parseFloat(row.predicted)
    }));*/

    const forecastSeries = forecast.map(row => ({
      x:new Date(row.ds),
      y: parseFloat(row.forecast)
    }));

    if(actualSeries.length && forecastSeries.length){
      forecastSeries.unshift(actualSeries[actualSeries.length - 1]);
    }
 
var options = {
          series: [
        {
            name: "Actual Sales",
            data: actualSeries,
        },
       /* {
          name: "Fitted Sales",
          data: fittedSeries,
        },*/
        {
          name: "Forecasted Sales",
          data: forecastSeries,
        }
        ],
          chart: {
          height: 350,
          type: 'line',
          zoom: {
            enabled: false
          }
        },

        colors:['#10b981',/*'#3b82f6',*/'#d97706'],

        dataLabels: {
          enabled: false
        },
        stroke: {
          curve: 'straight',
          width: [2,2],
          dashArray: [0,5]
        },
        title: {
          text: 'Coffee Export Sales Forecast',
          align: 'left'
        },
        grid: {
          row: {
            colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
            opacity: 0.5
          },
        },

        annotations:{
          xaxis: [
            {
              x: new Date('2024-07-07').getTime(),
              strokeDashArray: 4,
              borderColor: '#F97316',
              label: {
                //text: 'Forecast Start',
                style: {
                  color: '#fff',
                  background: '#F97316'
                }
              }
            },
            {
              x: new Date('2024-07-07').getTime(),
              x2: new Date('2029-07-07').getTime(),
              fillColor: '#FEF3C7',
              opacity:0.3,
              label:{
                //text: 'Forecast Period',
                style: {
                  color: '#fff',
                  background: '#F59E0B'
                }
              }
            }
          ]
        },

        xaxis: {
          title: {text: 'Year'},
          type: 'datetime',
          min: new Date('2015-07-07').getTime(),
        },

        yaxis: {
          title: {text: 'USD Value'},
          labels: {
            formatter: function (value) {
              return '$' + (value / 1_000_000).toFixed(1) + 'M';
            }
          }
        },

        };

        var chartL = new ApexCharts(document.querySelector("#chart-l"), options);
        chartL.render();
        });
  });
</script>

<!--Animations-->
<script>
chart: {
    animations: {
        enabled: true,
        speed: 800,
        animateGradually: {
            enabled: true,
            delay: 150
        },
        dynamicAnimation: {
            enabled: true,
            speed: 350
        }
    }
}
</script>

<!--Apex Pie chart-->
<!--1-->
@if(isset($deliveryStatusData))
<script>
document.addEventListener('DOMContentLoaded', () => {
 var options = {
          series: {!! json_encode($deliveryStatusData->pluck('total')) !!},
          chart: {
          type: 'pie',
        },

        legend: {
              position: 'bottom'
            },

        fill: {
          colors:['#f59e0b','#10b981']
        },   

        title: {
          text: 'Deliveries'
        }, 

        labels: {!! json_encode($deliveryStatusData->pluck('status')) !!},
        responsive: [{
          breakpoint: 480,
          options: {
            chart: {
              width: 200
            },
            legend: {
              position: 'bottom'
            }
          }
        }]
        };

        var chartC = new ApexCharts(document.querySelector("#chart-c"), options);
        chartC.render();
          });
</script>
@endif

<!--2-->
<script>
 var options = {
          series: [15, 85],
          chart: {
          type: 'pie',
        },

        legend: {
              position: 'bottom'
            },

        fill: {
          colors:['#f59e0b','#10b981']
        },

        title: {
          text: 'Deliveries'
        },    

        labels: ['Completed', 'Pending'],
        responsive: [{
          breakpoint: 480,
          options: {
            chart: {
              width: 200
            },
            legend: {
              position: 'bottom'
            }
          }
        }]
        };

        var chartZ = new ApexCharts(document.querySelector("#chart-z"), options);
        chartZ.render();
</script>

<!--Apex Column Chart-->
<!--analytics-->
<!--row 2-->
<script>
document.addEventListener('DOMContentLoaded', async () => {
  const barData = await fetch('/data/importer_clustered_bar.json').then(res => res.json());
  const cluster_labels = await fetch('/data/importer_cluster_labels.json').then(res => res.json());
  const importersByCluster = await fetch('/data/importer_by_cluster_labels.json').then(res => res.json());
  const radialData = await fetch('/data/importer_radial_data.json').then(res => res.json());

  const series = [
    {
      name: 'Avg Order Size',
      data: barData.map(item=> item.AvgOrderSize),
    },
    {
      name: 'Robusta 60kg Bags',
      data: barData.map(item=> item["Robusta_(60kg_Bags)"]),
    },
    {
      name: 'Arabica 60kg Bags',
      data: barData.map(item=> item["Arabica_(60kg_Bags)"]),
    },
  ];

  const categories = barData.map(item => cluster_labels[item.cluster] || `Cluster ${item.cluster}`);
var barOptions = {
          series: series,
          chart: {
          type: 'bar',
          height: 350
        },
        plotOptions: {
          bar: {
            horizontal: false,
            columnWidth: '55%',
            borderRadius: 5,
            borderRadiusApplication: 'end'
          },
        },
        dataLabels: {
          enabled: false
        },
        stroke: {
          show: true,
          width: 2,
          colors: ['transparent']
        },
        xaxis: {
          categories: categories,
        },
        yaxis: {
          title: {
            text: 'Value'
          }
        },
        fill: {
          opacity: 1
        },
        title: {
          text: 'Sales Performance'
        },
        tooltip: {
          y: {
            formatter: function (val, {series, seriesIndex, dataPointIndex, w }) {
              if(seriesIndex === 0){
                return val.toLocaleString();
              }else if (seriesIndex === 1){
                return val.toFixed(2) + '%';
              }else if (seriesIndex === 2){
                return val.toLocaleString() + 'bags';
              }
              return val;
            }
          }
        }
        };

        var barChart = new ApexCharts(document.querySelector("#chart-e"), barOptions);
        barChart.render();

//Radial Bar
  const radialSeries = radialData.map(item => item["Total_(60kg_bags)"]);
  const radialLabels = radialData.map(item => cluster_labels[item.cluster]);

  const totalValue = radialSeries.reduce((a, b) => a + b, 0);
  const normalisedSeries = radialSeries.map(val => Math.round((val / totalValue) * 100 * 100) / 100);

 
var radialOptions = {
  chart: {
    height: 350,
    type: "radialBar",
  },
  series: normalisedSeries,
  labels: radialLabels,
  plotOptions: {
    radialBar: {
      dataLabels: {
        name:{fontSize: '16px'},
        value: {
          fontSize: '14px',
          },
          total: {
          show: true,
          label: 'Total bags',
          formatter: function (){
            return totalValue.toLocaleString();
          }
        }
      },
    }
  },
  stroke: {
         lineCap: "round",
      },
  title: {
        text: 'Coffee Sold'
        },
};

var radialChart = new ApexCharts(document.querySelector("#chart-r"), radialOptions);
radialChart.render();
});
</script>

<!--Analytics Row 3-->
<script>
document.addEventListener('DOMContentLoaded', async () => {
  const radialData = await fetch('/data/vendor_cluster_radial_bar.json').then(res => res.json());

//Radial Bar
  const radialSeries = radialData.map(item => item.total_bags);
  const radialLabels = radialData.map(item => item.cluster_label);

  const totalValue = radialSeries.reduce((a, b) => a + b, 0);
  const normalisedSeries = radialSeries.map(val=> +(val/totalValue * 100).toFixed(2));
 
var radialOptions = {
  chart: {
    height: 350,
    type: "radialBar",
  },
  series: normalisedSeries,
  labels: radialLabels,
  plotOptions: {
    radialBar: {
      dataLabels: {
        name:{fontSize: '16px'},
        value: {
          fontSize: '14px',
          },
          total: {
          show: true,
          label: 'Total bags',
          formatter: function (){
            return totalValue.toLocaleString();
          }
        }
      }
    }
  },
  stroke: {
         lineCap: "round",
      },
  title: {
        text: 'Coffee Purchased'
      },
  tooltip: {
          enabled: true,
          y: {
            formatter: function (val, opts) {
              const vendors = radialData[opts.seriesIndex].vendor || "No Suppliers";
              return val.toLocaleString() + " bags\nSuppliers: " + vendors;
            }
          }
        },    
};

var radialChart = new ApexCharts(document.querySelector("#chart-k"), radialOptions);
radialChart.render();
});
</script>
<!--Stacked Bar--row 2-->
<script>
document.addEventListener('DOMContentLoaded', async() => {
  const stackedData = await fetch('/data/vendor_cluster_stacked_bar.json').then(res => res.json());
  const robustaSeries = stackedData.map(item => item.robusta);
  const arabicaSeries = stackedData.map(item => item.arabica);
  const categories = stackedData.map(item => item.cluster_label); 

  var options = {
          series: [{
          name: 'Robusta 60kg Bags',
          data: robustaSeries
        }, {
          name: 'Arabica 60kg Bags',
          data: arabicaSeries
        }],
          chart: {
          type: 'bar',
          height: 350,
          stacked: true,
          stackType: '100%'
        },
        plotOptions: {
          bar: {
            horizontal: true,
          },
        },
        stroke: {
          width: 1,
          colors: ['#fff']
        },
        title: {
          text: 'Arabica vs Robusta for Vendor categories'
        },
        xaxis: {
          categories: categories,
        },
        tooltip: {
          y: {
            formatter: function (val) {
              return val + " bags"
            }
          }
        },
        fill: {
          opacity: 1
        
        },
        legend: {
          position: 'top',
          horizontalAlign: 'right',
          offsetX: 40
        }
        };

        var stackedBar = new ApexCharts(document.querySelector("#chart-g"), options);
        stackedBar.render();
});
</script>

<!--Forecasting line graph Row 3-->
<script>
document.addEventListener('DOMContentLoaded', async () => {
  function stringToColor(str){
    let hash = 0;
    for (let i = 0; i < str.length; i++){
      hash = str.charCodeAt(i) + ((hash << 5) - hash); 
    }
    const hue = (hash) % 360;
    return `hsl(${hue}, 70%, 50%)`;
  }

  const historicalDataURL = '/data/historical_demand_data.json';
  const forecastGoodURL = '/data/forecast_good.json';
  const forecastLogURL = '/data/forecast_log.json';
  const forecastSmoothURL = '/data/forecast_smoothed.json';

  const[historicalData, forecastGood, forecastLog, forecastSmooth] = await Promise.all([
    fetch(historicalDataURL).then(res => res.json()),
    fetch(forecastGoodURL).then(res => res.json()),
    fetch(forecastLogURL).then(res => res.json()),
    fetch(forecastSmoothURL).then(res => res.json())
  ]);

  const groupBy = (data, key) => {
    return data.reduce((acc, item) => {
      const group = item[key];
      if(!acc[group]) acc[group] = [];
      acc[group].push(item);
      return acc;
    }, {});
  };

    const allImporters  = new Set([
        ...historicalData.map(item => item.Importer),
    ]);

    const historicalByImporter = groupBy(historicalData, 'Importer');
    const goodByImporter = groupBy(forecastGood, 'Importer');
    const logByImporter = groupBy(forecastLog, 'Importer');
    const smoothedByImporter = groupBy(forecastSmooth,'Importer');

    const allFirstForecastDates = [
      ...Object.values(goodByImporter).flat(),
      ...Object.values(logByImporter).flat(),
      ...Object.values(smoothedByImporter).flat()
          ]
    .map(entry => new Date(entry.date).getTime());

     const forecastStartDate = Math.min(...allFirstForecastDates);

    const allForecastDates = [
      ...Object.values(goodByImporter).flat(),
      ...Object.values(logByImporter).flat(),
      ...Object.values(smoothedByImporter).flat()
    ];
const chartEndDate = Math.max(...allForecastDates.map(d => new Date(d.date).getTime()));


    const series = [];

    allImporters.forEach(imp => {

      series.push({
        name: `${imp} (Actual)`, 
        data: (historicalByImporter[imp] || []).map(row => ({
          x:new Date(row.date).getTime(),
          y:parseFloat(row.actual)
      })),
       color: stringToColor(imp),
      });


  if(goodByImporter[imp]){
    const forecastData = goodByImporter[imp].map(row => ({
      x:new Date(row.date).getTime(),
      y:parseFloat(row.forecast)
    }));

    const actualData = historicalByImporter[imp] || [];
    const lastActual = actualData[actualData.length - 1];
    const firstForecast = forecastData[0];
      if(lastActual && firstForecast && new Date(lastActual.date) < new Date(firstForecast.x)){
        forecastData.unshift({
          x: new Date(lastActual.date).getTime(),
          y: lastActual.actual
        });
      }
      
    series.push({
      name: `${imp} (Forecast)`,
      data: forecastData,
      color: stringToColor(imp),
      dashStyle: 'dash',
      showInLegend: false 
    });
  }

  else if (logByImporter[imp]){
    const forecastData = logByImporter[imp].map(row => ({
        x:new Date(row.date).getTime(),
        y:parseFloat(row.forecast)
      }));

    const actualData = historicalByImporter[imp] || [];  
    const lastActual = actualData[actualData.length - 1];
    const firstForecast = forecastData[0];
      if(lastActual && firstForecast && new Date(lastActual.date) < new Date(firstForecast.x)){
        forecastData.unshift({
          x: new Date(lastActual.date).getTime(),
          y: lastActual.actual
        });
      }

      series.push({
        name: `${imp} (Log Forecast)`,
        data: forecastData,
        color: stringToColor(imp),
        showInLegend: false 
      });
 }
  else if(smoothedByImporter[imp]){
    const forecastData = smoothedByImporter[imp].map(row => ({
        x:new Date(row.date).getTime(),
        y:parseFloat(row.forecast)
      }));

    const actualData = historicalByImporter[imp] || [];  
    const lastActual = actualData[actualData.length - 1];
    const firstForecast = forecastData[0];
      if(lastActual && firstForecast && new Date(lastActual.date) < new Date(firstForecast.x)){
        forecastData.unshift({
          x: new Date(lastActual.date).getTime(),
          y: lastActual.actual
        });
      }

        series.push({
        name: `${imp} (Smoothed Forecast)`,
        data: forecastData,
        color: stringToColor(imp),
        showInLegend: false 
      });
  }
}); 

  var options = {
          series: series,
          chart: {
          height: 500,
          type: 'line',
          zoom: {
            enabled: true
          }
        },
        dataLabels: {
          enabled: false
        },
        stroke: {
          curve: 'straight',
          width: 2,
          dashArray: series.map(s => s.name.includes('Actual') ? 0 : 5)
        },

      annotations: {
  xaxis: [
    {
      
      x: forecastStartDate - (365 * 24 * 60 * 60 * 1000),
      strokeDashArray: 4,
      borderColor: '#F59E0B',
      label: {
        text: 'Forecast Start',
        orientation: 'horizontal',
        offsetY: -10,
        style: {
          color: '#fff',
          background: '#F59E0B',
          fontWeight: 600,
        },
      },
    },
    {
      
      x: forecastStartDate - (365 * 24 * 60 * 60 * 1000),
      x2: chartEndDate,
      fillColor: '#FEF3C7',
      opacity: 0.2,
      borderColor: 'transparent',
      label: {
        //text: 'Forecast Period',
        style: {
          background: '#FEF3C7',
          color: '#92400E',
          fontWeight: 600,
        },
      },
    }
  ]
},
        tooltip:{
          shared: true,
          intersect: false,
          x: {format: 'yyyy'},
          y:{
            formatter : function(val){
              if(val >= 1e9) return (val/1e9).toFixed(2) + 'B';
              if(val >= 1e6) return (val/1e6).toFixed(2) + 'M';
              return Number(val).toFixed(0);
            }
          }
        },

        legend:{
          show: true,
          showForSingleSeries: false,
          formatter: function(seriesName, opts){
            if(seriesName.includes('(Actual)')) {
              return seriesName;
            }
            return '';
          },
         
          //position: 'bottom'
        },
        title: {
          text: 'Product Trends by Month',
          align: 'left'
        },
        grid: {
          row: {
            colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
            opacity: 0.5
          },
        },
        xaxis: {
          type: 'datetime',
          title: {text: 'Year'}
        },
        yaxis: {
          title: {
            text: 'Quantity (60kg Bags)'
          },
          labels: {
            formatter: function(val){
              return Number(val).toFixed(0);
            }
          }
        }
        };
    const chartForecastDemand = new ApexCharts(document.querySelector("#chart-x"), options);
    chartForecastDemand.render(); 
 });
</script>

<!--Home-->
<script>
document.addEventListener('DOMContentLoaded', () => {
        var options = {
          series: [{
            data: [10, 70, 35, 51, 49, 62, 69, 91, 148]
        }],
          chart: {
          height: '100%',
          type: 'line',
          sparkline: {
            enabled: true
          },
          toolbar: {
            enabled: false
          },
          zoom: {
            enabled: false
          }
        },
        dataLabels: {
          enabled: false
        },
        stroke: {
          curve: 'straight',
          width: 1,
        },
        tooltip: {
          enabled: false
        },
        markers: {
          size: 0,
        },
        xaxis: {
          categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep'],
        }
        };

        var chartJ = new ApexCharts(document.querySelector("#chart-j"), options);
        chartJ.render();
});
</script>

<!--Vendor Home-->
<script>
document.addEventListener("DOMContentLoaded", async () => {
  const response = await fetch('/api/v1/outgoing-order/vendor-chart');
  const orders = await response.json();

  const dateCounts = {};

  orders.data.forEach(order => {
    const date = new Date(order.created_at).toISOString().split('T')[0];
    dateCounts[date] = (dateCounts[date] || 0) + 1;
  });

  const chartData = Object.entries(dateCounts).map(([date, count]) => ({
    x: date,
    y: count
  })).sort((a, b) => new Date(a.x) - new Date(b.x));

  var options = {
    series: [{
      name: 'Orders Received',
      data: chartData
    }],
    chart: {
      height: '373',
      type: 'line',
      toolbar: {
        enabled: false
      },
      zoom: {
        enabled: false
      }
    },
    dataLabels: {
      enabled: false
    },
    stroke: {
      curve: 'smooth',
      width: 2,
    },
    tooltip: {
      enabled: true
    },
    markers: {
      size: 4,
    },
    grid: {
      row: {
        colors: ['#f3f3f3', 'transparent'],
        opacity: 0.5
      },
    },
    xaxis: {
      type: 'datetime',
      title: {
        text: 'Date'
      }
    },
    yaxis: {
      title: {
        text: 'Number of Orders'
      },
      min: 0,
      forceNiceScale: true
    }
  };

  var chartV = new ApexCharts(document.querySelector("#chart-v"), options);
  chartV.render();
});

</script>


