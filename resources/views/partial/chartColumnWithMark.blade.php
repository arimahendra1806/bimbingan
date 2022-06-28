<!-- Card Chart -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="d-flex flex-wrap align-items-center mb-4">
                            <h6 class="card-title me-2">Trends Jumlah Mahasiswa dalam Ujian TA</h6>
                        </div>
                        <div id="jmlPengujian" class="mb-0 mt-0" style="display: block"></div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex flex-wrap align-items-center mb-4">
                            <h6 class="card-title me-2">Trends Jumlah Mahasiswa dalam Pengumpulan TA</h6>
                        </div>
                        <div id="jmlPengumpulan" class="mb-0 mt-0" style="display: block"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('chartColumnWithMarkJs')
    <script>
        function jmlPengujian(pengujianSelesai, pengujianBelum) {
            var options = {
                series: [{
                    name: 'Belum Ujian TA',
                    data: pengujianBelum
                }, {
                    name: 'Sudah Ujian TA',
                    data: pengujianSelesai
                }],
                chart: {
                    type: 'bar',
                    height: 200,
                },
                plotOptions: {
                    bar: {
                        endingShape: 'rounded'
                    },
                },
                dataLabels: {
                    enabled: true
                },
                stroke: {
                    show: true,
                    width: 2,
                    colors: ['transparent']
                },
                xaxis: {
                    categories: ['Ujian Proposal', 'Ujian Laporan'],
                },
                yaxis: {
                    title: {
                        text: 'Jumlah Mahasiswa'
                    }
                },
                fill: {
                    opacity: 1
                },
                tooltip: {
                    y: {
                        formatter: function(val) {
                            return val + " Mahasiswa"
                        }
                    }
                },
                theme: {
                    palette: 'palette8' // upto palette10
                }
            };

            var chart = new ApexCharts(document.querySelector("#jmlPengujian"), options);
            chart.render();
        }

        function jmlPengumpulan(pengumpulanSelesai, pengumpulanBelum) {
            var options = {
                series: [{
                    name: 'Belum Mengumpulkan TA',
                    data: pengumpulanBelum
                }, {
                    name: 'Sudah Mengumpulkan TA',
                    data: pengumpulanSelesai
                }],
                chart: {
                    type: 'bar',
                    height: 200,
                },
                plotOptions: {
                    bar: {
                        endingShape: 'rounded'
                    },
                },
                dataLabels: {
                    enabled: true
                },
                stroke: {
                    show: true,
                    width: 2,
                    colors: ['transparent']
                },
                xaxis: {
                    categories: ['Pengumpulan Proposal', 'Pengumpulan Laporan'],
                },
                yaxis: {
                    title: {
                        text: 'Jumlah Mahasiswa'
                    }
                },
                fill: {
                    opacity: 1
                },
                tooltip: {
                    y: {
                        formatter: function(val) {
                            return val + " Mahasiswa"
                        }
                    }
                },
                theme: {
                    palette: 'palette9' // upto palette10
                }
            };

            var chart = new ApexCharts(document.querySelector("#jmlPengumpulan"), options);
            chart.render();
        }

        $(document).ready(function() {
            $(function() {
                $.ajax({
                    url: "{{ route('partial.chartColumnWithMark') }}"
                }).done(function(data) {
                    jmlPengujian(data.pengujianSelesai, data.pengujianBelum);
                    jmlPengumpulan(data.pengumpulanSelesai, data.pengumpulanBelum);
                });
            })
        });
    </script>
@endsection
