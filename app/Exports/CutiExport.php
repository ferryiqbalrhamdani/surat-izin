<?php

namespace App\Exports;

use App\Models\Cuti;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;

class CutiExport implements FromQuery, WithMapping, WithHeadings, WithStyles, WithColumnFormatting
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
        return Cuti::query()->where('status_hrd', '>', 0)
            ->orderBy('tanggal_cuti', 'asc')
            ->whereDate('tanggal_cuti', '>=', $this->start)
            ->whereDate('tanggal_cuti', '<=', $this->end);
    }


    public function map($cuti): array
    {
        return [
            $cuti->user()->first()->name,
            $cuti->keperluan_cuti,
            $cuti->pilihan,
            Carbon::parse($cuti->tanggal_cuti)->isoFormat('D MMMM Y'),
            Carbon::parse($cuti->sampai_tanggal)->isoFormat('D MMMM Y'),
            $cuti->durasi,
            $cuti->keterangan_cuti,
            $cuti->status_hrd,
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
            'D' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'E' => NumberFormat::FORMAT_DATE_DDMMYYYY,
        ];
    }



    public function headings(): array
    {
        return ["Nama", "Keperluan Cuti", "Pilihan", "Tanggal Cuti", "Sampai Tanggal", "Lama Cuti", "Keterangan Izin", "Status"];
    }
}
