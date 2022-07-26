<!-- ========== Topbar Start ========== -->
<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a href="index.html" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="{{ asset('vendor/minia') }}/assets/images/logo-sm.svg" alt="" height="24">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset('vendor/minia') }}/assets/images/logo-sm.svg" alt="" height="24">
                        <span class="logo-txt" style="font-size: 10pt">SITAMI POLINEMA</span>
                    </span>
                </a>
            </div>

            <button type="button" class="btn btn-sm px-3 font-size-16 header-item" id="vertical-menu-btn">
                <i class="fa fa-fw fa-bars"></i>
            </button>

            <span style="margin-top: 20px">
                <p style="font-size: 20px; font-family: Arial, Helvetica, sans-serif;"><b>SITAMI</b> - <b>S</b>istem
                    <b>I</b>nformasi
                    <b>T</b>ugas
                    <b>A</b>khir
                    <b>M</b>anajemen
                    <b>I</b>nformatika
                    {{-- POLINEMA PSDKU Kota Kediri --}}
                </p>
            </span>
            <!-- App Search-->
            {{-- <form class="app-search d-none d-lg-block">
                <div class="position-relative">
                    <input type="text" class="form-control" placeholder="Search...">
                    <button class="btn btn-primary" type="button"><i class="bx bx-search-alt align-middle"></i></button>
                </div>
            </form> --}}
        </div>

        <div class="d-flex">

            {{-- <div class="dropdown d-inline-block d-lg-none ms-2">
                <button type="button" class="btn header-item" id="page-header-search-dropdown"
                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i data-feather="search" class="icon-lg"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                    aria-labelledby="page-header-search-dropdown">

                    <form class="p-3">
                        <div class="form-group m-0">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search ..." aria-label="Search Result">

                                <button class="btn btn-primary" type="submit"><i class="mdi mdi-magnify"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div> --}}

            {{-- <div class="dropdown d-none d-sm-inline-block">
                <button type="button" class="btn header-item"
                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img id="header-lang-img" src="{{ asset('vendor/minia') }}/assets/images/flags/us.jpg" alt="Header Language" height="16">
                </button>
                <div class="dropdown-menu dropdown-menu-end">

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item language" data-lang="en">
                        <img src="{{ asset('vendor/minia') }}/assets/images/flags/us.jpg" alt="user-image" class="me-1" height="12"> <span class="align-middle">English</span>
                    </a>
                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item language" data-lang="sp">
                        <img src="{{ asset('vendor/minia') }}/assets/images/flags/spain.jpg" alt="user-image" class="me-1" height="12"> <span class="align-middle">Spanish</span>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item language" data-lang="gr">
                        <img src="{{ asset('vendor/minia') }}/assets/images/flags/germany.jpg" alt="user-image" class="me-1" height="12"> <span class="align-middle">German</span>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item language" data-lang="it">
                        <img src="{{ asset('vendor/minia') }}/assets/images/flags/italy.jpg" alt="user-image" class="me-1" height="12"> <span class="align-middle">Italian</span>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item language" data-lang="ru">
                        <img src="{{ asset('vendor/minia') }}/assets/images/flags/russia.jpg" alt="user-image" class="me-1" height="12"> <span class="align-middle">Russian</span>
                    </a>
                </div>
            </div> --}}

            {{-- <div class="dropdown d-none d-sm-inline-block">
                <button type="button" class="btn header-item" id="mode-setting-btn">
                    <i data-feather="moon" class="icon-lg layout-mode-dark"></i>
                    <i data-feather="sun" class="icon-lg layout-mode-light"></i>
                </button>
            </div> --}}

            {{-- <div class="dropdown d-none d-lg-inline-block ms-1">
                <button type="button" class="btn header-item"
                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i data-feather="grid" class="icon-lg"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                    <div class="p-2">
                        <div class="row g-0">
                            <div class="col">
                                <a class="dropdown-icon-item" href="#">
                                    <img src="{{ asset('vendor/minia') }}/assets/images/brands/github.png" alt="Github">
                                    <span>GitHub</span>
                                </a>
                            </div>
                            <div class="col">
                                <a class="dropdown-icon-item" href="#">
                                    <img src="{{ asset('vendor/minia') }}/assets/images/brands/bitbucket.png" alt="bitbucket">
                                    <span>Bitbucket</span>
                                </a>
                            </div>
                            <div class="col">
                                <a class="dropdown-icon-item" href="#">
                                    <img src="{{ asset('vendor/minia') }}/assets/images/brands/dribbble.png" alt="dribbble">
                                    <span>Dribbble</span>
                                </a>
                            </div>
                        </div>

                        <div class="row g-0">
                            <div class="col">
                                <a class="dropdown-icon-item" href="#">
                                    <img src="{{ asset('vendor/minia') }}/assets/images/brands/dropbox.png" alt="dropbox">
                                    <span>Dropbox</span>
                                </a>
                            </div>
                            <div class="col">
                                <a class="dropdown-icon-item" href="#">
                                    <img src="{{ asset('vendor/minia') }}/assets/images/brands/mail_chimp.png" alt="mail_chimp">
                                    <span>Mail Chimp</span>
                                </a>
                            </div>
                            <div class="col">
                                <a class="dropdown-icon-item" href="#">
                                    <img src="{{ asset('vendor/minia') }}/assets/images/brands/slack.png" alt="slack">
                                    <span>Slack</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}

            <div class="dropdown d-inline-block" style="margin-right: 10px">
                <button type="button" class="btn header-item noti-icon position-relative"
                    id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    <i data-feather="bell" class="icon-lg"></i>
                    <span class="badge bg-danger rounded-pill" id="countNotif"></span>
                </button>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                    aria-labelledby="page-header-notifications-dropdown">
                    <div class="p-3">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="m-0"> Notifikasi Informasi </h6>
                            </div>
                        </div>
                    </div>
                    <div data-simplebar style="max-height: 230px;">
                        @if (Auth::check() && Auth::user()->role == 'mahasiswa')
                            <a href="{{ route('pengumuman.indexMhs') }}" class="text-reset notification-item">
                            @else
                                <a href="{{ route('kelola-pengumuman.index') }}" class="text-reset notification-item">
                        @endif
                        <div class="d-flex">
                            <div class="flex-shrink-0 avatar-sm me-3">
                                <span class="avatar-title bg-success rounded-circle font-size-16">
                                    <i class="bx bx-info-circle"></i>
                                </span>
                            </div>
                            <div class="flex-grow-1">
                                <span class="badge rounded-pill bg-soft-danger text-danger float-end"
                                    id="countNotifPengumuman"></span>
                                <h6 class="mb-1">Pengumuman Terbaru</h6>
                                <div class="font-size-13 text-muted">
                                    <p class="mb-1">Segera cek informasi pengumuman Anda sekarang.</p>
                                </div>
                            </div>
                        </div>
                        </a>
                        @if (Auth::check() && Auth::user()->role == 'mahasiswa')
                            <a href="{{ route('peringatan.indexMhs') }}" class="text-reset notification-item">
                            @else
                                <a href="{{ route('kelola-peringatan.index') }}" class="text-reset notification-item">
                        @endif
                        <div class="d-flex">
                            <div class="flex-shrink-0 avatar-sm me-3">
                                <span class="avatar-title bg-warning rounded-circle font-size-16">
                                    <i class="bx bx-error"></i>
                                </span>
                            </div>
                            <div class="flex-grow-1">
                                <span class="badge rounded-pill bg-soft-danger text-danger float-end"
                                    id="countNotifPeringatan"></span>
                                <h6 class="mb-1">Peringatan Terbaru</h6>
                                <div class="font-size-13 text-muted">
                                    <p class="mb-1">Segera cek informasi peringatan Anda sekarang.</p>
                                </div>
                            </div>
                        </div>
                        </a>
                    </div>
                    <div class="p-2 border-top d-grid">
                        <a class="btn btn-sm btn-link font-size-14 text-center" id="btnReadAll">
                            <i class="mdi mdi-arrow-right-circle me-1"></i> <span>Tandai Terbaca Semua!</span>
                        </a>
                    </div>
                </div>
            </div>

            {{-- <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item right-bar-toggle me-2">
                    <i data-feather="settings" class="icon-lg"></i>
                </button>
            </div> --}}

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item bg-soft-light border-start border-end"
                    id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="mdi mdi-account-circle mdi-24px align-middle me-1"></i>
                    <span class="d-none d-xl-inline-block ms-1 fw-medium">{{ Str::words(Auth::user()->name, 2, '') }}
                        |
                        {{ ucfirst(Auth::user()->role) }}</span>
                    <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <!-- item-->
                    {{-- <a class="dropdown-item" href="{{ asset('vendor/minia') }}/apps-contacts-profile.html"><i
                            class="mdi mdi-face-profile font-size-16 align-middle me-1"></i> Profile</a> --}}
                    <a class="dropdown-item" href="{{ route('profile.index') }}"><i
                            class="mdi mdi-account-key font-size-16 align-middle me-1"></i> Profil Saya</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="/logout"><i
                            class="mdi mdi-logout font-size-16 align-middle me-1"></i> Logout</a>
                </div>
            </div>

        </div>
    </div>
</header>
<!-- Topbar End -->
