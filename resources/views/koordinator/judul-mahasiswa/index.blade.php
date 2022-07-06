@extends('layouts.minia.header')

@section('content')
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Daftar Judul Mahasiswa</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard.home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Daftar Judul Mahasiswa</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Data Judul Mahasiswa</h4>
                        <p class="card-title-desc">
                            Berikut adalah daftar <b>Judul Mahasiswa</b> setelah mendapatkan <b>Dosen Pembimbing</b>.
                        </p>
                    </div>
                    <div class="card-body">
                        <input type="hidden" name="th_aktif" id="th_aktif" value="{{ $th_aktif->id }}">
                        <div class="d-flex justify-content-end">
                            <div class="row mb-3">
                                <label for="" class="mt-0">Pilih Tahun Expor Daftar Judul : </label>
                                <div class="hstack gap-2">
                                    <select class="js-example-responsive form-control" style="width: 100%" id="tahun_ajaran"
                                        name="tahun_ajaran">
                                        <option value=""></option>
                                        @foreach ($tahun_id as $tahun)
                                            <option value="{{ $tahun->id }}">{{ $tahun->tahun_ajaran }}</option>
                                        @endforeach
                                    </select>
                                    <a href="javascript:void(0)" class="btn btn-primary btn-md waves-effect waves-light"
                                        data-toggle="tooltip" title="Ekspor Data" id="btnExpor">
                                        <i class="fas fa-file-export"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped dt-responsive w-100" id="Tabels">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tahun Ajaran</th>
                                        <th>Nama Pembimbing</th>
                                        <th>Nama Mahasiswa</th>
                                        <th>Judul Mahasiswa</th>
                                        <th>Status Judul</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <!-- select2 css -->
    <link href="{{ asset('vendor/minia') }}/assets/libs/select2/select2.min.css" rel="stylesheet" />
    <!-- select2 js -->
    <script src="{{ asset('vendor/minia') }}/assets/libs/select2/select2.min.js"></script>

    <style>
        td.wrapok {
            white-space: nowrap;
        }
    </style>

    <script>
        $(document).ready(function() {
            /* Ajax Token */
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            /* Get data table */
            var table = $('#Tabels').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('judul-mahasiswa.indexKoor') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'tahun.tahun_ajaran',
                        name: 'tahun.tahun_ajaran'
                    },
                    {
                        data: 'dosen.nama_dosen',
                        name: 'dosen.nama_dosen'
                    },
                    {
                        data: 'mahasiswa.nama_mahasiswa',
                        name: 'mahasiswa.nama_mahasiswa'
                    },
                    {
                        data: 'judul.judul',
                        name: 'judul.judul'
                    },
                    {
                        data: 'judul.status',
                        name: 'judul.status'
                    },
                ],
                columnDefs: [{
                        searchable: false,
                        orderable: false,
                        targets: [0]
                    },
                    {
                        width: '1%',
                        targets: [0]
                    },
                    {
                        targets: [0, 1, 2, 3, 5],
                        class: "wrapok"
                    }
                ],
                order: [
                    [1, 'desc'],
                    [3, 'asc']
                ],
                oLanguage: {
                    sUrl: "/vendor/minia/assets/libs/datatables.net/js/indonesian.json"
                }
            });

            /* Button Tooltip */
            $('table').on('draw.dt', function() {
                $('[data-toggle="tooltip"]').tooltip();
            });

            /* select tahun_ajaran aktif */
            $("#tahun_ajaran").val(document.getElementById("th_aktif").value).trigger('change');

            $("#btnExpor").click(function() {
                var params = document.getElementById("tahun_ajaran").value;
                location.href = "export/judul/" + params;

                setTimeout(function() {
                    Swal.fire({
                        title: "Ekspor Daftar Judul Berhasil!",
                        icon: "success",
                    })
                }, 1200);
            });

            /* Select2 Tahun Ajaran Add */
            $("#tahun_ajaran").select2({
                placeholder: "Cari berdasarkan tahun ...",
            });
        });
    </script>
@endsection
