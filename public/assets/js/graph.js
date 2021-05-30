function graphics(data, labels, label, id) {
    const ctx = document.getElementById(id).getContext('2d');
    const myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [labels[0]+' \t\t•\t\t '+labels[1]],
            datasets: [
                {
                    label: 'Semana pasada',
                    data: [data[1]],
                    borderWidth: 1,
                    backgroundColor: [
                        'rgba(235,54,54,0.2)',
                    ],
                    borderColor: [
                        'rgb(235,54,54)',
                    ],
                },
                {
                    label: 'Esta semana',
                    data: [data[0]],
                    borderWidth: 1,
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.2)',
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                    ]
                }
            ]
        },
        options: {
            title: {
                display: true,
                text: label
            },
            showTooltips: false,
            hover: {
                animationDuration: 0
            },
            animation: {
                duration: 1,
                onComplete: function() {
                    const chartInstance = this.chart,
                        ctx = chartInstance.ctx;

                    ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
                    ctx.textAlign = 'center';
                    ctx.textBaseline = 'bottom';

                    this.data.datasets.forEach(function(dataset, i) {
                        const meta = chartInstance.controller.getDatasetMeta(i);
                        meta.data.forEach(function(bar, index) {
                            const data = dataset.data[index];
                            ctx.fillText(data, bar._model.x, bar._model.y - 5);
                        });
                    });
                }
            },
            maintainAspectRatio: false,
            scales: {
                yAxes: [{
                    stacked: false,
                    gridLines: {
                        display: true,
                        color: "rgba(255,99,132,0.2)"
                    },
                    ticks: {
                        beginAtZero: true
                    }
                }],
                xAxes: [{
                    gridLines: {
                        display: false
                    }
                }]
            }
        }
    });
}

function graphicsDays(data, labels, total, label, id) {
    // Chart.plugins.register(ChartDataLabels);
    // const ctx = document.getElementById(id).getContext('2d');
    const dataSet = {
        labels: labels,
        datasets: [
            {
                label: 'Semana pasada',
                data: data.lastWeek, //
                borderWidth: 1,
                backgroundColor: [
                    'rgba(235,54,54,0.2)',
                    'rgba(235,54,54,0.2)',
                    'rgba(235,54,54,0.2)',
                    'rgba(235,54,54,0.2)',
                    'rgba(235,54,54,0.2)',
                    'rgba(235,54,54,0.2)',
                ],
                borderColor: [
                    'rgb(235,54,54)',
                    'rgb(235,54,54)',
                    'rgb(235,54,54)',
                    'rgb(235,54,54)',
                    'rgb(235,54,54)',
                    'rgb(235,54,54)',
                ],
            },
            {
                label: 'Esta semana',
                data: data.thisWeek,
                borderWidth: 1,
                backgroundColor: [
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                ],
                borderColor: [
                    'rgba(54, 162, 235, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(54, 162, 235, 1)',
                ],
            }
        ]
    };
    const options = {
        title: {
            display: true,
            text: label+': \t Totales = Semana pasada: '+total.lastWeek+' - Semana elegida: '+total.thisWeek
        },
        showTooltips: false,
        hover: {
            animationDuration: 0
        },
        animation: {
            duration: 1,
            onComplete: function() {
                const chartInstance = this.chart,
                    ctx = chartInstance.ctx;

                ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
                ctx.textAlign = 'center';
                ctx.textBaseline = 'bottom';

                this.data.datasets.forEach(function(dataset, i) {
                    const meta = chartInstance.controller.getDatasetMeta(i);
                    meta.data.forEach(function(bar, index) {
                        const data = dataset.data[index];
                        ctx.fillText(data, bar._model.x, bar._model.y - 5);
                    });
                });
            }
        },
        maintainAspectRatio: false,
        scales: {
            yAxes: [{
                stacked: false,
                gridLines: {
                    display: true,
                    color: "rgba(255,99,132,0.2)"
                },
                ticks: {
                    beginAtZero: true
                }
            }],
            xAxes: [{
                gridLines: {
                    display: false
                }
            }]
        }
    };
    Chart.Bar(id, {
        options: options,
        data: dataSet
    });
    //     new Chart(ctx, {
    //     dataSet,
    //     options
    // });
}

// scales: {
//     yAxes: [{
//         stacked: false,
//         gridLines: {
//             display: true,
//             color: "rgba(255,99,132,0.2)"
//         },
//         ticks: {
//             beginAtZero: true
//         }
//     }],
//         xAxes: [{
//         gridLines: {
//             display: false
//         }
//     }]
// }