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
  const historicalURL = "/data/historical_sales.json";
  const forecastURL = "/data/forecasted_sales.json";
  Promise.all([
    fetch(historicalURL).then(res => res.json()),
    fetch(forecastURL).then(res => res.json())
  ])
  .then(([historical, forecast]) => {
    const historicalSeries = historical.map(row => ({
      x:new Date(row.year.toString()),
      y: parseFloat(row['Value in US Dollars'])
    }));

    const forecastSeries = forecast.map(row => ({
      x:new Date(row.year.toString()),
      y: parseFloat(row['Value in US Dollars'])
    }));
    const lastActualPoint = historicalSeries[historicalSeries.length - 1];
    forecastSeries.unshift(lastActualPoint);
    //console.log('Forecast Years:', forecastSeries.map(d => d.x));
 
var options = {
          series: [
        {
            name: "Actual Sales",
            data: historicalSeries
          
        },
        {
          name: "Predicted Sales",
          data: forecastSeries
        }],
          chart: {
          height: 350,
          type: 'line',
          zoom: {
            enabled: false
          }
        },

        colors:['#10b981','#d97706'],

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
              x: new Date('2023').getTime(),
              strokeDashArray: 4,
              borderColor: '#F97316',
              label: {
                text: 'Forecast Start',
                style: {
                  color: '#fff',
                  background: '#F97316'
                }
              }
            },
            {
              x: new Date('2023').getTime(),
              x2: new Date('2029').getTime(),
              fillColor: '#FEF3C7',
              opacity:0.3,
              label:{
                text: 'Forecast Period',
                style: {
                  color: '#111',
                  background: '#F59E0B'
                }
              }
            }
          ]
        },

        xaxis: {
          title: {text: 'Year'},
          type: 'datetime',
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
<script>
 var options = {
          series: [44, 55],
          chart: {
          type: 'pie',
        },

        legend: {
              position: 'bottom'
            },

        fill: {
          colors:['#f59e0b','#10b981']
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

        var chartC = new ApexCharts(document.querySelector("#chart-c"), options);
        chartC.render();
</script>

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
  const normalisedSeries = radialSeries.map(val=> (val/totalValue * 100).toFixed(2));
 
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
      }
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
  const normalisedSeries = radialSeries.map(val=> (val/totalValue * 100).toFixed(2));
 
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
})
</script>

<!--Vendor Home-->
<script>
document.addEventListener('DOMContentLoaded', () => {
        var options = {
          series: [{
            name: "Orders",
            data: [10, 41, 35, 51, 49, 62, 69, 91, 148]
        }],
          chart: {
          height: 350,
          type: 'line',
          zoom: {
            enabled: false
          }
        },
        dataLabels: {
          enabled: false
        },
        stroke: {
          curve: 'straight'
        },
        grid: {
          row: {
            colors: ['#ffffff', 'transparent'], // takes an array which will be repeated on columns
            opacity: 0.5
          },
        },
        xaxis: {
          categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep'],
        }
        };

        var chartV = new ApexCharts(document.querySelector("#chart-v"), options);
        chartV.render();
        });
</script>
