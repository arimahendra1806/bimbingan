<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" data-key="t-menu">
                    <h5>Menu</h5>
                </li>

                <li>
                    <a href="{{ route('dashboard.home') }}">
                        <i data-feather="home"></i>
                        <span data-key="t-dashboard">Dashboard</span>
                    </a>
                </li>
                @if (Auth::check() && Auth::user()->role == 'koordinator')
                    <li>
                        <a href="javascript: void(0);" class="has-arrow">
                            <i data-feather="calendar"></i>
                            <span data-key="t-apps">Kelola Tahunan</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li>
                                <a href="{{ route('tahun-ajaran.index') }}">
                                    <span data-key="t-chat">Tahun Ajaran</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('materi-tahunan.index') }}">
                                    <span data-key="t-chat">Materi Tahunan</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript: void(0);" class="has-arrow">
                            <i data-feather="bell"></i>
                            <span data-key="t-apps">Kelola Informasi</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li>
                                <a href="javascript: void(0);">
                                    <span data-key="t-chat">Pengumuman</span>
                                </a>
                            </li>
                            <li>
                                <a href="javascript: void(0);">
                                    <span data-key="t-chat">Peringatan</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript: void(0);" class="has-arrow">
                            <i data-feather="users"></i>
                            <span data-key="t-apps">Kelola Data Pengguna</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li>
                                <a href="{{ route('kelola-dosen.index') }}">
                                    <span data-key="t-chat">Data Dosen</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('kelola-mahasiswa.index') }}">
                                    <span data-key="t-chat">Data Mahasiswa</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('dosen-pembimbing.index') }}">
                                    <span data-key="t-chat">Data Dosen Pembimbing</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('pengguna.index') }}">
                                    <span data-key="t-user-list">Pengguna Aplikasi</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="{{ route('link-zoom.index') }}">
                            <i data-feather="video"></i>
                            <span data-key="t-dashboard">Kelola Link Zoom</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('judul-mahasiswa.indexKoor') }}">
                            <i data-feather="book-open"></i>
                            <span data-key="t-dashboard">Daftar Judul Mahasiswa</span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript: void(0);">
                            <i data-feather="menu"></i>
                            <span data-key="t-dashboard">Progress Bimbingan</span>
                        </a>
                    </li>
                @elseif(Auth::check() && Auth::user()->role == 'kaprodi')
                    <li>
                        <a href="javascript: void(0);">
                            <i data-feather="menu"></i>
                            <span data-key="t-dashboard">Tes Kaprodi</span>
                        </a>
                    </li>
                @elseif(Auth::check() && Auth::user()->role == 'dosen')
                    <li>
                        <a href="{{ route('ketentuan-ta.index') }}">
                            <i data-feather="bookmark"></i>
                            <span data-key="t-dashboard">Ketentuan TA</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('materi-dosen.index') }}">
                            <i data-feather="file"></i>
                            <span data-key="t-dashboard">Materi Pembimbing</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('data-mahasiswa.indexDsn') }}">
                            <i data-feather="user"></i>
                            <span data-key="t-dashboard">Data Mahasiswa</span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript: void(0);" class="has-arrow">
                            <i data-feather="tag"></i>
                            <span data-key="t-apps">Peninjauan Konsultasi</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li>
                                <a href="{{ route('peninjauan-judul.index') }}">
                                    <span data-key="t-email">Judul</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('peninjauan-proposal.index') }}">
                                    <span data-key="t-email">Proposal</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('peninjauan-laporan.index') }}">
                                    <span data-key="t-invoices">Laporan</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('peninjauan-program.index') }}">
                                    <span data-key="t-contacts">Program</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript: void(0);">
                            <i data-feather="monitor"></i>
                            <span data-key="t-dashboard">Persetujuan Jadwal Zoom</span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript: void(0);" class="has-arrow">
                            <i data-feather="bell"></i>
                            <span data-key="t-apps">Informasi</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li>
                                <a href="javascript: void(0);">
                                    <span data-key="t-chat">Pengumuman</span>
                                </a>
                            </li>
                            <li>
                                <a href="javascript: void(0);">
                                    <span data-key="t-chat">Peringatan</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript: void(0);">
                            <i data-feather="menu"></i>
                            <span data-key="t-dashboard">Progress Bimbingan</span>
                        </a>
                    </li>
                @elseif(Auth::check() && Auth::user()->role == 'mahasiswa')
                    <li>
                        <a href="{{ route('ketentuan-ta.index') }}">
                            <i data-feather="bookmark"></i>
                            <span data-key="t-dashboard">Ketentuan TA</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('pengajuan-judul.index') }}">
                            <i data-feather="external-link"></i>
                            <span data-key="t-dashboard">Pengajuan Judul</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('data-pembimbing.indexMhs') }}">
                            <i data-feather="user"></i>
                            <span data-key="t-dashboard">Data Pembimbing</span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript: void(0);" class="has-arrow">
                            <i data-feather="tag"></i>
                            <span data-key="t-apps">Konsultasi</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li>
                                <a href="{{ route('bimbingan-judul.index') }}">
                                    <span data-key="t-email">Judul</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('bimbingan-proposal.index') }}">
                                    <span data-key="t-email">Proposal</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('bimbingan-laporan.index') }}">
                                    <span data-key="t-invoices">Laporan</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('bimbingan-program.index') }}">
                                    <span data-key="t-contacts">Program</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript: void(0);">
                            <i data-feather="monitor"></i>
                            <span data-key="t-dashboard">Pengajuan Jadwal Zoom</span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript: void(0);" class="has-arrow">
                            <i data-feather="bell"></i>
                            <span data-key="t-apps">Informasi</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li>
                                <a href="javascript: void(0);">
                                    <span data-key="t-chat">Pengumuman</span>
                                </a>
                            </li>
                            <li>
                                <a href="javascript: void(0);">
                                    <span data-key="t-chat">Peringatan</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->
