<!-- Card Chart -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="d-flex flex-wrap align-items-center mb-4">
                            <h6 class="card-title me-2">Trends Jumlah Mahasiswa pada Tahapan Judul & Proposal</h6>
                        </div>
                        <div id="jmlPro" class="mb-0 mt-0" style="display: block"></div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex flex-wrap align-items-center mb-4">
                            <h6 class="card-title me-2">Trends Jumlah Mahasiswa pada Tahapan Program & Laporan</h6>
                        </div>
                        <div id="jmlLap" class="mb-0 mt-0" style="display: block"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('chartColumnJs')
    <script>
        function jmlPro(selesai, belum) {
            var options = {
                series: [{
                    name: 'Jumlah Mahasiswa yang Belum Selesai',
                    data: belum
                }, {
                    name: 'Jumlah Mahasiswa yang Sudah Selesai',
                    data: selesai
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
                    categories: ['Judul', ['Proposal', 'Bab1'],
                        ['Proposal', 'Bab2'],
                        ['Proposal', 'Bab3'],
                        ['Proposal', 'Bab4']
                    ],
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
                    palette: 'palette10' // upto palette10
                }
            };

            var chart = new ApexCharts(document.querySelector("#jmlPro"), options);
            chart.render();
        }

        function jmlLap(selesaiB, belumB) {
            var options = {
                series: [{
                    name: 'Jumlah Mahasiswa yang Belum Selesai',
                    data: belumB
                }, {
                    name: 'Jumlah Mahasiswa yang Sudah Selesai',
                    data: selesaiB
                }],
                chart: {
                    type: 'bar',
                    height: 200,
                    // width: '85%'
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
                    categories: ['Program',
                        ['Laporan', 'Bab1'],
                        ['Laporan', 'Bab2'],
                        ['Laporan', 'Bab3'],
                        ['Laporan', 'Bab4'],
                        ['Laporan', 'Bab5'],
                        ['Laporan', 'Bab6']
                    ],
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
                    palette: 'palette5' // upto palette10
                }
            };

            var chart = new ApexCharts(document.querySelector("#jmlLap"), options);
            chart.render();
        }

        $(document).ready(function() {
            $(function() {
                $.ajax({
                    url: "{{ route('partial.chartColumn') }}"
                }).done(function(data) {
                    jmlPro(data.selesaiA, data.belumA);
                    jmlLap(data.selesaiB, data.belumB);
                });
            })
        });
    </script>
@endsection
