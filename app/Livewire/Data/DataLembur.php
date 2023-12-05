<?php

namespace App\Livewire\Data;

use App\Models\Lembur;
use Carbon\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

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
        $jam_mulai;

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

    #[Title('Data Lembur')]
    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.data.data-lembur', [
            'dataLembur' => Lembur::select('tb_lembur.*', 'users.name')
                ->where('users.name', 'like', '%' . $this->search . '%')
                ->whereBetween('tb_lembur.tanggal_lembur', [$this->dari, $this->sampai])
                ->join('users', 'users.id', '=', 'tb_lembur.user_id')
                ->orderBy($this->sortField, $this->sortDirection)
                ->paginate($this->perPage),
            'countAtasan' => Lembur::where('status', 0)->count(),

            'dataLemburHrd' => Lembur::select('tb_lembur.*', 'users.name')
                ->where('tb_lembur.status', 1)
                ->where('users.name', 'like', '%' . $this->search . '%')
                ->whereBetween('tb_lembur.tanggal_lembur', [$this->dari, $this->sampai])
                ->join('users', 'users.id', '=', 'tb_lembur.user_id')
                ->orderBy($this->sortField, $this->sortDirection)
                ->paginate($this->perPage),
            'countHrd' => Lembur::where('status_hrd', 0)->count(),


        ]);
    }
}
