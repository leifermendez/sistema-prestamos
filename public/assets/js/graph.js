// function graphics(data, labels, label, id) {
//     const ctx = document.getElementById(id).getContext('2d');
//     const myChart = new Chart(ctx, {
//         type: 'bar',
//         data: {
//             labels: labels,
//             datasets: [
//                 {
//                     label: label,
//                     data: data, // 0=> lastWeekend, 1=> thisWeekend
//                     backgroundColor: [
//                         'rgba(75, 192, 192, 0.2)',
//                         'rgba(54, 162, 235, 0.2)',
//                     ],
//                     borderColor: [
//                         'rgb(75, 192, 192)',
//                         'rgba(54, 162, 235, 1)',
//                     ],
//                     borderWidth: 1
//                 }
//             ]
//         },
//         options: {
//             maintainAspectRatio: false,
//             scales: {
//                 yAxes: [{
//                     stacked: true,
//                     gridLines: {
//                         display: true,
//                         color: "rgba(255,99,132,0.2)"
//                     }
//                 }],
//                 xAxes: [{
//                     gridLines: {
//                         display: false
//                     }
//                 }]
//             }
//         }
//     });
// }

function graphicsDays(data, labels, total, label, id) {
    // Chart.plugins.register(ChartDataLabels);
    const ctx = document.getElementById(id).getContext('2d');
    const myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Semana pasada',
                    data: data.lastWeek, // 0=> lastWeekend, 1=> thisWeekend
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
                    data: data.thisWeek, // 0=> lastWeekend, 1=> thisWeekend
                    borderWidth: 1,
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.2)',
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                    ],
                }
            ]
        },
        options: {
            plugins: {
                title: {
                    display: true,
                    text: 'Totales = Semana pasada: '+total.lastWeek+' - Semana elegida: '+total.thisWeek
                }
            },
            maintainAspectRatio: false,
            scales: {
                yAxes: [{
                    stacked: true,
                    gridLines: {
                        display: true,
                        color: "rgba(255,99,132,0.2)"
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