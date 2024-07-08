var scoresChart;

function getData() {
    console.log('getData function called');
    $.ajax({
        type: 'GET',
        url: 'detailPsikolog.php',
        data: {
            functionName: 'getDataPatient',
            psychologist_id: psychologist_id
        },
        success: function(response) {
            let data = JSON.parse(response);
            let counts = {
                'Completed': 0,
                'Scheduled': 0,
                'Cancelled': 0
            };

            // Array warna untuk setiap label
            let colors = {
                'Completed': 'rgba(150, 100, 232, 0.6)',
                'Scheduled': 'rgba(255, 99, 132, 0.6)',
                'Cancelled': 'rgba(255, 159, 64, 0.6)'
            };

            // Menghitung jumlah konsultasi untuk setiap status
            data.forEach(function(consultation) {
                if (consultation.status in counts) {
                    counts[consultation.status]++;
                }
            });

            const pat = document.getElementById('report').getContext('2d');

            // Jika sudah ada chart, hancurkan terlebih dahulu
            if (scoresChart) {
                scoresChart.destroy();
            }

            scoresChart = new Chart(pat, {
                type: 'doughnut',
                data: {
                    labels: Object.keys(counts),
                    datasets: [{
                        label: 'Jumlah Konsultasi berdasarkan Status',
                        backgroundColor: Object.values(colors),
                        borderColor: Object.values(colors),
                        data: Object.values(counts),
                        borderWidth: 1
                    }]
                },
                options: {
                    plugins: {
                        datalabels: {
                            formatter: (value, context) => {
                                let sum = 0;
                                let dataArr = context.chart.data.datasets[0].data;
                                dataArr.map(data => {
                                    sum += data;
                                });
                                let percentage = (value * 100 / sum).toFixed(2) + "%";
                                return percentage;
                            },
                            color: '#fff',
                            display: 'auto'
                        }
                    }
                },
                plugins: [ChartDataLabels]
            });
        }
    });
}

$(document).ready(function() {
    getData();
});
