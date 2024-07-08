var scoresChart;

function getData() {
    console.log('getData function called'); // Debugging
    $.ajax({
        type: 'GET',
        url: 'detailUser.php',
        data: {
            functionName: 'getMentalHealthScores',
            user_id: user_id
        },
        success: function(response) {
            console.log('Response from detailUser.php:', response); // Debugging
            let data = JSON.parse(response);
            console.log('Parsed data:', data); // Debugging
            let scores = [];
            let remainders = [];

            data.forEach(function(mentalhealthtests) {
                let score = mentalhealthtests.score;
                scores.push(score);
                remainders.push(100 - score);
            });

            if (scoresChart) {
                scoresChart.destroy();
            }

            const ctx = document.getElementById('report').getContext('2d');

            scoresChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Score', 'Remainder'],
                    datasets: [{
                        label: 'Mental Health Scores',
                        data: [scores[0], remainders[0]], // Ensure only one set of data is sent
                        backgroundColor: ['#3366CC', '#F2A73B'],
                        borderColor: ['#3366CC', '#F2A73B'],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        datalabels: {
                            formatter: (value, context) => {
                                return value + "%"; // Show value as percentage in range 1-100
                            },
                            color: '#fff',
                            display: 'auto'
                        }
                    }
                },
                plugins: [ChartDataLabels] // Ensure this is required based on the version of Chart.js used                
            });
        },
        error: function(xhr, status, error) {
            console.log('Error:', error); // Debugging
        }
    });
}

$(document).ready(function() {
    getData();
});
