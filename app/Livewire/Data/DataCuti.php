<?php

namespace App\Livewire\Data;

use App\Exports\CutiExport;
use App\Models\Cuti;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class DataCuti extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $perPage = 5;
    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    #[Url()]
    public $search = '';
    public $sampai, $dari;

    public $cuti_id,
        $keperluan_cuti,
        $tanggal_cuti,
        $lama_cuti,
        $sampai_tanggal,
        $durasi,
        $status,
        $status_hrd,
        $keterangan_cuti,
        $pilihan,
        $nama;

    public $mySelected = [];
    public $selectAll = false;
    public $firstId = NULL;
    public $lastId = NULL;

    #[Rule('required|date', as: 'dari tanggal')]
    public $dari_tanggal_download;
    #[Rule('required|date|after:dari_tanggal_download', as: 'sampai tanggal')]
    public $sampai_tanggal_download;
    #[Rule('required|string', as: 'format data')]
    public $format_data;
    #[Rule('required|string')]
    public $nama_file;

    public $data = [];

    public function mount()
    {
        $dataDari = Cuti::orderBy('tanggal_cuti', 'asc')->first();
        $dataSampai = Cuti::orderBy('tanggal_cuti', 'desc')->first();

        if ($dataDari == NULL) {
            $this->dari = Carbon::now()->format('Y-m-d');
            $this->sampai = Carbon::now()->format('Y-m-d');
        } else {
            $this->dari = Carbon::parse($dataDari->tanggal_cuti)->format('Y-m-d');
            $this->sampai = Carbon::parse($dataSampai->tanggal_cuti)->format('Y-m-d');
        }
    }



    public function sortBy($sortField)
    {
        if ($this->sortField === $sortField) {
            $this->sortDirection = $this->swapSortDirection();
        } else {
            $this->sortDirection = 'asc';
        }

        $this->sortField = $sortField;
    }

    public function swapSortDirection()
    {
        return $this->sortDirection === 'asc' ? 'desc' : 'asc';
    }

    // ------------ view -------------
    public function lihatcuti($id)
    {
        $this->cuti_id = $id;

        $data = Cuti::where('id', $this->cuti_id)->first();
        $user = $data->user()->first();

        $this->nama = $user->name;
        $this->keperluan_cuti = $data->keperluan_cuti;
        $this->tanggal_cuti = Carbon::parse($data->tanggal_cuti)->format('Y-m-d');
        $this->sampai_tanggal = Carbon::parse($data->sampai_tanggal)->format('Y-m-d');
        $this->keterangan_cuti = $data->keterangan_cuti;
        $this->lama_cuti = $data->lama_cuti;
        $this->pilihan = $data->pilihan;
        $this->durasi = $data->durasi;
        $this->status = $data->status;
        $this->status_hrd = $data->status_hrd;

        $this->dispatch('show-view-modal');
    }

    public function closeView()
    {
        $this->cuti_id = '';
        $this->keperluan_cuti = '';
        $this->tanggal_cuti = '';
        $this->sampai_tanggal = '';
        $this->keterangan_cuti = '';
        $this->lama_cuti = '';
        $this->pilihan = '';
        $this->status = '';
        $this->status_hrd = '';
    }

    // ------------ approve atasan ------------
    public function approveAtasan($id)
    {
        $this->cuti_id = $id;

        Cuti::where('id', $this->cuti_id)->update([
            'status' => 1,
            'status_hrd' => 0,
        ]);


        $this->cuti_id = '';
        $this->dispatch('approveAtasan', [
            'title' => 'Data Berhasil di approve!',
            'icon' => 'success',
        ]);
    }

    // ------------ reject atasan ------------
    public function rejectAtasan($id)
    {
        $this->cuti_id = $id;

        Cuti::where('id', $this->cuti_id)->update([
            'status' => 2,
            'status_hrd' => NULL,
        ]);


        $this->cuti_id = '';
        $this->dispatch('rejectAtasan', [
            'title' => 'Data Berhasil di reject!',
            'icon' => 'success',
        ]);
    }

    // ------------ reset atasan ------------
    public function resetAtasan($id)
    {
        $this->cuti_id = $id;

        Cuti::where('id', $this->cuti_id)->update([
            'status' => 0,
            'status_hrd' => NULL,
        ]);


        $this->cuti_id = '';
        $this->dispatch('resetAtasan', [
            'title' => 'Data Berhasil di reset!',
            'icon' => 'success',
        ]);
    }

    // ------------ approve HRD ------------
    public function approveHrd($id)
    {
        $this->cuti_id = $id;

        Cuti::where('id', $this->cuti_id)->update([
            'status_hrd' => 1,
        ]);


        $this->cuti_id = '';
        $this->dispatch('approveHrd', [
            'title' => 'Data Berhasil di approve!',
            'icon' => 'success',
        ]);
    }

    // ------------ reject HRD ------------
    public function rejectHrd($id)
    {
        $this->cuti_id = $id;

        Cuti::where('id', $this->cuti_id)->update([
            'status_hrd' => 2,
        ]);


        $this->cuti_id = '';
        $this->dispatch('rejectHrd', [
            'title' => 'Data Berhasil di reject!',
            'icon' => 'success',
        ]);
    }

    // ------------ reset hrd ------------
    public function resetHrd($id)
    {
        $this->cuti_id = $id;

        Cuti::where('id', $this->cuti_id)->update([
            'status' => 1,
            'status_hrd' => 0,
        ]);


        $this->cuti_id = '';
        $this->dispatch('resetHrd', [
            'title' => 'Data Berhasil di reset!',
            'icon' => 'success',
        ]);
    }

    // ----------- download data ---------------
    public function downloadData()
    {
        $this->validate();

        if ($this->format_data == 'PDF') {

            $this->data = Cuti::where('status_hrd', '>', 0)
                ->whereBetween('tanggal_cuti', [$this->dari_tanggal_download, $this->sampai_tanggal_download])
                ->orderBy('tanggal_cuti', 'asc')
                ->get();

            $pdf = Pdf::loadView('livewire.data.pdf.cuti-pdf', [
                'data' => $this->data,
                'str_date' => $this->dari_tanggal_download,
                'n_date' => $this->sampai_tanggal_download,
            ])->output();

            return response()->streamDownload(
                fn () => print($pdf),
                $this->nama_file . ".pdf"
            );
        } elseif ($this->format_data == 'XLS') {
            return (new CutiExport($this->dari_tanggal_download, $this->sampai_tanggal_download))->download($this->nama_file . '.xlsx');
        } elseif ($this->format_data == 'CSV') {
            return (new CutiExport($this->dari_tanggal_download, $this->sampai_tanggal_download))->download($this->nama_file . '.csv');
        }
    }

    // -------- bulk ---------------------------

    public function resetSelected()
    {
        $this->mySelected = [];
        $this->selectAll = false;
    }

    public function updatedMySelected()
    {

        $data = Cuti::select('tb_cuti.*', 'users.name')
            ->where('users.name', 'like', '%' . $this->search . '%')
            ->whereBetween('tb_cuti.tanggal_cuti', [$this->dari, $this->sampai])
            ->join('users', 'users.id', '=', 'tb_cuti.user_id')
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        $dataHrd = Cuti::select('tb_cuti.*', 'users.name')
            ->where('tb_cuti.status', 1)
            ->where('users.name', 'like', '%' . $this->search . '%')
            ->whereBetween('tb_cuti.tanggal_cuti', [$this->dari, $this->sampai])
            ->join('users', 'users.id', '=', 'tb_cuti.user_id')
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        if (Auth::user()->role_id == 4) {
            if (count($this->mySelected) == $data->count()) {
                $this->selectAll = true;
            } else {
                $this->selectAll = false;
            }
        } elseif (Auth::user()->role_id == 3) {
            if (count($this->mySelected) == $dataHrd->count()) {
                $this->selectAll = true;
            } else {
                $this->selectAll = false;
            }
        }
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->mySelected = Cuti::whereBetween('id', [$this->firstId, $this->lastId])->pluck('id');
        } else {
            $this->mySelected = [];
        }
    }

    // -------- bulk HRD---------------------------
    public function approveSelected()
    {
        Cuti::whereIn('id', $this->mySelected)->update([
            'status_hrd' => 1,
        ]);

        $this->mySelected = [];
        $this->selectAll = false;

        $this->dispatch('approveHrd', [
            'title' => 'Data Berhasil di approve!',
            'icon' => 'success',
        ]);
    }

    public function rejectSelected()
    {
        Cuti::whereIn('id', $this->mySelected)->update([
            'status_hrd' => 2,
        ]);

        $this->mySelected = [];
        $this->selectAll = false;

        $this->dispatch('rejectHrd', [
            'title' => 'Data Berhasil di reject!',
            'icon' => 'success',
        ]);
    }

    public function resetDataSelected()
    {
        Cuti::whereIn('id', $this->mySelected)->update([
            'status_hrd' => 0,
        ]);

        $this->mySelected = [];
        $this->selectAll = false;

        $this->dispatch('resetHrd', [
            'title' => 'Data Berhasil di reset!',
            'icon' => 'success',
        ]);
    }

    // --------------- bulk atasan ----------------
    public function approveSelectedAtasan()
    {
        $data = Cuti::whereIn('id', $this->mySelected)->where('status_hrd', '>', 0)->pluck('status_hrd');


        if ($data->count() == 0) {
            Cuti::whereIn('id', $this->mySelected)->update([
                'status' => 1,
                'status_hrd' => 0,
            ]);

            $this->mySelected = [];
            $this->selectAll = false;

            $this->dispatch('approveHrd', [
                'title' => 'Data Berhasil di approve!',
                'icon' => 'success',
            ]);
        } elseif ($data->count() > 0) {
            $this->mySelected = [];
            $this->selectAll = false;

            $this->dispatch('notAllowed', [
                'title' => 'Data tidak bisa diproses!',
                'icon' => 'warning',
            ]);
        }
    }

    public function rejectSelectedAtasan()
    {
        $data = Cuti::whereIn('id', $this->mySelected)->where('status_hrd', '>', 0)->pluck('status_hrd');


        if ($data->count() == 0) {
            Cuti::whereIn('id', $this->mySelected)->update([
                'status' => 2,
                'status_hrd' => NULL,
            ]);

            $this->mySelected = [];
            $this->selectAll = false;

            $this->dispatch('rejectHrd', [
                'title' => 'Data Berhasil di reject!',
                'icon' => 'success',
            ]);
        } elseif ($data->count() > 0) {
            $this->mySelected = [];
            $this->selectAll = false;

            $this->dispatch('notAllowed', [
                'title' => 'Data tidak bisa diproses!',
                'icon' => 'warning',
            ]);
        }
    }

    public function resetDataSelectedAtasan()
    {
        $data = Cuti::whereIn('id', $this->mySelected)->where('status_hrd', '>', 0)->pluck('status_hrd');


        if ($data->count() == 0) {
            Cuti::whereIn('id', $this->mySelected)->update([
                'status' => 0,
                'status_hrd' => NULL,
            ]);

            $this->mySelected = [];
            $this->selectAll = false;

            $this->dispatch('resetHrd', [
                'title' => 'Data Berhasil di reset!',
                'icon' => 'success',
            ]);
        } elseif ($data->count() > 0) {
            $this->mySelected = [];
            $this->selectAll = false;

            $this->dispatch('notAllowed', [
                'title' => 'Data tidak bisa diproses!',
                'icon' => 'warning',
            ]);
        }
    }

    #[Title('Data Cuti')]
    #[Layout('layouts.app')]
    public function render()
    {
        $dataCuti = Cuti::select('tb_cuti.*', 'users.name')
            ->where('users.name', 'like', '%' . $this->search . '%')
            ->whereBetween('tb_cuti.tanggal_cuti', [$this->dari, $this->sampai])
            ->join('users', 'users.id', '=', 'tb_cuti.user_id')
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        $dataCutiHrd = Cuti::select('tb_cuti.*', 'users.name')
            ->where('tb_cuti.status', 1)
            ->where('users.name', 'like', '%' . $this->search . '%')
            ->whereBetween('tb_cuti.tanggal_cuti', [$this->dari, $this->sampai])
            ->join('users', 'users.id', '=', 'tb_cuti.user_id')
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);


        if (Auth::user()->role_id == 3) {
            $data = $dataCutiHrd->count();
            if ($data > 0) {
                $this->firstId = $dataCutiHrd[$data - 1]->id;
                $this->lastId = $dataCutiHrd[0]->id;
            }
        } elseif (Auth::user()->role_id == 4) {
            $data = $dataCuti->count();
            if ($data > 0) {
                $this->firstId = $dataCuti[$data - 1]->id;
                $this->lastId = $dataCuti[0]->id;
            }
        }

        return view('livewire.data.data-cuti', [
            'dataCuti' => $dataCuti,
            'countAtasan' => Cuti::where('status', 0)->count(),

            'dataCutiHrd' => $dataCutiHrd,
            'countHrd' => Cuti::where('status_hrd', 0)->count(),
        ]);
    }
}
