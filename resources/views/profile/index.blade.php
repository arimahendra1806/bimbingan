@extends('layouts.minia.header')

@section('content')
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Profil Pengguna</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                            <li class="breadcrumb-item active">Profil Pengguna</li>
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
                        <h4 class="card-title">Profil Pengguna</h4>
                        <p class="card-title-desc">Anda dapat memperbarui data pribadi melalui form berikut.</p>
                    </div>
                    <div class="card-body">
                        <form id="updateForm">
                            @csrf
                            <div class="row mb-2">
                                <div class="col-md-4">
                                    <label for="nama" class="col-form-label">Nama Anda:</label>
                                    @if ((Auth::check() && Auth::user()->role == 'koordinator') || Auth::user()->role == 'kaprodi' || (Auth::check() && Auth::user()->role == 'dosen'))
                                        <input type="text" class="form-control" value="{{ $data->dosen->nama_dosen }}"
                                            id="nama" name="nama" placeholder="e.g: Budi">
                                    @elseif(Auth::check() && Auth::user()->role == 'mahasiswa')
                                        <input type="text" class="form-control"
                                            value="{{ $data->mahasiswa->nama_mahasiswa }}" id="nama" name="nama"
                                            placeholder="e.g: Budi">
                                    @elseif(Auth::check() && Auth::user()->role == 'admin')
                                        <input type="text" class="form-control" value="{{ $data->admin->nama_admin }}"
                                            id="nama" name="nama" placeholder="e.g: Budi">
                                    @endif
                                    <span class="text-danger error-text nama_error"></span>
                                </div>
                                <div class="col-md-4">
                                    <label for="email" class="col-form-label">Email Anda:</label>
                                    @if ((Auth::check() && Auth::user()->role == 'koordinator') || Auth::user()->role == 'kaprodi' || (Auth::check() && Auth::user()->role == 'dosen'))
                                        <input type="email" class="form-control" value="{{ $data->dosen->email }}"
                                            id="email" name="email" placeholder="e.g: Budi@gmail.com">
                                    @elseif(Auth::check() && Auth::user()->role == 'mahasiswa')
                                        <input type="email" class="form-control" value="{{ $data->mahasiswa->email }}"
                                            id="email" name="email" placeholder="e.g: Budi@gmail.com">
                                    @elseif(Auth::check() && Auth::user()->role == 'admin')
                                        <input type="email" class="form-control" value="{{ $data->admin->email }}"
                                            id="email" name="email" placeholder="e.g: Budi@gmail.com">
                                    @endif
                                    <span class="text-danger error-text email_error"></span>
                                </div>
                                <div class="col-md-4">
                                    <label for="telepon" class="col-form-label">Nomor Telepon Anda:</label>
                                    @if ((Auth::check() && Auth::user()->role == 'koordinator') || Auth::user()->role == 'kaprodi' || (Auth::check() && Auth::user()->role == 'dosen'))
                                        <div class="input-group">
                                            <div class="input-group-text">+62</div>
                                            <input type="text" class="form-control"
                                                value="{{ $data->dosen->no_telepon }}" id="telepon" name="telepon"
                                                placeholder="e.g: 81XXXXXXXX">
                                        </div>
                                    @elseif(Auth::check() && Auth::user()->role == 'mahasiswa')
                                        <div class="input-group">
                                            <div class="input-group-text">+62</div>
                                            <input type="text" class="form-control"
                                                value="{{ $data->mahasiswa->no_telepon }}" id="telepon" name="telepon"
                                                placeholder="e.g: 81XXXXXXXX">
                                        </div>
                                    @elseif(Auth::check() && Auth::user()->role == 'admin')
                                        <div class="input-group">
                                            <div class="input-group-text">+62</div>
                                            <input type="text" class="form-control"
                                                value="{{ $data->admin->no_telepon }}" id="telepon" name="telepon"
                                                placeholder="e.g: 81XXXXXXXX">
                                        </div>
                                    @endif
                                    <span class="text-danger error-text telepon_error"></span>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="password" class="col-form-label">Password Baru: <b class="info">*Kosongkan
                                            Jika Tidak Update</b></label>
                                    <div class="input-group auth-pass-inputgroup">
                                        <input type="password" class="form-control" placeholder="Enter password"
                                            aria-label="Password" aria-describedby="password" name="password">
                                        <button class="btn btn-light shadow-none ms-0" type="button" id="password"><i
                                                class="mdi mdi-eye-outline"></i></button>
                                    </div>
                                    <span class="text-danger error-text password_error"></span>
                                </div>
                                <div class="col-md-6">
                                    <label for="confirm" class="col-form-label">Konfirmasi Password Baru: <b
                                            class="info">*Kosongkan Jika Tidak Update</b></label>
                                    <div class="input-group auth-pass-inputgroup">
                                        <input type="password" class="form-control" placeholder="Enter password"
                                            aria-label="Password" aria-describedby="confirm" name="confirm">
                                        <button class="btn btn-light shadow-none ms-0" type="button" id="confirm"><i
                                                class="mdi mdi-eye-outline"></i></button>
                                    </div>
                                    <span class="text-danger error-text confirm_error"></span>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-12 d-flex justify-content-end">
                                    <input type="submit" class="btn btn-primary" name="editSave" value="Simpan">
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
    <script>
        $(document).ready(function() {
            /* Ajax Token */
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $("#password").on("click", function() {
                0 < $(this).siblings("input").length && ("password" == $(this).siblings("input").attr(
                        "type") ? $(this)
                    .siblings("input").attr("type", "input") : $(this).siblings("input").attr("type",
                        "password"))
            });
            $("#confirm").on("click", function() {
                0 < $(this).siblings("input").length && ("password" == $(this).siblings("input").attr(
                        "type") ? $(this)
                    .siblings("input").attr("type", "input") : $(this).siblings("input").attr("type",
                        "password"))
            });

            /* Ajax Update */
            $("#updateForm").submit(function(e) {
                var form = this;
                form.editSave.disabled = true;
                form.editSave.value = "Sedang memproses...";

                e.preventDefault();

                var formData = new FormData(this);

                $.ajax({
                    url: "{{ route('profile.update') }}",
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
                            $('#updateForm').trigger('reset');
                            $('#nama').val(data.nama);
                            $('#email').val(data.email);
                            $('#telepon').val(data.telepon);
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
                            title: 'Oops, Muncul Kesalahan !!',
                        });
                    }
                });
            });
        });
    </script>
@endsection
