// Inisialisasi peta Leaflet
var map = L.map('map').setView([-2.2235165, 115.66283], 5); // Sesuaikan dengan koordinat dan zoom level yang diinginkan

// Menambahkan tile layer dari MapTiler
L.tileLayer('https://api.maptiler.com/maps/streets-v2/{z}/{x}/{y}.png?key=bytM5SPC2tIDSZLZ1rCQ', {
  attribution: '<a href="https://www.maptiler.com/copyright/" target="_blank">&copy; MapTiler</a> <a href="https://www.openstreetmap.org/copyright" target="_blank">&copy; OpenStreetMap contributors</a>'
}).addTo(map);

// Function to format popup content
function formatPopupContent(properties) {
  return `
      <b>${properties.provinsi}</b><br>
      Jumlah User: ${properties.jumlah_user}<br>
      Jumlah Psikolog: ${properties.jumlah_psikolog}
  `;
}

// Function to handle popup content and binding
function popUp(feature, layer) {
  if (feature.properties) {
    layer.bindPopup(formatPopupContent(feature.properties));
  }
}

// Fetch data dari get_data.php untuk mengambil GeoJSON dan data jumlah user serta psikolog
fetch('get_data.php')
  .then(response => response.json())
  .then(data => {
    // Memuat GeoJSON dari file yang Anda miliki (ganti path dan nama file jika diperlukan)
    var geojsonLayer = new L.GeoJSON.AJAX(["../../bahan/indonesia-prov.geojson"], {
      style: function (feature) {
        return {
          fillColor: feature.properties.fillColor || '#008000', // Default fill color
          fillOpacity: 0.7,
          color: "#000000", // Warna garis tepi
          weight: 0.4 // Ketebalan garis tepi
        };
      },
      onEachFeature: function (feature, layer) {
        // Mencari data jumlah user dan psikolog yang sesuai dari hasil fetch
        var matchingData = data.find(d => d.provinsi.toUpperCase() === feature.properties.provinsi.toUpperCase());
        if (matchingData) {
          // Menambahkan properti jumlah user dan psikolog ke dalam fitur GeoJSON
          feature.properties.jumlah_user = matchingData.jumlah_user;
          feature.properties.jumlah_psikolog = matchingData.jumlah_psikolog;
        }
        // Memanggil fungsi popUp untuk menampilkan popup dengan data yang sudah dimasukkan
        popUp(feature, layer);
      }
    }).addTo(map);
  })
  .catch(error => {
    console.error('Error fetching data:', error);
  });

const colors = {
    'PTSD': 'rgba(255, 99, 132)',
    'Depression': 'rgba(255, 159, 64)',
    'Anxiety': 'rgba(255, 205, 86)',
    'Stress': 'rgba(75, 192, 192)',
    'OCD': 'rgba(54, 162, 235)',
    'Bipolar Disorder': 'rgba(153, 102, 255)',
    'Substance Abuse': 'rgba(201, 203, 207)',
    'Family Therapy': 'rgba(231, 103, 207)',
    'Child Psychology': 'rgba(231, 103, 107)'
};

function getData() {
    // Ambil data untuk chart pertama (chartUser)
    $.ajax({
        type: 'GET',
        url: 'backend.php',
        data: {
            functionName: 'getDataPsikolog',
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
                'Substance Abuse': 0,
                'Family Therapy': 0,
                'Child Psychology': 0
            };

            // Menghitung jumlah psikolog untuk setiap spesialisasi
            data.forEach(function(psychologist) {
                for (const specialization in counts) {
                    if (psychologist.specialties.includes(specialization)) {
                        counts[specialization]++;
                    }
                }
            });

            // Hapus chart sebelumnya jika sudah ada
            if (window.chartUser instanceof Chart) {
                window.chartUser.destroy();
            }

            const ctxUser = document.getElementById('chartUser').getContext('2d');

            window.chartUser = new Chart(ctxUser, {
                type: 'bar',
                data: {
                    labels: Object.keys(counts),
                    datasets: [{
                        label: '',
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
                            beginAtZero: true
                        }
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let specialization = context.label;
                                    let count = context.raw;
                                    return specialization + ': ' + count + ' psikolog';
                                }
                            }
                        },
                        legend: {
                            display: false // Menyembunyikan legenda
                        }
                    }
                }
            });
        }
    });

    // Ambil data untuk chart kedua (chartPatient)
    $.ajax({
        type: 'GET',
        url: 'backend.php',
        data: {
            functionName: 'getDataPatient',
        },
        success: function(response) {
            let data = JSON.parse(response);
            let counts = {
                'Completed': 0,
                'Scheduled': 0,
                'Cancelled': 0
            };

            // Menghitung jumlah konsultasi untuk setiap status
            data.forEach(function(consultation) {
                if (consultation.status in counts) {
                    counts[consultation.status]++;
                }
            });

            // Hapus chart sebelumnya jika sudah ada
            if (window.chartPatient instanceof Chart) {
                window.chartPatient.destroy();
            }

            const ctxPatient = document.getElementById('chartPatient').getContext('2d');

            window.chartPatient = new Chart(ctxPatient, {
                type: 'pie',
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
                            formatter: (value, ctx) => {
                                let sum = ctx.chart.data.datasets[0].data.reduce((a, b) => a + b, 0);
                                let percentage = (value * 100 / sum).toFixed(2) + "%";
                                return percentage;
                            },
                            color: '#fff'
                        }
                    }
                }
            });
        }
    });

    // Ambil data untuk chart ketiga (boxProv)
    $.ajax({
        type: 'GET',
        url: 'backend.php',
        data: {
            functionName: 'getProvData',
        },
        success: function(response) {
            let data = JSON.parse(response);
            let provinsi = [];
            let jumlah_user = [];
            let jumlah_psikolog = [];

            // Menghitung jumlah user dan psikolog untuk setiap provinsi
            data.forEach(function(item) {
                provinsi.push(item.provinsi);
                jumlah_user.push(item.jumlah_user);
                jumlah_psikolog.push(item.jumlah_psikolog);
            });

            // Hapus chart sebelumnya jika sudah ada
            if (window.boxProv instanceof Chart) {
                window.boxProv.destroy();
            }

            const ctxProv = document.getElementById('boxProv').getContext('2d');

            window.boxProv = new Chart(ctxProv, {
                type: 'bar',
                data: {
                    labels: provinsi,
                    datasets: [
                        {
                            label: 'Pasien',
                            backgroundColor: colors['User'],
                            borderColor: colors['User'],
                            data: jumlah_user,
                            borderWidth: 1
                        },
                        {
                            label: 'Psikolog',
                            backgroundColor: colors['Psychologist'],
                            borderColor: colors['Psychologist'],
                            data: jumlah_psikolog,
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0 // Menonaktifkan desimal
                            }
                        }
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.dataset.label || '';
                                    let value = context.raw;
                                    return label + ': ' + value;
                                }
                            }
                        },
                        legend: {
                            display: true
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
            functionName: 'getSeverityLevels',
        },
        success: function(response) {
            let data = JSON.parse(response);
            let labels = [];
            let counts = [];

            data.forEach(function(item) {
                labels.push(item.severity_level);
                counts.push(item.count);
            });

            // Hapus chart sebelumnya jika sudah ada
            if (window.chartLevel instanceof Chart) {
                window.chartLevel.destroy();
            }

            const ctxLevel = document.getElementById('chartLevel').getContext('2d');

            window.chartLevel = new Chart(ctxLevel, {
                type: 'pie',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Jumlah berdasarkan Severity Level',
                        backgroundColor: Object.values(colors),
                        borderColor: Object.values(colors),
                        data: counts,
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        datalabels: {
                            formatter: (value, ctx) => {
                                let sum = ctx.chart.data.datasets[0].data.reduce((a, b) => a + b, 0);
                                let percentage = (value * 100 / sum).toFixed(2) + "%";
                                return percentage;
                            },
                            color: '#fff'
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
            functionName: 'getPotentialDiagnosisData',
        },
        success: function(response) {
            let data = JSON.parse(response);
            let counts = {};

            // Menghitung jumlah potential_diagnosis
            data.forEach(function(test) {
                if (test.potential_diagnosis in counts) {
                    counts[test.potential_diagnosis]++;
                } else {
                    counts[test.potential_diagnosis] = 1;
                }
            });

            // Hapus chart sebelumnya jika sudah ada
            if (window.chartDiagnosa instanceof Chart) {
                window.chartDiagnosa.destroy();
            }

            const ctxDiagnosa = document.getElementById('chartDiagnosa').getContext('2d');

            window.chartDiagnosa = new Chart(ctxDiagnosa, {
                type: 'pie',
                data: {
                    labels: Object.keys(counts),
                    datasets: [{
                        label: 'Jumlah Potential Diagnosis',
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
                            formatter: (value, ctx) => {
                                let sum = ctx.chart.data.datasets[0].data.reduce((a, b) => a + b, 0);
                                let percentage = (value * 100 / sum).toFixed(2) + "%";
                                return percentage;
                            },
                            color: '#fff'
                        }
                    }
                }
            });
        }
    });
}
$(document).ready(function() {
    getData();
});
