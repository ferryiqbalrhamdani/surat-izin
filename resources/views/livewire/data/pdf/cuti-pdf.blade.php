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
    <h2 class="text-center">IZIN CUTI</h2>
    <hr>
    <p style="font-size: 12px; text-align: right">Tanggal: {{
        Carbon\Carbon::parse($str_date)->translatedFormat('d-m-Y')}} s/d {{
        Carbon\Carbon::parse($n_date)->translatedFormat('d-m-Y')}}</p>
    <table id="customers" style="font-size: 12px; margin-bottom: 30px">
        <thead>
            <tr>
                <th style="text-align: center">No</th>
                <th style="text-align: center">Nama</th>
                <th style="text-align: center">Keperluan Cuti</th>
                <th style="text-align: center">Pilihan</th>
                <th style="text-align: center">Dari Tanggal</th>
                <th style="text-align: center">Sampai Tanggal</th>
                <th style="text-align: center">Lama Cuti</th>
                <th style="text-align: center">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $s)
            <tr @if($s->status_hrd == 2) style="color: red" @endif>
                <td>
                    {{$loop->iteration }}
                </td>
                <td>
                    {{$s->user()->first()->name}}
                </td>
                <td>{{$s->keperluan_cuti}}</td>
                <td>
                    @if($s->pilihan != NULL)
                    {{$s->pilihan}}
                    @else
                    -
                    @endif
                </td>
                {{-- <td>{{ date('l', strtotime($s->tanggal_izin))}}</td> --}}
                <td>{{ Carbon\Carbon::parse($s->tanggal_cuti)->translatedFormat('d/m/Y')}}</td>
                <td>{{ Carbon\Carbon::parse($s->sampai_tanggal)->translatedFormat('d/m/Y')}}</td>
                <td>{{ $s->durasi }}</td>
                <td>{{$s->keterangan_cuti}}</td>

            </tr>
            @endforeach
        </tbody>
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