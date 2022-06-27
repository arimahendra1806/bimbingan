<!-- Card Chart -->
<div class="row">
    <div class="col-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex flex-wrap align-items-center mb-4">
                    <h6 class="card-title me-2">Trends Interaksi Konsultasi Bimbingan Setiap Bulan</h6>
                </div>
                <div id="jmlKonsultasi" class="mb-0 mt-0" style="display: block"></div>
            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex flex-wrap align-items-center mb-4">
                    <h6 class="card-title me-2">Trends Interaksi Diskusi Melalui Kolom Komentar Setiap Bulan</h6>
                </div>
                <div id="jmlKomentar" class="mb-0 mt-0" style="display: block"></div>
            </div>
        </div>
    </div>
</div>

@section('chartLineJs')
    <script>
        function jmlKonsultasi(kategori, value) {
            var options = {
                series: [{
                    name: "Trend Interaksi Konsultasi",
                    data: value
                }],
                chart: {
                    height: 350,
                    type: 'line',
                    zoom: {
                        enabled: false
                    }
                },
                dataLabels: {
                    enabled: true
                },
                stroke: {
                    curve: 'straight'
                },
                grid: {
                    row: {
                        colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
                        opacity: 0.5
                    },
                },
                xaxis: {
                    categories: kategori,
                },
                theme: {
                    palette: 'palette6' // upto palette10
                }
            };

            var chart = new ApexCharts(document.querySelector("#jmlKonsultasi"), options);

            chart.render();
        }

        function jmlKomentar(kategori, value) {
            var options = {
                series: [{
                    name: "Trend Interaksi Komentar",
                    data: value
                }],
                chart: {
                    height: 350,
                    type: 'line',
                    zoom: {
                        enabled: false
                    }
                },
                dataLabels: {
                    enabled: true
                },
                stroke: {
                    curve: 'straight'
                },
                grid: {
                    row: {
                        colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
                        opacity: 0.5
                    },
                },
                xaxis: {
                    categories: kategori,
                },
                theme: {
                    palette: 'palette7' // upto palette10
                }
            };

            var chart = new ApexCharts(document.querySelector("#jmlKomentar"), options);

            chart.render();
        }

        $(document).ready(function() {
            $(function() {
                $.ajax({
                    url: "{{ route('partial.chartLine') }}"
                }).done(function(data) {
                    jmlKonsultasi(data.nm_bulan, data.data_konsultasi);
                    jmlKomentar(data.nm_bulan, data.data_komentar);
                });
            })
        });
    </script>
@endsection
