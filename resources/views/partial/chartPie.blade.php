<!-- Card Chart -->
<div class="row">
    <div class="col-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex flex-wrap align-items-center mb-4">
                    <h6 class="card-title me-2">Jumlah Dosen dan Mahasiswa</h6>
                </div>
                <div id="jmlDsnMhs" class="mb-0 mt-0"></div>
            </div>
        </div>
    </div>
    <div class="col-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex flex-wrap align-items-center mb-4">
                    <h6 class="card-title me-2">Jumlah Mahasiswa yang Sudah Mengajukan Judul Tugas Akhir</h6>
                </div>
                <div id="JmlPengajuanJudul"></div>
            </div>
        </div>
    </div>
    <div class="col-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex flex-wrap align-items-center mb-4">
                    <h6 class="card-title me-2">Jumlah Judul Tugas Akhir yang Sudah Disetujui</h6>
                </div>
                <div id="jmlJuduldisetujui"></div>
            </div>
        </div>
    </div>
</div>

@section('chartPieJs')
    <script>
        function pieJmlDsnMhs(value) {
            var options = {
                chart: {
                    type: 'donut'
                },
                legend: {
                    position: 'bottom',
                    horizontalAlign: 'center',
                    offsetX: 0,
                    offsetY: 0,
                },
                series: value,
                labels: ['Dosen', 'Mahasiswa'],
                plotOptions: {
                    pie: {
                        customScale: 1,
                        expandOnClick: false,
                        offsetX: 0,
                        offsetY: 0,
                    },
                    donut: {
                        size: '85%'
                    }
                },
                theme: {
                    palette: 'palette1' // upto palette10
                }
            }

            var chart = new ApexCharts(document.querySelector("#jmlDsnMhs"), options);

            chart.render();
        }

        function pieJmlPengajuanJudul(value) {
            var options = {
                chart: {
                    type: 'donut'
                },
                legend: {
                    position: 'bottom',
                    horizontalAlign: 'center',
                    offsetX: 0,
                    offsetY: 0,
                },
                series: value,
                labels: ['Mengajukan', 'Belum Mengajukan'],
                plotOptions: {
                    pie: {
                        customScale: 1,
                        expandOnClick: false,
                        offsetX: 0,
                        offsetY: 0,
                    },
                    donut: {
                        size: '85%'
                    }
                },
                theme: {
                    palette: 'palette2' // upto palette10
                }
            }

            var chart = new ApexCharts(document.querySelector("#JmlPengajuanJudul"), options);

            chart.render();
        }

        function jmlJuduldisetujui(value) {
            var options = {
                chart: {
                    type: 'donut'
                },
                legend: {
                    position: 'bottom',
                    horizontalAlign: 'center',
                    offsetX: 0,
                    offsetY: 0,
                },
                series: value,
                labels: ['Disetujui', 'Belum Disetujui'],
                plotOptions: {
                    pie: {
                        customScale: 1,
                        expandOnClick: false,
                        offsetX: 0,
                        offsetY: 0,
                    },
                    donut: {
                        size: '85%'
                    }
                },
                theme: {
                    palette: 'palette3' // upto palette10
                }
            }

            var chart = new ApexCharts(document.querySelector("#jmlJuduldisetujui"), options);

            chart.render();
        }

        $(document).ready(function() {
            $(function() {
                $.ajax({
                    url: "{{ route('partial.chartPie') }}"
                }).done(function(data) {
                    pieJmlDsnMhs(data.pieJmlDsnMhs);
                    pieJmlPengajuanJudul(data.pieJmlPengajuanJudul);
                    jmlJuduldisetujui(data.jmlJuduldisetujui);
                });
            })
        });
    </script>
@endsection
