<!DOCTYPE html>
<html>

<head>
    <title>Membuat Laporan PDF Dengan DOMPDF Laravel</title>
    <!-- Bootstrap Css -->
    <link href="{{ asset('assets/css') }}/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
</head>

<body>
    <style type="text/css">
        /**
            Set the margins of the page to 0, so the footer and the header
            can be of the full height and width !
        **/
        @page {
            margin: 0cm 0cm;
        }

        /** Define now the real margins of every page in the PDF **/
        body {
            margin-top: 8.2cm;
            margin-left: 1.5cm;
            margin-right: 1.5cm;
            margin-bottom: 7.5cm;
            font-family: 'Times New Roman', Times, serif;
            color: black;
            font-size: 10pt;
        }

        /** Define the header rules **/
        header {
            position: fixed;
            top: 2cm;
            left: 1.5cm;
            right: 1.5cm;
        }

        /** Define the footer rules **/
        footer {
            position: fixed;
            bottom: 2cm;
            left: 1.5cm;
            right: 1.5cm;
        }

        table {
            font-family: 'Times New Roman', Times, serif;
            color: black;
            border-color: black;
        }

        table.table-bordered {
            border: 1px solid black;
            padding: 3px;
            margin: 1px;
        }

        table.table-bordered>thead>tr>th {
            border: 1px solid black;
            padding: 3px;
            margin: 1px;
        }

        table.table-bordered>tbody>tr>td {
            border: 1px solid black;
            padding: 3px;
            margin: 1px;
        }

        hr {
            margin: 0 0 15px 0;
            border-width: 0;
        }

        input[type=checkbox] {
            /* Double-sized Checkboxes */
            -ms-transform: scale(2);
            /* IE */
            -moz-transform: scale(2);
            /* FF */
            -webkit-transform: scale(2);
            /* Safari and Chrome */
            -o-transform: scale(2);
            padding-top: 3px;
        }
    </style>

    <header>
        <table class="table table-borderless">
            <tr>
                <th style="width: 20%; text-align: center; vertical-align: middle;">
                    <img src="{{ asset('assets/img') }}/polinema.png" width="120px" height="120px">
                </th>
                <th style="width: 70%; text-align: center; vertical-align: middle;">
                    <p>
                        <b style="font-size: 9pt;">
                            KEMENTERIAN PENDIDIKAN, KEBUDAYAAN<br>
                            RISET DAN TEKNOLOGI
                        </b> <br>
                        <b style="font-weight: 900">
                            POLITEKNIK NEGERI MALANG <br>
                            PSDKU POLITEKNIK NEGERI MALANG DI KOTA KEDIRI<br>
                            PROGRAM STUDI D-III MANAJEMEN INFORMATIKA
                        </b> <br>
                        <b style="font-size: 7pt; font-weight: 100">
                            Kampus 1: Jl. Mayor Bismo No. 27 Kota Kediri <br>
                            Kampus 2: Jl. Lingkar Maskumambang Kota Kediri <br>
                            Telp. (0354) 683128 – Fax. (0354) 683128 <br>
                            Website: www.polinema.ac.id – E-mail: info@polinema.ac.id <br>
                        </b>
                    </p>
                </th>
                <th style="width: 20%; text-align: center; vertical-align: middle;">
                    <img src="{{ asset('assets/img') }}/iso.jpg" width="120px" height="120px">
                </th>
            </tr>
        </table>

        <hr style="height: 2px; border-top: 1px solid black; border-bottom: 3px solid black;">

    </header>

    <main>
        <center>
            <p style="font-size: 14pt; font-weight: 900">
                KARTU BIMBINGAN TUGAS MAHASISWA <br> MANAJEMEN INFORMATIKA <br>
                TAHUN {{ $user->mahasiswa->tahun->tahun_ajaran }}
            </p>
        </center>

        <table class="table" style="font-size: 10pt; padding: 3px; margin: 1px;">
            <tr style="background-color:#e8ebe9;">
                <th style="width: 20%; vertical-align: middle; border: 1px solid black;">
                    JENIS TUGAS
                </th>
                <th colspan="2" style="width: 40%; vertical-align: middle; border: 1px solid black;">
                    <input type="checkbox"> &nbsp; PKL
                </th>
                <th colspan="2"style="width: 40%; vertical-align: middle; border: 1px solid black;">
                    <input type="checkbox"> &nbsp; LAPORAN AKHIR
                </th>
            </tr>
            <tr>
                <th rowspan="2"
                    style="width: 20%; vertical-align: middle; border: 1px solid black; background-color:#e8ebe9;">
                    PEMBIMBING
                </th>
                <th style="width: 15%; vertical-align: middle; border: 1px solid black; background-color:#e8ebe9;">
                    DOSEN 1
                </th>
                <td colspan="3" style="width: 60%; vertical-align: middle; border: 1px solid black;">
                    {{ $user->mahasiswa->dospem->dosen->nama_dosen }}
                </td>
            </tr>
            <tr>
                <th style="width: 15%; vertical-align: middle; border: 1px solid black; background-color:#e8ebe9;">
                    DOSEN 2
                </th>
                <td colspan="3" style="width: 60%; vertical-align: middle; border: 1px solid black;"></td>
            </tr>
            <tr>
                <th rowspan="2"
                    style="width: 20%; vertical-align: middle; border: 1px solid black; background-color:#e8ebe9;">
                    MAHASISWA
                </th>
                <td colspan="4" style="width: 60%; vertical-align: middle; border: 1px solid black;">
                    {{ $user->mahasiswa->nama_mahasiswa }}
                </td>
            </tr>
            <tr>
                <td colspan="4" style="width: 60%; vertical-align: middle; border: 1px solid black;">
                    NIM: {{ $user->mahasiswa->nim }}
                </td>
            </tr>
            <tr>
                <th style="width: 20%; vertical-align: middle; border: 1px solid black; background-color:#e8ebe9;">
                    JUDUL TUGAS
                </th>
                <td colspan="4" style="width: 60%; vertical-align: middle; border: 1px solid black;">
                    {{ $user->mahasiswa->judul->judul }}
                </td>
            </tr>
        </table>
        <table class="table table-bordered" style="font-size: 9pt; padding-top: 5px;">
            <thead
                style="text-align: center; font-size: 9pt; font-weight: 900; border-color: black; background-color:#e8ebe9">
                <tr>
                    <th style="width: 3%; vertical-align: middle">NO</th>
                    <th style="width: 20%; vertical-align: middle">TANGGAL</th>
                    <th style="width: 40%; vertical-align: middle">MATERI/BAB</th>
                    <th style="width: 40%; vertical-align: middle">SARAN DOSEN</th>
                    <th style="width: 25%; vertical-align: middle">TTD DOSEN</th>
                </tr>
            </thead>
            <tbody>
                @php $i = 1 @endphp
                @foreach ($riwayat as $item)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>
                            {{ \Carbon\Carbon::parse($item->waktu_bimbingan)->isoFormat('D MMMM Y') }}
                        </td>
                        <td>{{ $item->keterangan }}</td>
                        <td>{{ $item->tanggapan }}</td>
                        <td></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </main>

</body>

</html>
