<!-- Card Chart -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex flex-wrap align-items-center mb-4">
                    <h6 class="card-title me-2">Trends Jumlah Mahasiswa pada Setiap Tahapan Bimbingan</h6>
                </div>
                <div id="jmlMhs" class="mb-0 mt-0" style="display: block"></div>
            </div>
        </div>
    </div>
</div>

@section('chartColumnJs')
    <script>
        function jmlMhs(selesai, belum) {
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
                    // width: '85%'
                },
                plotOptions: {
                    bar: {
                        endingShape: 'rounded'
                    },
                },
                dataLabels: {
                    enabled: false
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
                        ['Proposal', 'Bab4'],
                        ['Laporan', 'Bab1'],
                        ['Laporan', 'Bab2'],
                        ['Laporan', 'Bab3'],
                        ['Laporan', 'Bab4'],
                        ['Laporan', 'Bab5'],
                        ['Laporan', 'Bab6'], 'Program'
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
                    palette: 'palette4' // upto palette10
                }
            };

            var chart = new ApexCharts(document.querySelector("#jmlMhs"), options);
            chart.render();
        }

        $(document).ready(function() {
            $(function() {
                $.ajax({
                    url: "{{ route('partial.chartColumn') }}"
                }).done(function(data) {
                    jmlMhs(data.selesai, data.belum);
                });
            })
        });
    </script>
@endsection
