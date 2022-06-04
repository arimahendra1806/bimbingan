<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>Login SITAMI</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('vendor/minia') }}/assets/images/favicon.ico">

    <!-- preloader css -->
    <link rel="stylesheet" href="{{ asset('vendor/minia') }}/assets/css/preloader.min.css" type="text/css" />

    <!-- Bootstrap Css -->
    <link href="{{ asset('vendor/minia') }}/assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet"
        type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('vendor/minia') }}/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('vendor/minia') }}/assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />

</head>

<body>

    <!-- <body data-layout="horizontal"> -->
    <div class="auth-page">
        <div class="container-fluid p-0">
            <div class="row g-0">
                <div class="col-xxl-3 col-lg-4 col-md-5">
                    <div class="auth-full-page-content d-flex p-sm-5 p-4">
                        <div class="w-100">
                            <div class="d-flex flex-column h-100">
                                <div class="mb-4 mb-md-5 text-center">
                                    <a href="index.html" class="d-block auth-logo">
                                        <img src="{{ asset('vendor/minia') }}/assets/images/logo-sm.svg" alt=""
                                            height="28"> <span class="logo-txt">SITAMI</span>
                                    </a>
                                    <p class="mb-0 mt-4 pd-2 text-muted" style="font-size: 11pt">
                                        <b>S</b>istem <b>I</b>nformasi <b>T</b>ugas <b>A</b>khir <b>M</b>anajemen
                                        <b>I</b>nformatika <br>
                                        PSDKU POLINEMA
                                        Kota
                                        Kediri
                                    </p>
                                </div>
                                <div>
                                    <div class="text-center">
                                        <h5 class="mb-0">Selamat Datang</h5>
                                        <p class="text-muted mt-2">Silahkan masuk untuk melanjutkan!</p>
                                    </div>
                                    @if (Session::has('msg'))
                                        <div class="alert alert-danger mt-4 pt-2">
                                            {{ Session::get('msg') }}
                                        </div>
                                    @endif
                                    <form method="POST" action="{{ route('postlogin') }}">
                                        @csrf
                                        <div class="mb-3">
                                            <label class="form-label">Username</label>
                                            <input type="text"
                                                class="form-control @error('username') is-invalid @enderror"
                                                id="username" placeholder="Masukkan username Anda" name="username"
                                                value="{{ old('username') }}" required autocomplete="username"
                                                autofocus>

                                            @error('username')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <div class="d-flex align-items-start">
                                                <div class="flex-grow-1">
                                                    <label class="form-label">Password</label>
                                                </div>
                                            </div>

                                            <div class="input-group auth-pass-inputgroup">
                                                <input type="password"
                                                    class="form-control @error('password') is-invalid @enderror"
                                                    placeholder="Enter password" aria-label="Password"
                                                    aria-describedby="password-addon" name="password" required
                                                    autocomplete="current-password">
                                                <button class="btn btn-light shadow-none ms-0" type="button"
                                                    id="password-addon"><i class="mdi mdi-eye-outline"></i></button>
                                            </div>

                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <button class="btn btn-primary w-100 waves-effect waves-light"
                                                type="submit">Masuk</button>
                                        </div>
                                    </form>

                                </div>
                                <div class="mt-4 mt-md-5 text-center">
                                    <p class="mb-0">©
                                        <script>
                                            document.write(new Date().getFullYear())
                                        </script> PSDKU POLINEMA Kota Kediri.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end auth full page content -->
                </div>
                <!-- end col -->
                <div class="col-xxl-9 col-lg-8 col-md-7">
                    <div class="auth-bg pt-md-5 p-4 d-flex">
                        <div class="bg-overlay bg-primary"></div>
                        <ul class="bg-bubbles">
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                        </ul>
                        <!-- end bubble effect -->
                        <div class="row justify-content-center align-items-center">
                            <div class="col-xl-7">
                                <div class="p-0 p-sm-4 px-xl-0">
                                    <div id="reviewcarouselIndicators" class="carousel slide" data-bs-ride="carousel">
                                        <div
                                            class="carousel-indicators carousel-indicators-rounded justify-content-start ms-0 mb-0">
                                            <button type="button" data-bs-target="#reviewcarouselIndicators"
                                                data-bs-slide-to="0" class="active" aria-current="true"
                                                aria-label="Slide 1"></button>
                                            <button type="button" data-bs-target="#reviewcarouselIndicators"
                                                data-bs-slide-to="1" aria-label="Slide 2"></button>
                                            <button type="button" data-bs-target="#reviewcarouselIndicators"
                                                data-bs-slide-to="2" aria-label="Slide 3"></button>
                                        </div>
                                        <!-- end carouselIndicators -->
                                        <div class="carousel-inner">
                                            <div class="carousel-item active">
                                                <div class="testi-contain text-white">
                                                    <i class="bx bxs-quote-alt-left text-success display-6"></i>

                                                    <h4 class="mt-4 fw-medium lh-base text-white">“Aplikasi SITAMI
                                                        mempunyai kepanjangan ialah Sistem Informasi Tugas Akhir
                                                        Manajemen Informatika, yang dikelola oleh PSDKU POLINEMA Kota
                                                        Kediri.”
                                                    </h4>
                                                    <div class="mt-4 pt-3 pb-5">
                                                        <div class="d-flex align-items-start">
                                                            <div class="flex-shrink-0">
                                                                <img src="{{ asset('vendor/minia') }}/assets/images/users/avatar-10.jpg"
                                                                    class="avatar-md img-fluid rounded-circle"
                                                                    alt="...">
                                                            </div>
                                                            <div class="flex-grow-1 ms-3 mb-4">
                                                                <h5 class="font-size-18 text-white">Tim SITAMI
                                                                </h5>
                                                                <p class="mb-0 text-white-50">Pengelola Website</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="carousel-item">
                                                <div class="testi-contain text-white">
                                                    <i class="bx bxs-quote-alt-left text-success display-6"></i>

                                                    <h4 class="mt-4 fw-medium lh-base text-white">“Aplikasi SITAMI
                                                        menangungi konsultasi bimbingan tugas akhir bagi Mahasiswa
                                                        Program Studi Manajemen Informatika PSDKU POLINEMA Kota Kediri.”
                                                    </h4>
                                                    <div class="mt-4 pt-3 pb-5">
                                                        <div class="d-flex align-items-start">
                                                            <div class="flex-shrink-0">
                                                                <img src="{{ asset('vendor/minia') }}/assets/images/users/avatar-10.jpg"
                                                                    class="avatar-md img-fluid rounded-circle"
                                                                    alt="...">
                                                            </div>
                                                            <div class="flex-grow-1 ms-3 mb-4">
                                                                <h5 class="font-size-18 text-white">Tim SITAMI
                                                                </h5>
                                                                <p class="mb-0 text-white-50">Pengelola Website</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="carousel-item">
                                                <div class="testi-contain text-white">
                                                    <i class="bx bxs-quote-alt-left text-success display-6"></i>

                                                    <h4 class="mt-4 fw-medium lh-base text-white">“Segera perbarui
                                                        password Anda setelah memperoleh akun dari Koordinator TA.
                                                        Manfaatkan aplikasi SITAMI, perbanyak konsultasi bimbingan Anda
                                                        dan segera menyelesaikan tugas akhir Anda.”</h4>
                                                    <div class="mt-4 pt-3 pb-5">
                                                        <div class="d-flex align-items-start">
                                                            <img src="{{ asset('vendor/minia') }}/assets/images/users/avatar-10.jpg"
                                                                class="avatar-md img-fluid rounded-circle" alt="...">
                                                            <div class="flex-1 ms-3 mb-4">
                                                                <h5 class="font-size-18 text-white">Tim SITAMI</h5>
                                                                <p class="mb-0 text-white-50">Pengelola Website</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end carousel-inner -->
                                    </div>
                                    <!-- end review carousel -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container fluid -->
    </div>


    <!-- JAVASCRIPT -->
    <script src="{{ asset('vendor/minia') }}/assets/libs/jquery/jquery.min.js"></script>
    <script src="{{ asset('vendor/minia') }}/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('vendor/minia') }}/assets/libs/metismenu/metisMenu.min.js"></script>
    <script src="{{ asset('vendor/minia') }}/assets/libs/simplebar/simplebar.min.js"></script>
    <script src="{{ asset('vendor/minia') }}/assets/libs/node-waves/waves.min.js"></script>
    <script src="{{ asset('vendor/minia') }}/assets/libs/feather-icons/feather.min.js"></script>
    <!-- pace js -->
    <script src="{{ asset('vendor/minia') }}/assets/libs/pace-js/pace.min.js"></script>
    <!-- password addon init -->
    <script src="{{ asset('vendor/minia') }}/assets/js/pages/pass-addon.init.js"></script>

</body>

</html>
