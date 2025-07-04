<!--Apex Charts cdn-->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<!--Apex bar chart-->
<script type ="text/javascript">
var options = {
          series: [{
          data: [430, 448, 470, 540, 580, 690, 1100, 1200]
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
          categories: [ 'Canada', 'United Kingdom', 'Netherlands', 'Italy', 'France', 'Japan',
            'United States', 'China'
          ],
        }
        };

        var chartB = new ApexCharts(document.querySelector("#chart-b"), options);
        chartB.render();
</script>

<!--Apex donut chart-->
<script>
var options = {
          series: [45, 55],
          chart: {
          type: 'donut',
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
          size: '75%'
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
</script>

<!--Apex Line Chart-->
<script>
var options = {
          series: [{
            name: "Current Sales",
            data: [10, 41, 35, 51, 49, 62, 69, 91, 148]
          
        },
          {name: "Predicted Sales",
          data: [19, 98, 34, 75, 34, 72, 50, 81, 138]
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
          curve: 'smooth',
          width: 2
        },
        /*title: {
          text: 'Product Trends by Month',
          align: 'left'
        },*/
        grid: {
          row: {
            colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
            opacity: 0.5
          },
        },
        xaxis: {
          categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep'],
        }
        };

        var chartL = new ApexCharts(document.querySelector("#chart-l"), options);
        chartL.render();
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
<script>
document.addEventListener('DOMContentLoaded', () => {
var options = {
          series: [{
          name: 'Net Profit',
          data: [44, 55, 57, 56, 61, 58, 63, 60, 66]
        }, {
          name: 'Revenue',
          data: [76, 85, 101, 98, 87, 105, 91, 114, 94]
        }, {
          name: 'Free Cash Flow',
          data: [35, 41, 36, 26, 45, 48, 52, 53, 41]
        }],
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
          categories: ['Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct'],
        },
        yaxis: {
          title: {
            text: '$ (thousands)'
          }
        },
        fill: {
          opacity: 1
        },
        tooltip: {
          y: {
            formatter: function (val) {
              return "$ " + val + " thousands"
            }
          }
        }
        };

        var chartE = new ApexCharts(document.querySelector("#chart-e"), options);
        chartE.render();
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
