@extends('layouts.minia.header')

@section('content')
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Konsultasi Judul</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard.home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Konsultasi Judul</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <!-- Info -->
        <div class="row">
            <div class="col-12">
                <div class="card bg-transparent border-warning">
                    <div class="card-header bg-transparent border-warning">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <h4 class="card-title text-warning"><i class="fas fa-exclamation-triangle"></i> |
                                    Informasi</h4>
                            </div>
                            <div class="col-md-6 d-flex justify-content-end">
                                <a class="d-block text-warning btn-lg"
                                    style="border-radius: 50%; background-color: #ebede3;" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false"
                                    aria-controls="collapseExample">
                                    <i class="min fas fa-angle-double-down pull-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="collapse show" id="collapseExample">
                        <div class="card-body" style="text-align: justify">
                            <p>
                                Anda <b>tidak bisa mengakses halaman ini dikarenakan belum mendapatkan Dosen Pembimbing.</b>
                                Segera ajukan judul Tugas Akhir untuk mendapatkan Dosen Pembimbing. Ajukan pada menu <u><a
                                        href="{{ route('pengajuan-judul.index') }}">Pengajuan Judul</a></u>.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
@endsection

@section('js')
@endsection
