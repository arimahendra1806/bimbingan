@extends('layouts.minia.header')

@section('content')
    {{-- Modal Edit --}}
    <div class="modal fade" id="ModalEdit" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Perbarui Data Verifikasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="FormEdit">
                    <input type="hidden" class="form-control" id="id_edit" name="id_edit">
                    @csrf
                    <div class="modal-body">
                        <div class="row mb-1">
                            <div class="col-md-12">
                                <label for="status" class="col-form-label">Status Verifikasi:</label>
                                <select class="js-example-responsive form-control" style="width: 100%" id="status"
                                    name="status" readonly>
                                    <option value="Sedang Diproses" disabled>Sedang Diproses</option>
                                    <option value="Sudah Divalidasi">Sudah Divalidasi</option>
                                    <option value="Tidak Diterima">Tidak Diterima</option>
                                </select>
                                <span class="text-danger error-text status_error"></span>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="keterangan" class="col-form-label">Keterangan: <b class="info">*Otomatis
                                        diperbarui ketika ubah status | Anda juga dapat menambahkan keterangan</b></label>
                                <textarea name="keterangan" class="form-control" id="keterangan" style="width: 100%" rows="3"></textarea>
                                <span class="text-danger error-text keterangan_error"></span>
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

    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Verifikasi Lembar Pengumpulan Proposal TA</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard.home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Verifikasi Lembar Pengumpulan Proposal TA</li>
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
                        <h4 class="card-title">Verifikasi Lembar Pengumpulan Proposal TA</h4>
                        <p class="card-title-desc">
                            Segera verifikasi lembar pengumpulan proposal TA dari masing-masing Mahasiswa.
                        </p>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped dt-responsive nowrap w-100" id="Tabels">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tahun Ajaran</th>
                                        <th>Waktu Upload</th>
                                        <th>Nama Mahasiswa</th>
                                        <th>Status Verifikasi</th>
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
    <!-- glightbox css -->
    <link rel="stylesheet" href="{{ asset('vendor/minia') }}/assets/libs/glightbox/css/glightbox.min.css">
    <!-- glightbox js -->
    <script src="{{ asset('vendor/minia') }}/assets/libs/glightbox/js/glightbox.min.js"></script>
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
                ajax: "{{ route('pengumpulan-proposal.indexAdmPro') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'tahun.tahun_ajaran',
                        name: 'tahun.tahun_ajaran'
                    },
                    {
                        data: 'waktu',
                        name: 'waktu'
                    },
                    {
                        data: 'mhs.nama_mahasiswa',
                        name: 'mhs.nama_mahasiswa'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    },
                ],
                columnDefs: [{
                        searchable: false,
                        orderable: false,
                        targets: [0, 5]
                    },
                    {
                        width: '1%',
                        targets: [0, 5]
                    }
                ],
                order: [
                    [4, 'asc']
                ],
                oLanguage: {
                    sUrl: "/vendor/minia/assets/libs/datatables.net/js/indonesian.json"
                }
            });

            /* Button Tooltip */
            $('table').on('draw.dt', function() {
                $('[data-toggle="tooltip"]').tooltip();
            });

            $('body').on('click', '#btnShow', function() {
                var this_id = 'dokumen/pengumpulan/proposal/' + $(this).data('id');
                const myGallery = GLightbox({
                    elements: [{
                        'href': this_id,
                        'type': 'image',
                    }]
                });
                myGallery.open();
            });

            /* Button Edit */
            $('body').on('click', '#btnEdit', function() {
                var this_id = $(this).data('id');
                $.get('show-verifikasi-pengumpulan/' + this_id, function(data) {
                    $('#ModalEdit').modal('show');
                    $('#id_edit').val(data.id);
                    $('#status').val(data.status).trigger('change');
                    $('#keterangan').val(data.keterangan);
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
                    url: "verfikasi-pengumpulan/" + this_id,
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
                        form.editSave.value = "Simpan";
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops, Muncul Kesalahan !!'
                        });
                    }
                });
            });

            /* Select2 Status Edit */
            $("#status").select2({
                dropdownParent: $('#ModalEdit'),
                placeholder: "Pilih berdasarkan status pengerjaan ..",
                minimumResultsForSearch: -1
            });

            /* Select2 Event Pengerjaan Edit */
            $('#status').on('select2:select', function(e) {
                const y = $('#status').val();
                if (y == "Sudah Divalidasi") {
                    $('#keterangan').val('Admin Prodi sudah memvalidasi lembar pengumpulan proposal Anda.');
                } else if (y == "Tidak Diterima") {
                    $('#keterangan').val(
                        'Admin Prodi tidak menerima lembar pengumpulan proposal Anda. Silahkan upload kembali!'
                    );
                }
            });

            /* Import Info Gambar */
            const lightbox = GLightbox({});
        });
    </script>
@endsection
