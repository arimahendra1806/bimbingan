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
        }

        table.table-bordered>thead>tr>th {
            border: 1px solid black;
        }

        table.table-bordered>tbody>tr>td {
            border: 1px solid black;
        }

        hr {
            margin: 0 0 15px 0;
            border-width: 0;
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

    <footer>
        <div style="margin-bottom: 50px; margin-left:70%">
            <p>
                Kediri, {{ $hari }} <br>
                Dosen Pembimbing Praproposal, <br><br><br><br>
                {{ $user->mahasiswa->dospem->dosen->nama_dosen }} <br>
                NIDN. {{ $user->mahasiswa->dospem->dosen->nidn }}
            </p>
        </div>

        <div>
            <p>Catatan: Tanda Tangan harus jelas dan basah</p>
        </div>
    </footer>

    <main>
        <center>
            <p style="font-size: 14pt; font-weight: 900">LEMBAR BIMBINGAN PROPOSAL LAPORAN AKHIR
                {{ $user->mahasiswa->tahun->tahun_ajaran }}</p>
        </center>

        <table class="table table-borderless">
            <tr>
                <th style="font-size: 12pt; font-weight: 900; width: 10%">JUDUL</th>
                <th style="font-size: 12pt; font-weight: 900; width: 2%">:</th>
                <th colspan="4" style="font-size: 11pt; font-weight: 100; text-align: justify;">
                    {{ $user->mahasiswa->judul->judul }}
                </th>
            </tr>
            <tr>
                <th style="font-size: 12pt; font-weight: 900; width: 10%">NAMA</th>
                <th style="font-size: 12pt; font-weight: 900; width: 2%">:</th>
                <th style="font-size: 11pt; font-weight: 100; text-align: justify; width: 50%">
                    {{ $user->mahasiswa->nama_mahasiswa }}
                </th>
                <th style="font-size: 12pt; font-weight: 900; width: 10%">NIM</th>
                <th style="font-size: 12pt; font-weight: 900; width: 2%">:</th>
                <th style="font-size: 11pt; font-weight: 100; text-align: justify;">
                    {{ $user->mahasiswa->nim }}
                </th>
            </tr>
        </table>
        <table class=" table table-bordered" style="font-size: 9pt;">
            <thead style=" text-align: center; font-size: 12pt; font-weight: 900; border-color: black">
                <tr>
                    <th rowspan="2" style="width: 3%; vertical-align: middle">No</th>
                    <th rowspan="2" style="width: 20%; vertical-align: middle">Tanggal / Waktu</th>
                    <th rowspan="2" style="width: 30%; vertical-align: middle">Materi Bimbingan</th>
                    <th colspan="2">Tanda Tangan</th>
                </tr>
                <tr>
                    <th style="width: 20%">Mahasiswa</th>
                    <th style="width: 22%">Dosen</th>
                </tr>
            </thead>
            <tbody>
                @php $i = 1 @endphp
                @foreach ($riwayat as $item)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>
                            {{ \Carbon\Carbon::parse($item->waktu_bimbingan)->isoFormat('D MMMM Y / hh:mm:ss') }}
                        </td>
                        <td>Konsultasi pengerjaan {{ strtolower($item->bimbingan_jenis) }}</td>
                        <td></td>
                        <td></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </main>

</body>

</html>
