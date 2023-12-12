<?php

namespace App\Exports;

use App\Models\Lembur;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class LemburExport implements FromView
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

    public function view(): View
    {
        $data = Lembur::query()->where('status_hrd', '>', 0)
            ->orderBy('tanggal_lembur', 'asc')
            ->whereDate('tanggal_lembur', '>=', $this->start)
            ->whereDate('tanggal_lembur', '<=', $this->end)
            ->get();

        return view('livewire.data.excel.lembur-excel', [
            'data' => $data,
            'str_date' => $this->start,
            'n_date' => $this->end,
        ]);
    }
}
