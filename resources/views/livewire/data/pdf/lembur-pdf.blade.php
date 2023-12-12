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
    <h2 class="text-center">IZIN LEMBUR</h2>
    <hr>
    <p style="font-size: 12px; text-align: right">Tanggal: {{
        Carbon\Carbon::parse($str_date)->translatedFormat('d-m-Y')}} s/d {{
        Carbon\Carbon::parse($n_date)->translatedFormat('d-m-Y')}}</p>
    <table id="customers" style="font-size: 12px; margin-bottom: 30px">
        <thead>
            <tr>
                <th style="text-align: center">No</th>
                <th style="text-align: center">Nama</th>
                <th style="text-align: center">Tanggal</th>
                <th style="text-align: center">Dari Jam</th>
                <th style="text-align: center">Sampai Jam</th>
                <th style="text-align: center">Lama Lembur</th>
                <th style="text-align: center">Keterangan</th>
                <th style="text-align: center">Uang Makan</th>
                <th style="text-align: center">Upah Lembur Perjam</th>
                <th style="text-align: center">Total Lembur</th>
            </tr>
        </thead>
        <tbody>
            @if ($data->count() == 0)
            <tr>
                <td colspan="9" class="text-center">Tidak ada data.</td>
            </tr>
            @else
            @foreach ($data as $s)
            <tr @if($s->status_hrd == 2) style="color: red" @endif>
                <td>
                    {{$loop->iteration }}
                </td>
                <td>
                    {{$s->user()->first()->name}}
                </td>
                {{-- <td>{{ date('l', strtotime($s->tanggal_izin))}}</td> --}}
                <td>{{ Carbon\Carbon::parse($s->tanggal_lembur)->translatedFormat('d/m/Y')}}</td>
                <td>{{ Carbon\Carbon::parse($s->jam_mulai)->translatedFormat('H:i')}}</td>
                <td>{{ Carbon\Carbon::parse($s->jam_akhir)->translatedFormat('H:i')}}</td>
                <td>{{ Carbon\Carbon::parse($s->lama_lembur)->translatedFormat('G')}} jam</td>
                <td>{{$s->keterangan_lembur}}</td>
                <td>
                    @if($s->uang_makan != NULL)
                    Rp {{ number_format($s->uang_makan,0,',','.') }}
                    @else
                    -
                    @endif
                </td>
                <td>
                    @if($s->upah_lembur_perjam != NULL)
                    Rp {{ number_format($s->upah_lembur_perjam,0,',','.') }}
                    @else
                    -
                    @endif
                </td>
                <td>Rp {{ number_format($s->upah_lembur,0,',','.') }}</td>

            </tr>
            @endforeach
            @endif
        </tbody>
        <thead>
            <tr>
                <td colspan="8" style="border: none"></td>
                <td style="background-color: #f2f2f2;">Total Keseluruhan</td>
                <td colspan="1" style="background-color: #f2f2f2;">Rp {{number_format($data->sum('upah_lembur'),
                    0,',','.')}} (+)
                </td>
            </tr>
        </thead>
        <thead>
            <tr style="color: red">
                <td colspan=" 8" style="border: none">
                </td>
                <td>Total Reject</td>
                <td colspan="1">Rp {{number_format($data->where('status_hrd',
                    2)->sum('upah_lembur'), 0,',','.')}}
                    @if($data->where('status_hrd', 2)->sum('upah_lembur') != 0)(-)@endif
                </td>
            </tr>
        </thead>
        <thead>
            <tr>
                <td colspan="8" style="border: none"></td>
                <th>Total Approve</th>
                <td colspan="1" style="background-color: #f2f2f2;">Rp {{number_format($data->where('status_hrd',
                    1)->sum('upah_lembur'), 0,',','.')}}
                </td>
            </tr>
        </thead>
    </table>
    <div style="font-size: 12px; margin-top: -20px">
        <p><span style="margin-right: 37px">Catatan</span> : Jika terdapat warna<span style="color: red"> merah</span>,
            artinya tidak disetujui </p>
        <p><span style="margin-right: 53px">Data</span> : Total data {{$data->count()}}, jumlah data approve
            {{$data->where('status_hrd', 1)->count()}}, jumlah data reject {{$data->where('status_hrd', 2)->count()}}
        </p>
        <p><span style="margin-right: 15px; margin-top: -10px">Didownload</span> : {{
            Carbon\Carbon::now()->translatedFormat('d-m-Y, H:i')
            }}</p>
    </div>
</body>

</html>