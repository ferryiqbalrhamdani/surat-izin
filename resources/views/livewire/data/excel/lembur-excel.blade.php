<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Surat Izin - PDF</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
             !important
        }


        .text-center {
            text-align: center;
        }

        #customers {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        #customers td,
        #customers th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        #customers tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #customers th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #212529;
            color: white;
        }
    </style>
</head>

<body>
    <table>
        <thead>
            <tr>
                <td style="text-align: center" colspan="10"><b>IZIN LEMBUR</b></td>
            </tr>
        </thead>
    </table>
    <table>
        <thead>
            <tr>
                <td colspan="10" style="border: none; font-size: 12px; text-align: right">Tanggal: {{
                    Carbon\Carbon::parse($str_date)->translatedFormat('d-m-Y')}} s/d {{
                    Carbon\Carbon::parse($n_date)->translatedFormat('d-m-Y')}}
                </td>
            </tr>
        </thead>
    </table>

    <table id="customers" style="font-size: 12px; margin-bottom: 30px">
        <thead>
            <tr>
                <th style="text-align: center; color: white; background-color: #212529; border: 0 1px solid #ffffff">No
                </th>
                <th style="text-align: center; color: white; background-color: #212529; border: 1px solid #ffffff">Nama
                </th>
                <th style="text-align: center; color: white; background-color: #212529; border: 1px solid #ffffff">
                    Tanggal
                </th>
                <th style="text-align: center; color: white; background-color: #212529; border: 1px solid #ffffff">Dari
                    Jam</th>
                <th style="text-align: center; color: white; background-color: #212529; border: 1px solid #ffffff">
                    Sampai
                    Jam</th>
                <th style="text-align: center; color: white; background-color: #212529; border: 1px solid #ffffff">Lama
                    Lembur</th>
                <th style="text-align: center; color: white; background-color: #212529; border: 1px solid #ffffff">
                    Keterangan</th>
                <th style="text-align: center; color: white; background-color: #212529; border: 1px solid #ffffff">Uang
                    Makan</th>
                <th style="text-align: center; color: white; background-color: #212529; border: 1px solid #ffffff">Upah
                    Lembur Perjam</th>
                <th style="text-align: center; color: white; background-color: #212529; border: 1px 0 solid #ffffff">
                    Total
                    Lembur</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $s)
            <tr>
                <td style="border: 1px solid #000000; @if($s->status_hrd == 2) color: red; @endif">
                    {{$loop->iteration }}
                </td>
                <td style="border: 1px solid #000000; @if($s->status_hrd == 2) color: red; @endif">
                    {{$s->user()->first()->name}}
                </td>
                {{-- <td>{{ date('l', strtotime($s->tanggal_izin))}}</td> --}}
                <td style="border: 1px solid #000000; @if($s->status_hrd == 2) color: red; @endif">{{
                    Carbon\Carbon::parse($s->tanggal_lembur)->translatedFormat('d/m/Y')}}</td>
                <td style="border: 1px solid #000000; @if($s->status_hrd == 2) color: red; @endif">{{
                    Carbon\Carbon::parse($s->jam_mulai)->translatedFormat('H:i')}}
                </td>
                <td style="border: 1px solid #000000; @if($s->status_hrd == 2) color: red; @endif">{{
                    Carbon\Carbon::parse($s->jam_akhir)->translatedFormat('H:i')}}
                </td>
                <td style="border: 1px solid #000000; @if($s->status_hrd == 2) color: red; @endif">{{
                    Carbon\Carbon::parse($s->lama_lembur)->translatedFormat('G')}}
                    jam</td>
                <td style="border: 1px solid #000000; @if($s->status_hrd == 2) color: red; @endif">
                    {{$s->keterangan_lembur}}</td>
                <td style="border: 1px solid #000000; @if($s->status_hrd == 2) color: red; @endif">
                    @if($s->uang_makan != NULL)
                    Rp {{ number_format($s->uang_makan,0,',','.') }}
                    @else
                    -
                    @endif
                </td>
                <td style="border: 1px solid #000000; @if($s->status_hrd == 2) color: red; @endif">
                    @if($s->upah_lembur_perjam != NULL)
                    Rp {{ number_format($s->upah_lembur_perjam,0,',','.') }}
                    @else
                    -
                    @endif
                </td>
                <td style="border: 1px solid #000000; @if($s->status_hrd == 2) color: red; @endif">Rp {{
                    number_format($s->upah_lembur,0,',','.') }}</td>

            </tr>
            @endforeach
        </tbody>
        <thead>
            <tr>
                <td colspan="8" style="border: none"></td>
                <td style="background-color: #f2f2f2; border: 1px solid #000000;">Total Keseluruhan</td>
                <td colspan="1" style="background-color: #f2f2f2; border: 1px solid #000000;">Rp
                    {{number_format($data->sum('upah_lembur'),
                    0,',','.')}} (+)
                </td>
            </tr>
        </thead>
        <thead>
            <tr style="font: red">
                <td colspan=" 8" style="border: none">
                </td>
                <td style="color: red; background-color: #ffffff; border: 1px solid #000000;">Total Reject</td>
                <td colspan="1" style="color: red; background-color: #ffffff; border: 1px solid #000000;">Rp
                    {{number_format($data->where('status_hrd',
                    2)->sum('upah_lembur'), 0,',','.')}}
                    @if($data->where('status_hrd', 2)->sum('upah_lembur') != 0)(-)@endif
                </td>
            </tr>
        </thead>
        <thead>
            <tr>
                <td colspan="8" style="border: none"></td>
                <th style="color: white; background-color: #212529; border: 1px solid #ddd;">Total Approve</th>
                <td colspan="1" style="background-color: #f2f2f2; border: 1px solid #000000;">Rp
                    {{number_format($data->where('status_hrd',
                    1)->sum('upah_lembur'), 0,',','.')}}
                </td>
            </tr>
        </thead>
    </table>
    <table>
        <thead>
            <tr>
                <td colspan="10" style="border: none; font-size: 12px">
                    <p><span style="margin-right: 37px">Catatan</span> : Jika terdapat warna merah, artinya tidak
                        disetujui </p>
                </td>
            </tr>
        </thead>
        <thead>
            <tr>
                <td colspan="10" style="border: none; font-size: 12px">
                    <p><span style="margin-right: 53px">Data</span> : Total data {{$data->count()}}, jumlah data approve
                        {{$data->where('status_hrd', 1)->count()}}, jumlah data reject {{$data->where('status_hrd',
                        2)->count()}}
                    </p>
                </td>
            </tr>
        </thead>
        <thead>
            <tr>
                <td colspan="10" style="border: none; font-size: 12px">
                    <p><span style="margin-right: 15px; margin-top: -10px">Didownload</span> : {{
                        Carbon\Carbon::now()->translatedFormat('d-m-Y, H:i')
                        }}</p>
                </td>
            </tr>
        </thead>
    </table>
</body>

</html>