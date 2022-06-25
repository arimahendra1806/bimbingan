@extends('layouts.minia.header')

@section('content')
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Pengumpulan Proposal</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard.home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Pengumpulan Proposal</li>
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
                        <h4 class="card-title">Pengumpulan Proposal</h4>
                        <p class="card-title-desc">
                            Setelah Anda melakukan <b>pengujian</b> dan <b>sudah melakukan revisi</b>, segera upload
                            <b>lembar pengumpulan proposal</b> yang mengetahui Pihak Perpustakaan, Pihak Prodi
                            Manajemen Informatika, dan Pihak Akademik.
                        </p>
                    </div>
                    <div class="card-body">
                        <input type="hidden" id="cek_status" value="{{ $cek_status }}">
                        <input type="hidden" id="cek_file" value="{{ $cek_file }}">
                        <form id="FormAdd" enctype="multipart/form-data" files="true">
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="file_upload" class="col-form-label">Lembar Bukti Pengumpulan: <b
                                            class="error">*Pastikan Format PDF/JPG/PNG/JPEG | Max 2Mb</b></label>
                                    <input type="file" class="form-control mb-2" id="file_upload" name="file_upload">
                                    <div class="col-lg-12" id="status_upload"></div>
                                    <div class="container">
                                        <div class="d-sm-flex align-items-center justify-content-center">
                                            <span>
                                                <img id="fileView" src="#" alt="your image" width="250px"
                                                    height="350px" />
                                            </span>
                                            <button></button>
                                        </div>
                                    </div>
                                    <span class="text-danger error-text file_upload_error mb-3"></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="d-sm-flex align-items-center justify-content-end">
                                        <input type="submit" class="btn btn-primary" name="addSave"
                                            value="Upload Sekarang">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    {{-- DataTables --}}
    <script>
        $(document).ready(function() {
            /* Ajax Token */
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            function addTampilan() {
                $('#status_upload').addClass('bg-success text-white mb-3 p-2 rounded-2');
            }

            $(function() {
                $('#status_upload').hide();
                $('#fileView').hide();
            });

            $(function() {
                var x = $('#cek_status').val();
                var y = $('#cek_file').val();
                alert(y);
                if (x != 0) {
                    $('#status_upload').text(x);
                    $('#status_upload').show();
                    addTampilan();
                }
                if (y != '0') {
                    $('#fileView').attr('src', 'dokumen/pengumpulan/proposal/' + y);
                    $('#fileView').show();
                }
            });

            file_upload.onchange = evt => {
                const [file] = file_upload.files
                if (file) {
                    fileView.src = URL.createObjectURL(file);
                    $('#fileView').show();
                }
            }

            /* Ajax Store */
            $("#FormAdd").submit(function(e) {
                var form = this;
                form.addSave.disabled = true;
                form.addSave.value = "Sedang memproses...";

                e.preventDefault();

                var formData = new FormData(this);

                $.ajax({
                    url: "{{ route('pengumpulan-proposal.storePro') }}",
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
                            form.addSave.value = "Upload Sekarang";
                            $.each(data.error, function(prefix, val) {
                                $('span.' + prefix + '_error').text(val[0]);
                            });
                        } else {
                            form.addSave.disabled = false;
                            form.addSave.value = "Upload Sekarang";
                            addTampilan();
                            $('#status_upload').text(data.resp.status + " | " + data.resp
                                .keterangan);
                            $('#fileView').attr('src', '/dokumen/pengumpulan/proposal/' + data
                                .resp
                                .nama_file);
                            $('#status_upload').show();
                            $('#fileView').show();
                            $('#FormAdd').trigger('reset');
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
                        form.addSave.value = "Upload Sekarang";
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops, Muncul Kesalahan !!'
                        });
                    }
                });
            });
        });
    </script>
    {{-- END DataTables --}}
@endsection
