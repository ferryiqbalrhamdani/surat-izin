<?php

namespace App\Livewire\Data;

use App\Exports\LemburExport;
use App\Models\Lembur;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class DataLembur extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $perPage = 5;
    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    #[Url()]
    public $search = '';

    public $dari, $sampai;
    public $lembur_id,
        $upah_lembur_perjam,
        $uang_makan,
        $upah_lembur,
        $tanggal_lembur,
        $keterangan,
        $nama,
        $status,
        $status_hrd,
        $lama_lembur,
        $jam_selesai,
        $hari_libur,
        $jam_mulai;

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
        $dataDari = Lembur::orderBy('tanggal_lembur', 'asc')->first();
        $dataSampai = Lembur::orderBy('tanggal_lembur', 'desc')->first();

        if ($dataDari == NULL) {
            $this->dari = Carbon::now()->format('Y-m-d');
            $this->sampai = Carbon::now()->format('Y-m-d');
        } else {
            $this->dari = Carbon::parse($dataDari->tanggal_lembur)->format('Y-m-d');
            $this->sampai = Carbon::parse($dataSampai->tanggal_lembur)->format('Y-m-d');
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

    // ------------ approve atasan ------------
    public function approveAtasan($id)
    {
        $this->lembur_id = $id;

        Lembur::where('id', $this->lembur_id)->update([
            'status' => 1,
            'status_hrd' => 0,
        ]);


        $this->lembur_id = '';
        $this->dispatch('approveAtasan', [
            'title' => 'Data Berhasil di approve!',
            'icon' => 'success',
        ]);
    }

    // ------------ reject atasan ------------
    public function rejectAtasan($id)
    {
        $this->lembur_id = $id;

        Lembur::where('id', $this->lembur_id)->update([
            'status' => 2,
            'status_hrd' => NULL,
        ]);


        $this->lembur_id = '';
        $this->dispatch('rejectAtasan', [
            'title' => 'Data Berhasil di reject!',
            'icon' => 'success',
        ]);
    }

    // ------------ reset atasan ------------
    public function resetAtasan($id)
    {
        $this->lembur_id = $id;

        Lembur::where('id', $this->lembur_id)->update([
            'status' => 0,
            'status_hrd' => NULL,
        ]);


        $this->lembur_id = '';
        $this->dispatch('resetAtasan', [
            'title' => 'Data Berhasil di reset!',
            'icon' => 'success',
        ]);
    }

    // ------------ approve HRD ------------
    public function approveHrd($id)
    {
        $this->lembur_id = $id;

        Lembur::where('id', $this->lembur_id)->update([
            'status_hrd' => 1,
        ]);


        $this->lembur_id = '';
        $this->dispatch('approveHrd', [
            'title' => 'Data Berhasil di approve!',
            'icon' => 'success',
        ]);
    }

    // ------------ reject HRD ------------
    public function rejectHrd($id)
    {
        $this->lembur_id = $id;

        Lembur::where('id', $this->lembur_id)->update([
            'status_hrd' => 2,
        ]);


        $this->lembur_id = '';
        $this->dispatch('rejectHrd', [
            'title' => 'Data Berhasil di reject!',
            'icon' => 'success',
        ]);
    }

    // ------------ reset hrd ------------
    public function resetHrd($id)
    {
        $this->lembur_id = $id;

        Lembur::where('id', $this->lembur_id)->update([
            'status' => 1,
            'status_hrd' => 0,
        ]);


        $this->lembur_id = '';
        $this->dispatch('resetHrd', [
            'title' => 'Data Berhasil di reset!',
            'icon' => 'success',
        ]);
    }

    // -------------- view -------------
    public function lihatLembur($id)
    {
        $this->lembur_id = $id;

        $data = Lembur::where('id', $this->lembur_id)->first();
        $user = $data->user()->first();

        $this->nama = $user->name;
        $this->tanggal_lembur = Carbon::parse($data->tanggal_lembur)->format('Y-m-d');
        $this->jam_mulai = $data->jam_mulai;
        $this->jam_selesai = $data->jam_akhir;
        $this->lama_lembur = $data->lama_lembur;
        $this->status = $data->status;
        $this->status_hrd = $data->status_hrd;
        $this->keterangan = $data->keterangan_lembur;

        $this->upah_lembur_perjam = $data->upah_lembur_perjam;
        $this->upah_lembur = $data->upah_lembur;
        $this->uang_makan = $data->uang_makan;

        $this->hari_libur = $data->hari_libur;

        $this->dispatch('show-view-modal');
    }

    public function closeView()
    {
        $this->lembur_id = '';
        $this->tanggal_lembur = '';
        $this->jam_mulai = '';
        $this->jam_selesai = '';
        $this->lama_lembur = '';
        $this->status = '';
        $this->status_hrd = '';
        $this->keterangan = '';
        $this->nama = '';
    }

    // ----------- download data ---------------
    public function downloadData()
    {
        $this->validate();

        if ($this->format_data == 'PDF') {

            $this->data = Lembur::where('status_hrd', '>', 0)
                ->whereBetween('tanggal_lembur', [$this->dari_tanggal_download, $this->sampai_tanggal_download])
                ->orderBy('tanggal_lembur', 'asc')
                ->get();

            $pdf = Pdf::loadView('livewire.data.pdf.lembur-pdf', [
                'data' => $this->data,
                'str_date' => $this->dari_tanggal_download,
                'n_date' => $this->sampai_tanggal_download,
            ])->output();

            return response()->streamDownload(
                fn () => print($pdf),
                $this->nama_file . ".pdf"
            );
        } elseif ($this->format_data == 'XLS') {
            return (new LemburExport($this->dari_tanggal_download, $this->sampai_tanggal_download))->download($this->nama_file . '.xlsx');
        } elseif ($this->format_data == 'CSV') {
            return (new LemburExport($this->dari_tanggal_download, $this->sampai_tanggal_download))->download($this->nama_file . '.csv');
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

        $data = Lembur::select('tb_lembur.*', 'users.name')
            ->where('users.name', 'like', '%' . $this->search . '%')
            ->whereBetween('tb_lembur.tanggal_lembur', [$this->dari, $this->sampai])
            ->join('users', 'users.id', '=', 'tb_lembur.user_id')
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);
        $dataHrd = Lembur::select('tb_lembur.*', 'users.name')
            ->where('tb_lembur.status', 1)
            ->where('users.name', 'like', '%' . $this->search . '%')
            ->whereBetween('tb_lembur.tanggal_lembur', [$this->dari, $this->sampai])
            ->join('users', 'users.id', '=', 'tb_lembur.user_id')
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
            $this->mySelected = Lembur::whereBetween('id', [$this->firstId, $this->lastId])->pluck('id');
        } else {
            $this->mySelected = [];
        }
    }

    // -------- bulk HRD---------------------------
    public function approveSelected()
    {
        Lembur::whereIn('id', $this->mySelected)->update([
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
        Lembur::whereIn('id', $this->mySelected)->update([
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
        Lembur::whereIn('id', $this->mySelected)->update([
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
        $data = Lembur::whereIn('id', $this->mySelected)->where('status_hrd', '>', 0)->pluck('status_hrd');


        if ($data->count() == 0) {
            Lembur::whereIn('id', $this->mySelected)->update([
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
        $data = Lembur::whereIn('id', $this->mySelected)->where('status_hrd', '>', 0)->pluck('status_hrd');


        if ($data->count() == 0) {
            Lembur::whereIn('id', $this->mySelected)->update([
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
        $data = Lembur::whereIn('id', $this->mySelected)->where('status_hrd', '>', 0)->pluck('status_hrd');


        if ($data->count() == 0) {
            Lembur::whereIn('id', $this->mySelected)->update([
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

    #[Title('Data Lembur')]
    #[Layout('layouts.app')]
    public function render()
    {
        $dataLembur = Lembur::select('tb_lembur.*', 'users.name')
            ->where('users.name', 'like', '%' . $this->search . '%')
            ->whereBetween('tb_lembur.tanggal_lembur', [$this->dari, $this->sampai])
            ->join('users', 'users.id', '=', 'tb_lembur.user_id')
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        $dataLemburHrd = Lembur::select('tb_lembur.*', 'users.name')
            ->where('tb_lembur.status', 1)
            ->where('users.name', 'like', '%' . $this->search . '%')
            ->whereBetween('tb_lembur.tanggal_lembur', [$this->dari, $this->sampai])
            ->join('users', 'users.id', '=', 'tb_lembur.user_id')
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        if (Auth::user()->role_id == 3) {
            $data = $dataLemburHrd->count();
            if ($data > 0) {
                $this->firstId = $dataLemburHrd[$data - 1]->id;
                $this->lastId = $dataLemburHrd[0]->id;
            }
        } elseif (Auth::user()->role_id == 4) {
            $data = $dataLembur->count();
            if ($data > 0) {
                $this->firstId = $dataLembur[$data - 1]->id;
                $this->lastId = $dataLembur[0]->id;
            }
        }

        return view('livewire.data.data-lembur', [
            'dataLembur' => $dataLembur,
            'countAtasan' => Lembur::where('status', 0)->count(),

            'dataLemburHrd' => $dataLemburHrd,
            'countHrd' => Lembur::where('status_hrd', 0)->count(),


        ]);
    }
}
