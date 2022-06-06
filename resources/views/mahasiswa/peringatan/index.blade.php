@extends('layouts.minia.header')

@section('content')
    {{-- Modal Detail --}}
    <div class="modal fade" id="ModalDetail" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Data Peringatan Dari Ketua Prodi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-1">
                        <div class="col-md-6">
                            <label for="tahun_ajaran_detail" class="col-form-label">Tahun Ajaran:</label>
                            <input type="text" class="form-control no-outline" id="tahun_ajaran_detail"
                                name="tahun_ajaran_detail" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="jenis_detail" class="col-form-label">Jenis Informasi:</label>
                            <input type="text" class="form-control no-outline" id="jenis_detail" name="jenis_detail"
                                readonly>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <div class="col-md-6">
                            <label for="judul_detail" class="col-form-label">Judul Peringatan:</label>
                            <textarea class="form-control" name="judul_detail" id="judul_detail" style="width: 100%" rows="2" readonly></textarea>
                        </div>
                        <div class="col-md-6">
                            <label for="subyek_detail" class="col-form-label">Subyek Peringatan:</label>
                            <textarea class="form-control" name="subyek_detail" id="subyek_detail" style="width: 100%" rows="2"
                                readonly></textarea>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <div class="col-md-12">
                            <label for="pesan_detail" class="col-form-label">Isi Peringatan:</label>
                            <textarea class="form-control" name="pesan_detail" id="pesan_detail" style="width: 100%" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="file_upload" class="col-form-label">Lampiran File:</label>
                        <input type="text" class="form-control no-outline" id="file_upload" name="file_upload" readonly>
                        <iframe style="width:100%; height:400px;" id="iprame" frameborder="0"></iframe>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    {{-- END Modal Show --}}

    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Peringatan</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard.home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Peringatan</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6">
                                <h4 class="card-title">Peringatan untuk <b>Anda</b></h4>
                                <p class="card-title-desc">
                                    Anda dapat melihat peringatan online dari Ketua Prodi, Koordinator, maupun Dosen.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped dt-responsive nowrap w-100" id="RoleTables">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tahun Ajaran</th>
                                        <th>Pengirim</th>
                                        <th>Judul</th>
                                        <th>Subyek</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
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

    <script>
        $(document).ready(function() {
            /* Ajax Token */
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            /* function ubah huruf pertama menjadi kapital */
            function capitalizeFirstLetter(string) {
                return string.charAt(0).toUpperCase() + string.slice(1);
            }

            /* Get data table notifikasi */
            var roleTable = $('#RoleTables').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('peringatan.roleInfo') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'informasi.tahun.tahun_ajaran',
                        name: 'informasi.tahun.tahun_ajaran'
                    },
                    {
                        data: 'informasi.pengirim.role',
                        name: 'informasi.pengirim.role'
                    },
                    {
                        data: 'informasi.judul',
                        name: 'informasi.judul'
                    },
                    {
                        data: 'informasi.subyek',
                        name: 'informasi.subyek'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    }
                ],
                columnDefs: [{
                        searchable: false,
                        orderable: false,
                        targets: [0, 6]
                    },
                    {
                        width: '1%',
                        targets: [0, 6]
                    },
                    {
                        targets: [2],
                        render: function(data, type, full, meta) {
                            var str = data;
                            str = capitalizeFirstLetter(str);
                            return str;
                        }
                    }
                ],
                order: [
                    [1, 'desc']
                ],
                oLanguage: {
                    sUrl: "/vendor/minia/assets/libs/datatables.net/js/indonesian.json"
                }
            });

            /* Button Tooltip */
            $('table').on('draw.dt', function() {
                $('[data-toggle="tooltip"]').tooltip();
            });

            /* Button Detail */
            $('body').on('click', '#btnDetail', function() {
                var this_id = $(this).data('id');
                $.get('peringatan/role/info/' + this_id, function(data) {
                    $('#ModalDetail').modal('show');
                    $('#tahun_ajaran_detail').val(data.informasi.tahun.tahun_ajaran);
                    $('#jenis_detail').val(data.informasi.jenis);
                    $('#judul_detail').val(data.informasi.judul);
                    $('#subyek_detail').val(data.informasi.subyek);
                    $('#pesan_detail').val(data.informasi.pesan);

                    if (data.informasi.file_upload) {
                        $('#file_upload').val(data.informasi.file_upload);
                        $('iframe').attr("src", "{{ asset('dokumen/peringatan') }}" + "/" +
                            data.informasi.file_upload);
                        $('#iprame').show();
                    } else {
                        $('#file_upload').val('Belum Upload');
                        $('#iprame').hide();
                    }

                }).then(function() {
                    loaderNotif();
                    roleTable.ajax.reload();
                });
            });
        });
    </script>
@endsection
