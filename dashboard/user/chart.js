var scoresChart;

function getData() {
    $.ajax({
        type: 'GET',
        url: 'backend.php',
        data: {
            functionName: 'getMentalHealthScores',
            user_id: user_id
        },
        success: function(response) {
            let data = JSON.parse(response);

            // Assuming there's only one set of scores to display in the pie chart
            if (data.length > 0) {
                let score = data[0].score;
                let remainder = 100 - score;

                if (scoresChart) {
                    scoresChart.destroy();
                }

                const ctx = document.getElementById('report').getContext('2d');

                scoresChart = new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: ['Score', 'Remainder'],
                        datasets: [{
                            label: 'Mental Health Scores',
                            data: [score, remainder],
                            backgroundColor: ['#3366CC', '#F2A73B'],
                            borderColor: ['#3366CC', '#F2A73B'],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            datalabels: {
                                formatter: (value, context) => {
                                    let percentage = value + "%"; // Direct percentage of score
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
        }
    });
}

$(document).ready(function() {
    getData();
});
