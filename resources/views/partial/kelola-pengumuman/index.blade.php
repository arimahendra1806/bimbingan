@extends('layouts.minia.header')

@section('content')
    {{-- Modal Add --}}
    <div class="modal fade" id="ModalAdd" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Data Pengumuman</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="FormAdd">
                    @csrf
                    <div class="modal-body">
                        <div class="row mb-1">
                            <div class="col-md-6">
                                <label for="tahun_ajaran_add" class="col-form-label">Tahun Ajaran:</label>
                                <select class="js-example-responsive form-control" style="width: 100%" id="tahun_ajaran_add"
                                    name="tahun_ajaran_add">
                                    <option value=""></option>
                                    @foreach ($tahun_id as $tahun)
                                        <option value="{{ $tahun->id }}">{{ $tahun->tahun_ajaran }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger error-text tahun_ajaran_add_error"></span>
                            </div>
                            <div class="col-md-6">
                                <label for="jenis_add" class="col-form-label">Jenis Informasi:</label>
                                <input type="text" class="form-control" id="jenis_add" name="jenis_add" value="Pengumuman"
                                    readonly>
                                <span class="text-danger error-text jenis_add_error"></span>
                            </div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-md-6">
                                <label for="kepada_role_add" class="col-form-label">Ditujukan Untuk:</label>
                                <select class="js-example-responsive form-control" style="width: 100%" id="kepada_role_add"
                                    name="kepada_role_add">
                                    <option value=""></option>
                                    @if (Auth::check() && Auth::user()->role == 'koordinator')
                                        <option value="semua pengguna">Semua Pengguna</option>
                                        <option value="dosen">Dosen</option>
                                        <option value="mahasiswa">Mahasiswa</option>
                                    @elseif(Auth::check() && Auth::user()->role == 'kaprodi')
                                        <option value="semua pengguna">Semua Pengguna</option>
                                        <option value="koordinator dosen">Semua Koordinator & Dosen</option>
                                        <option value="dosen mahasiswa">Semua Dosen & Mahasiswa</option>
                                        <option value="koordinator">Koordinator</option>
                                        <option value="dosen">Dosen</option>
                                        <option value="mahasiswa">Mahasiswa</option>
                                    @elseif(Auth::check() && Auth::user()->role == 'dosen')
                                        <option value="mahasiswa">Mahasiswa</option>
                                    @endif
                                </select>
                                <span class="text-danger error-text kepada_role_add_error"></span>
                            </div>
                            <div class="col-md-6">
                                <label for="kepada_add" class="col-form-label">Kepada:</label>
                                <select class="js-example-responsive form-control" style="width: 100%" id="kepada_add"
                                    name="kepada_add">
                                    <option value=""></option>
                                </select>
                                <span class="text-danger error-text kepada_add_error"></span>
                            </div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-md-6">
                                <label for="judul_add" class="col-form-label">Judul Pengumuman:</label>
                                <textarea class="form-control" name="judul_add" id="judul_add" style="width: 100%" rows="2"></textarea>
                                <span class="text-danger error-text judul_add_error"></span>
                            </div>
                            <div class="col-md-6">
                                <label for="subyek_add" class="col-form-label">Subyek Pengumuman:</label>
                                <textarea class="form-control" name="subyek_add" id="subyek_add" style="width: 100%" rows="2"></textarea>
                                <span class="text-danger error-text subyek_add_error"></span>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="pesan_add" class="col-form-label">Isi Pengumuman:</label>
                                <textarea class="form-control" name="pesan_add" id="pesan_add" style="width: 100%" rows="3"></textarea>
                                <span class="text-danger error-text pesan_add_error"></span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <input type="submit" class="btn btn-primary" name="addSave" value="Simpan">
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- END Modal Add --}}

    {{-- Modal Edit --}}
    <div class="modal fade" id="ModalEdit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Perbarui Data Pengumuman</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="FormEdit">
                    <input type="hidden" class="form-control" id="id_edit" name="id_edit">
                    @csrf
                    <div class="modal-body">
                        <div class="row mb-1">
                            <div class="col-md-6">
                                <label for="tahun_ajaran_edit" class="col-form-label">Tahun Ajaran:</label>
                                <select class="js-example-responsive form-control" style="width: 100%"
                                    id="tahun_ajaran_edit" name="tahun_ajaran_edit">
                                    <option value=""></option>
                                    @foreach ($tahun_id as $tahun)
                                        <option value="{{ $tahun->id }}">{{ $tahun->tahun_ajaran }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger error-text tahun_ajaran_edit_error"></span>
                            </div>
                            <div class="col-md-6">
                                <label for="jenis_edit" class="col-form-label">Jenis Informasi:</label>
                                <input type="text" class="form-control" id="jenis_edit" name="jenis_edit"
                                    value="Pengumuman" readonly>
                                <span class="text-danger error-text jenis_edit_error"></span>
                            </div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-md-6">
                                <label for="kepada_role_edit" class="col-form-label">Ditujukan Untuk:</label>
                                <select class="js-example-responsive form-control" style="width: 100%" id="kepada_role_edit"
                                    name="kepada_role_edit">
                                    <option value=""></option>
                                    @if (Auth::check() && Auth::user()->role == 'koordinator')
                                        <option value="semua pengguna">Semua Pengguna</option>
                                        <option value="dosen">Dosen</option>
                                        <option value="mahasiswa">Mahasiswa</option>
                                    @elseif(Auth::check() && Auth::user()->role == 'kaprodi')
                                        <option value="semua pengguna">Semua Pengguna</option>
                                        <option value="koordinator dosen">Semua Koordinator & Dosen</option>
                                        <option value="dosen mahasiswa">Semua Dosen & Mahasiswa</option>
                                        <option value="koordinator">Koordinator</option>
                                        <option value="dosen">Dosen</option>
                                        <option value="mahasiswa">Mahasiswa</option>
                                    @elseif(Auth::check() && Auth::user()->role == 'dosen')
                                        <option value="mahasiswa">Mahasiswa</option>
                                    @endif
                                </select>
                                <span class="text-danger error-text kepada_role_edit_error"></span>
                            </div>
                            <div class="col-md-6">
                                <label for="kepada_edit" class="col-form-label">Kepada:</label>
                                <select class="js-example-responsive form-control" style="width: 100%" id="kepada_edit"
                                    name="kepada_edit">
                                    <option value=""></option>
                                </select>
                                <span class="text-danger error-text kepada_edit_error"></span>
                            </div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-md-6">
                                <label for="judul_edit" class="col-form-label">Judul Pengumuman:</label>
                                <textarea class="form-control" name="judul_edit" id="judul_edit" style="width: 100%" rows="2"></textarea>
                                <span class="text-danger error-text judul_edit_error"></span>
                            </div>
                            <div class="col-md-6">
                                <label for="subyek_edit" class="col-form-label">Subyek Pengumuman:</label>
                                <textarea class="form-control" name="subyek_edit" id="subyek_edit" style="width: 100%" rows="2"></textarea>
                                <span class="text-danger error-text subyek_edit_error"></span>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="pesan_edit" class="col-form-label">Isi Pengumuman:</label>
                                <textarea class="form-control" name="pesan_edit" id="pesan_edit" style="width: 100%" rows="3"></textarea>
                                <span class="text-danger error-text pesan_edit_error"></span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <input type="submit" class="btn btn-primary" name="editSave" value="Simpan">
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- END Modal Edit --}}

    {{-- Modal Show --}}
    <div class="modal fade" id="ModalShow" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Data Pengumuman</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-1">
                        <div class="col-md-6">
                            <label for="tahun_ajaran_show" class="col-form-label">Tahun Ajaran:</label>
                            <input type="text" class="form-control no-outline" id="tahun_ajaran_show"
                                name="tahun_ajaran_show" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="jenis_show" class="col-form-label">Jenis Informasi:</label>
                            <input type="text" class="form-control no-outline" id="jenis_show" name="jenis_show" readonly>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <div class="col-md-6">
                            <label for="kepada_role_show" class="col-form-label">Ditujukan Untuk:</label>
                            <input type="text" class="form-control no-outline" id="kepada_role_show"
                                name="kepada_role_show" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="kepada_show" class="col-form-label">Kepada:</label>
                            <input type="text" class="form-control no-outline" id="kepada_show" name="kepada_show"
                                readonly>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <div class="col-md-6">
                            <label for="judul_show" class="col-form-label">Judul Pengumuman:</label>
                            <textarea class="form-control" name="judul_show" id="judul_show" style="width: 100%" rows="2" readonly></textarea>
                        </div>
                        <div class="col-md-6">
                            <label for="subyek_show" class="col-form-label">Subyek Pengumuman:</label>
                            <textarea class="form-control" name="subyek_show" id="subyek_show" style="width: 100%" rows="2" readonly></textarea>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="pesan_show" class="col-form-label">Isi Pengumuman:</label>
                            <textarea class="form-control" name="pesan_show" id="pesan_show" style="width: 100%" rows="3"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    {{-- END Modal Show --}}

    {{-- Modal Detail --}}
    <div class="modal fade" id="ModalDetail" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Data Pengumuman Dari Ketua Prodi</h5>
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
                            <label for="judul_detail" class="col-form-label">Judul Pengumuman:</label>
                            <textarea class="form-control" name="judul_detail" id="judul_detail" style="width: 100%" rows="2"
                                readonly></textarea>
                        </div>
                        <div class="col-md-6">
                            <label for="subyek_detail" class="col-form-label">Subyek Pengumuman:</label>
                            <textarea class="form-control" name="subyek_detail" id="subyek_detail" style="width: 100%" rows="2"
                                readonly></textarea>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="pesan_detail" class="col-form-label">Isi Pengumuman:</label>
                            <textarea class="form-control" name="pesan_detail" id="pesan_detail" style="width: 100%" rows="3"></textarea>
                        </div>
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
                    <h4 class="mb-sm-0 font-size-18">Kelola Pengumuman</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard.home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Kelola Pengumuman</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        @if ((Auth::check() && Auth::user()->role == 'koordinator') || Auth::user()->role == 'dosen')
            <div class="row">
                <div class="col-12">
                    <div class="card bg-transparent border-success">
                        <div class="card-header bg-transparent border-success">
                            <div class="row">
                                <div class="col-md-6">
                                    <h4 class="card-title text-success"><i class="fas fa-info-circle"></i> |
                                        Pengumuman untuk <b>Anda</b></h4>
                                </div>
                                <div class="col-md-6 d-flex justify-content-end">
                                    <a class="d-block text-success" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseExample" aria-expanded="false"
                                        aria-controls="collapseExample">
                                        <i class="min fas fa-angle-double-down pull-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="collapse show" id="collapseExample">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped dt-responsive nowrap w-100"
                                        id="RoleTables">
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
        @endif

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Kelola Pengumuman</h4>
                        @if (Auth::check() && Auth::user()->role == 'koordinator')
                            <p class="card-title-desc">
                                Anda dapat mengelola pengumuman online kepada Dosen dan Mahasiswa.
                            </p>
                        @elseif(Auth::check() && Auth::user()->role == 'kaprodi')
                            <p class="card-title-desc">
                                Anda dapat mengelola pengumuman online kepada Koordinator, Dosen, dan Mahasiswa.
                            </p>
                        @elseif(Auth::check() && Auth::user()->role == 'dosen')
                            <p class="card-title-desc">
                                Anda dapat mengelola pengumuman online kepada Mahasiswa yang Anda bimbing.
                            </p>
                        @endif
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-end">
                            <a href="javascript:void(0)" class="btn btn-primary btn-md waves-effect waves-light mb-1"
                                data-toggle="tooltip" title="Tambah Data" id="btnAdd">
                                <i class="fas fa-plus-circle"></i>
                            </a>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped dt-responsive nowrap w-100" id="Tabels">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tahun Ajaran</th>
                                        <th>Subyek</th>
                                        <th>Ditujukan Untuk</th>
                                        <th>Kepada</th>
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

            /* Get data table informasi */
            var table = $('#Tabels').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('kelola-pengumuman.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'tahun.tahun_ajaran',
                        name: 'tahun.tahun_ajaran'
                    },
                    {
                        data: 'subyek',
                        name: 'subyek'
                    },
                    {
                        data: 'kepada_role',
                        name: 'kepada_role'
                    },
                    {
                        data: 'kepadaDetail',
                        name: 'kepadaDetail'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    }
                ],
                columnDefs: [{
                        searchable: false,
                        orderable: false,
                        targets: [0, 5]
                    },
                    {
                        width: '1%',
                        targets: [0, 5]
                    },
                    {
                        targets: [3],
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

            /* Get data table notifikasi */
            var roleTable = $('#RoleTables').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('kelola-pengumuman.roleInfo') }}",
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

            /* Button Add */
            $("#btnAdd").click(function() {
                $('#FormAdd').trigger('reset');
                $(document).find('span.error-text').text('');
                $('#ModalAdd').modal('show');
                $('#tahun_ajaran_add').val('').trigger('change');
                $('#kepada_role_add').val('').trigger('change');
                $('#kepada_add').val('').trigger('change');
                $("#kepada_add").empty();
            });

            /* Button Edit */
            $('body').on('click', '#btnEdit', function() {
                $(document).find('span.error-text').text('');
                var this_id = $(this).data('id');
                $.get('kelola-pengumuman/' + this_id, function(data) {
                    $('#ModalEdit').modal('show');
                    $('#id_edit').val(data.id);
                    $('#tahun_ajaran_edit').val(data.tahun_ajaran_id).trigger('change');
                    $('#jenis_edit').val(data.jenis);
                    $('#kepada_role_edit').val(data.kepada_role).trigger('change');

                    if (data.kepada_role == "semua pengguna" || data.kepada_role ==
                        "koordinator dosen" || data.kepada_role ==
                        "dosen mahasiswa") {
                        $("#kepada_edit").empty();
                        var option = new Option("Semua", "0", true, true);
                        $('#kepada_edit').append(option).trigger('change');
                    } else {
                        $("#kepada_edit").empty();
                        var all = new Option("Semua", "0", true, true);
                        $.get('kelola-pengumuman/kepada/' + data.kepada_role, function(data) {
                            $('#kepada_edit').append(all);
                            $.each(data, function(prefix, val) {
                                var option = new Option(val.name, val.id, true,
                                    true);
                                $('#kepada_edit').append(option);
                            });
                        }).then(function() {
                            $('#kepada_edit').val(data.kepada).trigger('change');
                        });
                    }

                    $('#judul_edit').val(data.judul);
                    $('#subyek_edit').val(data.subyek);
                    $('#pesan_edit').val(data.pesan);
                });
            });

            /* Button Show */
            $('body').on('click', '#btnShow', function() {
                var this_id = $(this).data('id');
                $.get('kelola-pengumuman/' + this_id, function(data) {
                    $('#ModalShow').modal('show');
                    $('#tahun_ajaran_show').val(data.tahun.tahun_ajaran);
                    $('#jenis_show').val(data.jenis);
                    var str = capitalizeFirstLetter(data.kepada_role);
                    $('#kepada_role_show').val(str);
                    if (data.kepada == 0) {
                        $('#kepada_show').val("Semua");
                    } else {
                        $('#kepada_show').val(data.penerima.name);
                    }
                    $('#judul_show').val(data.judul);
                    $('#subyek_show').val(data.subyek);
                    $('#pesan_show').val(data.pesan);
                });
            });

            /* Button Delete */
            $('body').on('click', '#btnDelete', function() {
                var this_id = $(this).data("id");
                Swal.fire({
                    title: 'Data yang berkaitan akan terhapus secara keseluruhan! <br> Apakah anda ingin menghapus data ini?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Batal',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "kelola-pengumuman/delete/" + this_id,
                            type: 'post',
                            data: {
                                "id": this_id,
                            },
                            success: function(data) {
                                table.ajax.reload();
                                Swal.fire({
                                    title: data.msg,
                                    icon: "success",
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                            }
                        });
                    }
                });
            });

            /* Button Detail */
            $('body').on('click', '#btnDetail', function() {
                var this_id = $(this).data('id');
                $.get('kelola-pengumuman/role/info/' + this_id, function(data) {
                    $('#ModalDetail').modal('show');
                    $('#tahun_ajaran_detail').val(data.informasi.tahun.tahun_ajaran);
                    $('#jenis_detail').val(data.informasi.jenis);
                    $('#judul_detail').val(data.informasi.judul);
                    $('#subyek_detail').val(data.informasi.subyek);
                    $('#pesan_detail').val(data.informasi.pesan);
                }).then(function() {
                    loaderNotif();
                    roleTable.ajax.reload();
                });
            });

            /* Ajax Store */
            $("#FormAdd").submit(function(e) {
                var form = this;
                form.addSave.disabled = true;
                form.addSave.value = "Sedang memproses...";

                e.preventDefault();

                var formData = new FormData(this);

                $.ajax({
                    url: "{{ route('kelola-pengumuman.store') }}",
                    type: "POST",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $(document).find('span.error-text').text('');
                    },
                    success: function(data) {
                        if (data.status == 0) {
                            form.addSave.disabled = false;
                            form.addSave.value = "Simpan";
                            $.each(data.error, function(prefix, val) {
                                $('span.' + prefix + '_error').text(val[0]);
                            });
                        } else {
                            form.addSave.disabled = false;
                            form.addSave.value = "Simpan";
                            table.ajax.reload();
                            $("#ModalAdd").modal('hide');
                            Swal.fire({
                                title: data.msg,
                                icon: "success",
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }
                    },
                    error: function(response) {
                        form.addSave.disabled = false;
                        form.addSave.value = "Simpan";
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops, Muncul Kesalahan !!'
                        });
                    }
                });
            });

            /* Ajax Update */
            $("#FormEdit").submit(function(e) {
                var form = this;
                form.editSave.disabled = true;
                form.editSave.value = "Sedang memproses...";

                e.preventDefault();

                var this_id = document.getElementById("id_edit").value;
                var formData = new FormData(this);

                $.ajax({
                    url: "kelola-pengumuman/" + this_id,
                    type: "POST",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $(document).find('span.error-text').text('');
                    },
                    success: function(data) {
                        if (data.status == 0) {
                            form.editSave.disabled = false;
                            form.editSave.value = "Simpan";
                            $.each(data.error, function(prefix, val) {
                                $('span.' + prefix + '_error').text(val[0]);
                            });
                        } else {
                            form.editSave.disabled = false;
                            form.editSave.value = "Simpan";
                            table.ajax.reload();
                            $("#ModalEdit").modal('hide');
                            Swal.fire({
                                title: data.msg,
                                icon: "success",
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }
                    },
                    error: function(response) {
                        form.editSave.disabled = false;
                        form.editSave.value = "Simpan"
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops, Muncul Kesalahan !!'
                        });
                    }
                });
            });

            /* Select2 Tahun Ajaran Add */
            $("#tahun_ajaran_add").select2({
                dropdownParent: $('#ModalAdd'),
                placeholder: "Pilih berdasarkan tahun ...",
                allowClear: true
            });

            /* Select2 Tahun Ajaran Add */
            $("#kepada_role_add").select2({
                dropdownParent: $('#ModalAdd'),
                placeholder: "Pilih berdasarkan pengguna ...",
                minimumResultsForSearch: -1
            });

            /* Select2 Tahun Ajaran Add */
            $("#kepada_add").select2({
                dropdownParent: $('#ModalAdd'),
                placeholder: "Pilih berdasarkan nama pengguna ...",
                allowClear: true
            });

            /* Select2 Event Nama Dipilih Add */
            $('#kepada_role_add').on('select2:select', function(e) {
                var kode = $('#kepada_role_add option:selected').attr('value');
                if (kode == "semua pengguna" || kode == "koordinator dosen" || kode == "dosen mahasiswa") {
                    $("#kepada_add").empty();
                    var option = new Option("Semua", "0", true, true);
                    $('#kepada_add').append(option).trigger('change');
                } else if (kode == "koordinator") {
                    $("#kepada_add").empty();
                    $.get('kelola-pengumuman/kepada/' + kode, function(data) {
                        $.each(data, function(prefix, val) {
                            var option = new Option(val.name, val.id, true, true);
                            $('#kepada_add').append(option).trigger('change');
                        });
                    });
                } else {
                    $("#kepada_add").empty();
                    var all = new Option("Semua", "0", true, true);
                    $.get('kelola-pengumuman/kepada/' + kode, function(data) {
                        $('#kepada_add').append(all);
                        $.each(data, function(prefix, val) {
                            var option = new Option(val.name, val.id, true, true);
                            $('#kepada_add').append(option);
                        });
                    }).then(function() {
                        $('#kepada_add').val('').trigger('change');
                    });
                }
            });

            /* Select2 Tahun Ajaran Edit */
            $("#tahun_ajaran_edit").select2({
                dropdownParent: $('#ModalEdit'),
                placeholder: "Pilih berdasarkan tahun ...",
                allowClear: true
            });

            /* Select2 Tahun Ajaran Edit */
            $("#kepada_role_edit").select2({
                dropdownParent: $('#ModalEdit'),
                placeholder: "Pilih berdasarkan pengguna ...",
                minimumResultsForSearch: -1
            });

            /* Select2 Tahun Ajaran Edit */
            $("#kepada_edit").select2({
                dropdownParent: $('#ModalEdit'),
                placeholder: "Pilih berdasarkan nama pengguna ...",
                allowClear: true
            });

            /* Select2 Event Nama Dipilih Edit */
            $('#kepada_role_edit').on('select2:select', function(e) {
                var kode = $('#kepada_role_edit option:selected').attr('value');
                if (kode == "semua pengguna" || kode == "koordinator dosen" || kode == "dosen mahasiswa") {
                    $("#kepada_edit").empty();
                    var option = new Option("Semua", "0", true, true);
                    $('#kepada_edit').append(option).trigger('change');
                } else if (kode == "koordinator") {
                    $("#kepada_add").empty();
                    $.get('kelola-pengumuman/kepada/' + kode, function(data) {
                        $.each(data, function(prefix, val) {
                            var option = new Option(val.name, val.id, true, true);
                            $('#kepada_add').append(option).trigger('change');
                        });
                    });
                } else {
                    $("#kepada_edit").empty();
                    var all = new Option("Semua", "0", true, true);
                    $.get('kelola-pengumuman/kepada/' + kode, function(data) {
                        $('#kepada_edit').append(all);
                        $.each(data, function(prefix, val) {
                            var option = new Option(val.name, val.id, true, true);
                            $('#kepada_edit').append(option);
                        });
                    }).then(function() {
                        $('#kepada_edit').val('').trigger('change');
                    });
                }
            });
        });
    </script>
@endsection
