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
                            <i data-feather="bell"></i>
                            <span data-key="t-apps">Kelola Informasi</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li>
                                <a href="{{ route('kelola-pengumuman.index') }}">
                                    <span data-key="t-chat">Pengumuman</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('kelola-peringatan.index') }}">
                                    <span data-key="t-chat">Peringatan</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript: void(0);" class="has-arrow">
                            <i data-feather="calendar"></i>
                            <span data-key="t-apps">Kelola Tahunan</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li>
                                <a href="{{ route('kelola-tahun-ajaran.index') }}">
                                    <span data-key="t-chat">Tahun Ajaran</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('kelola-materi-tahunan.index') }}">
                                    <span data-key="t-chat">Materi Tahunan</span>
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
                                <a href="{{ route('kelola-admin-prodi.index') }}">
                                    <span data-key="t-chat">Data Admin Prodi</span>
                                </a>
                            </li>
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
                                <a href="{{ route('kelola-dosen-pembimbing.index') }}">
                                    <span data-key="t-chat">Data Dosen Pembimbing</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('kelola-pengguna.index') }}">
                                    <span data-key="t-user-list">Pengguna Aplikasi</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="{{ route('kelola-link-zoom.index') }}">
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
                        <a href="{{ route('progres-konsultasi.index') }}">
                            <i data-feather="menu"></i>
                            <span data-key="t-dashboard">Progres Konsultasi</span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript: void(0);" class="has-arrow">
                            <i data-feather="hard-drive"></i>
                            <span data-key="t-apps">Daftar Pengumpulan</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li>
                                <a href="{{ route('daftar-proposal.daftarPro') }}">
                                    <span data-key="t-chat">Pengumpulan Proposal</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('daftar-laporan.daftarLap') }}">
                                    <span data-key="t-chat">Pengumpulan Laporan</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @elseif(Auth::check() && Auth::user()->role == 'kaprodi')
                    <li>
                        <a href="javascript: void(0);" class="has-arrow">
                            <i data-feather="bell"></i>
                            <span data-key="t-apps">Kelola Informasi</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li>
                                <a href="{{ route('kelola-pengumuman.index') }}">
                                    <span data-key="t-chat">Pengumuman</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('kelola-peringatan.index') }}">
                                    <span data-key="t-chat">Peringatan</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript: void(0);" class="has-arrow">
                            <i data-feather="file-text"></i>
                            <span data-key="t-apps">Data Pengguna</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li>
                                <a href="{{ route('data-admin.indexKaprodi') }}">
                                    <span data-key="t-chat">Data Admin Prodi</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('data-dosen.indexKaprodi') }}">
                                    <span data-key="t-chat">Data Dosen</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('data-mhs.indexKaprodi') }}">
                                    <span data-key="t-chat">Data Mahasiswa</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="{{ route('data-dospem.indexKaprodi') }}">
                            <i data-feather="users"></i>
                            <span data-key="t-dashboard">Data Pembimbing</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('progres-konsultasi.index') }}">
                            <i data-feather="menu"></i>
                            <span data-key="t-dashboard">Progres Konsultasi</span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript: void(0);" class="has-arrow">
                            <i data-feather="hard-drive"></i>
                            <span data-key="t-apps">Daftar Pengumpulan</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li>
                                <a href="{{ route('daftar-proposal.daftarPro') }}">
                                    <span data-key="t-chat">Pengumpulan Proposal</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('daftar-laporan.daftarLap') }}">
                                    <span data-key="t-chat">Pengumpulan Laporan</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @elseif(Auth::check() && Auth::user()->role == 'dosen')
                    <li>
                        <a href="javascript: void(0);" class="has-arrow">
                            <i data-feather="bell"></i>
                            <span data-key="t-apps">Informasi</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li>
                                <a href="{{ route('kelola-pengumuman.index') }}">
                                    <span data-key="t-chat">Pengumuman</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('kelola-peringatan.index') }}">
                                    <span data-key="t-chat">Peringatan</span>
                                </a>
                            </li>
                        </ul>
                    </li>
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
                        <a href="{{ route('peninjauan-jadwal-zoom.indexDsn') }}">
                            <i data-feather="monitor"></i>
                            <span data-key="t-dashboard">Peninjauan Jadwal Zoom</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('progres-konsultasi.index') }}">
                            <i data-feather="menu"></i>
                            <span data-key="t-dashboard">Progres Konsultasi</span>
                        </a>
                    </li>
                @elseif(Auth::check() && Auth::user()->role == 'mahasiswa')
                    <li>
                        <a href="javascript: void(0);" class="has-arrow">
                            <i data-feather="bell"></i>
                            <span data-key="t-apps">Informasi</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li>
                                <a href="{{ route('pengumuman.indexMhs') }}">
                                    <span data-key="t-chat">Pengumuman</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('peringatan.indexMhs') }}">
                                    <span data-key="t-chat">Peringatan</span>
                                </a>
                            </li>
                        </ul>
                    </li>
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
                        <a href="{{ route('pengajuan-zoom.index') }}">
                            <i data-feather="monitor"></i>
                            <span data-key="t-dashboard">Pengajuan Jadwal Zoom</span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript: void(0);" class="has-arrow">
                            <i data-feather="archive"></i>
                            <span data-key="t-apps">Verifikasi Pengumpulan</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li>
                                <a href="{{ route('pengumpulan-proposal.indexPro') }}">
                                    <span data-key="t-chat">Pengumpulan Proposal</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('pengumpulan-laporan.indexLap') }}">
                                    <span data-key="t-chat">Pengumpulan Laporan</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @elseif(Auth::check() && Auth::user()->role == 'admin')
                    <li>
                        <a href="javascript: void(0);" class="has-arrow">
                            <i data-feather="bell"></i>
                            <span data-key="t-apps">Informasi</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li>
                                <a href="{{ route('kelola-pengumuman.index') }}">
                                    <span data-key="t-chat">Pengumuman</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('kelola-peringatan.index') }}">
                                    <span data-key="t-chat">Peringatan</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript: void(0);" class="has-arrow">
                            <i data-feather="check-square"></i>
                            <span data-key="t-apps">Verifikasi Pengumpulan</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li>
                                <a href="{{ route('pengumpulan-proposal.indexAdmPro') }}">
                                    <span data-key="t-chat">Verifikasi Proposal</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('pengumpulan-laporan.indexAdmLap') }}">
                                    <span data-key="t-chat">Verifikasi Laporan</span>
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
