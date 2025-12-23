var chartSampleOptions = {
    chart: {
      type: 'area',
      height: 400,
      stacked: false,
      toolbar: {
        show: false
      },
      zoom: {
        enabled: false
      }
    },
    colors: ['#4a90e2', '#00bcd4'],
    dataLabels: {
      enabled: false
    },
    stroke: {
      curve: 'smooth',
      width: 3
    },
    series: [
      {
        name: 'Revenue',
        data: monthlyLoanCounts
      }
    ],
    markers: {
      size: 4,
      hover: {
        size: 7
      }
    },
    fill: {
      type: 'gradient',
      gradient: {
        shadeIntensity: 1,
        opacityFrom: 0.6,
        opacityTo: 0.1,
        stops: [0, 90, 100]
      }
    },
    grid: {
      borderColor: '#e7e7e7',
      strokeDashArray: 4,
      xaxis: {
        lines: {
          show: true
        }
      },
      yaxis: {
        lines: {
          show: true
        }
      }
    },
    xaxis: {
      categories: months,
      axisBorder: {
        show: true,
        color: '#ccc'
      },
      axisTicks: {
        show: true,
        color: '#ccc'
      },
      labels: {
        style: {
          colors: '#666',
          fontSize: '12px'
        }
      }
    },
    yaxis: {
      labels: {
        style: {
          colors: '#666',
          fontSize: '12px'
        }
      }
    },
    tooltip: {
      shared: true,
      intersect: false,
      theme: 'light'
    },
    legend: {
      position: 'top',
      horizontalAlign: 'center',
      markers: {
        radius: 12,
        width: 12,
        height: 12,
      }
    }
  };

  var chartSample = new ApexCharts(document.querySelector("#chartSample"), chartSampleOptions);
  chartSample.render();