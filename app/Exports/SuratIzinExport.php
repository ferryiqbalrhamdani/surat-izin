<?php

namespace App\Exports;

use App\Models\SuratIzin;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;

class SuratIzinExport implements FromQuery, WithMapping, WithHeadings, WithStyles, WithColumnFormatting
{
    /**
     * @return \Illuminate\Support\Collection
     */


    use Exportable;

    public function __construct($start, $end)
    {
        $this->start = $start;
        $this->end = $end;
    }

    public function query()
    {
        return SuratIzin::query()->where('status_hrd', '>', 0)
            ->orderBy('tb_izin.tanggal_izin', 'asc')
            ->whereDate('tb_izin.tanggal_izin', '>=', $this->start)
            ->whereDate('tb_izin.tanggal_izin', '<=', $this->end);
    }


    public function map($suratIzin): array
    {
        return [
            $suratIzin->user()->first()->name,
            $suratIzin->keperluan_izin,
            Carbon::parse($suratIzin->tanggal_izin)->isoFormat('D MMMM Y'),
            Carbon::parse($suratIzin->sampai_tanggal)->isoFormat('D MMMM Y'),
            $suratIzin->durasi_izin,
            $suratIzin->jam_masuk,
            $suratIzin->jam_keluar,
            $suratIzin->keterangan_izin,
            $suratIzin->status_hrd,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],


        ];
    }

    public function columnFormats(): array
    {
        return [
            'C' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'D' => NumberFormat::FORMAT_DATE_DDMMYYYY,
        ];
    }



    public function headings(): array
    {
        return ["Nama", "Keperluan Izin", "Tanggal Izin", "Sampai Tanggal", "Lama Izin", "Jam Mulai", "Jam Selesai", "Keterangan Izin", "Status"];
    }
}
