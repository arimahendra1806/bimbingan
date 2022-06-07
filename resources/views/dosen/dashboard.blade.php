@section('content')
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Dashboard</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
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
                        <h4 class="card-title">Selamat Datang {{ Auth::user()->name }}</h4>
                        <p class="card-title-desc">Status Anda adalah Dosen Pembimbing, silahkan gunakan aplikasi SITAMI
                            sesuai kebutuhan!
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Pie -->
        @include('partial.chartPie')

        <!-- Card Column -->
        @include('partial.chartColumn')

        <!-- Card Line -->
        @include('partial.chartLine')
    </div>
@endsection

@section('js')
    <script src="{{ asset('vendor/minia') }}/assets/libs/apexcharts/apexcharts.min.js"></script>
    @yield('chartPieJs')
    @yield('chartColumnJs')
    @yield('chartLineJs')
@endsection
