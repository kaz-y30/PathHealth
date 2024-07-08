function getData() {
    $.ajax({
        type: 'GET',
        url: 'backend.php',
        data: {
            functionName: 'getDiagnosaPatient',
            psychologist_id: psychologist_id
        },
        success: function(response) {
            let data = JSON.parse(response);
            let counts = {
                'PTSD': 0,
                'Depression': 0,
                'Anxiety': 0,
                'Stress': 0,
                'OCD': 0,
                'Bipolar Disorder': 0,
            };

            let colors = {
                'PTSD': 'rgba(75, 192, 192, 0.8)',
                'Depresi': 'rgba(75, 192, 192, 0.8)',
                'Anxiety': 'rgba(75, 192, 192, 0.8)',
                'Stress': 'rgba(75, 192, 192, 0.8)',
                'OCD': 'rgba(75, 192, 192, 0.8)',
                'Bipolar Disorder': 'rgba(75, 192, 192, 0.8)'
            };

            data.forEach(function(mentalhealthtests) {
                if (mentalhealthtests.potential_diagnosis in counts) {
                    counts[mentalhealthtests.potential_diagnosis]++;
                }
            });

            const diagnosa = document.getElementById('diagnosaPatient').getContext('2d');

            new Chart(diagnosa, {
                type: 'bar',
                data: {
                    labels: Object.keys(counts),
                    datasets: [{
                        label: 'Diagnosa Pasien',
                        backgroundColor: Object.values(colors),
                        borderColor: Object.values(colors),
                        data: Object.values(counts),
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1,
                                callback: function(value) { 
                                    if (Number.isInteger(value)) {
                                        return value; 
                                    }
                                }
                            }
                        }
                    }
                }
            });
        }
    });

    $.ajax({
        type: 'GET',
        url: 'backend.php',
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

            let colors = {
                'Completed': 'rgba(150, 100, 232, 0.6)',
                'Scheduled': 'rgba(255, 99, 132, 0.6)',
                'Cancelled': 'rgba(255, 159, 64, 0.6)'
            };

            data.forEach(function(consultation) {
                if (consultation.status in counts) {
                    counts[consultation.status]++;
                }
            });

            const pat = document.getElementById('chartPatient').getContext('2d');

            new Chart(pat, {
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
                    responsive: true,
                    maintainAspectRatio: false,
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