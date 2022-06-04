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

        <!-- Card Jadwal Zoom -->
        {{-- @isset($no_kp) --}}
        {{-- @include('partial.jadwalZoom') --}}
        {{-- @endisset --}}


        <h1>Mhs</h1>
        <a href="/logout">KELUAR</a>
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
        });
    </script>
    {{-- @isset($no_kp) --}}
    {{-- @yield('JadwalZoomJs') --}}
    {{-- @endisset --}}
@endsection
