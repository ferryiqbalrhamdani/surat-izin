<?php

namespace App\Livewire\Data;

use App\Models\Cuti;
use Carbon\Carbon;
use Livewire\Attributes\Layout;
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

    #[Title('Data Cuti')]
    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.data.data-cuti', [
            'dataCuti' => Cuti::select('tb_cuti.*', 'users.name')
                ->where('users.name', 'like', '%' . $this->search . '%')
                ->whereBetween('tb_cuti.tanggal_cuti', [$this->dari, $this->sampai])
                ->join('users', 'users.id', '=', 'tb_cuti.user_id')
                ->orderBy($this->sortField, $this->sortDirection)
                ->paginate($this->perPage),
            'countAtasan' => Cuti::where('status', 0)->count(),

            'dataCutiHrd' => Cuti::select('tb_cuti.*', 'users.name')
                ->where('tb_cuti.status', 1)
                ->where('users.name', 'like', '%' . $this->search . '%')
                ->whereBetween('tb_cuti.tanggal_cuti', [$this->dari, $this->sampai])
                ->join('users', 'users.id', '=', 'tb_cuti.user_id')
                ->orderBy($this->sortField, $this->sortDirection)
                ->paginate($this->perPage),
            'countHrd' => Cuti::where('status_hrd', 0)->count(),
        ]);
    }
}
