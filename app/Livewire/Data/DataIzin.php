<?php

namespace App\Livewire\Data;

use App\Models\SuratIzin;
use Carbon\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class DataIzin extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $perPage = 5;
    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    #[Url()]
    public $search = '';

    public $sampai,
        $dari,
        $keperluan_izin,
        $tanggal_izin,
        $sampai_tanggal,
        $jam_masuk,
        $jam_keluar,
        $keterangan,
        $lama_izin,
        $status,
        $status_hrd,
        $nama,
        $durasi_izin,
        $izin_id;

    public function mount()
    {
        $dataDari = SuratIzin::orderBy('tanggal_izin', 'asc')->first();
        $dataSampai = SuratIzin::orderBy('tanggal_izin', 'desc')->first();

        if ($dataDari == NULL) {
            $this->dari = Carbon::now()->format('Y-m-d');
            $this->sampai = Carbon::now()->format('Y-m-d');
        } else {
            $this->dari = Carbon::parse($dataDari->tanggal_izin)->format('Y-m-d');
            $this->sampai = Carbon::parse($dataSampai->tanggal_izin)->format('Y-m-d');
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

    // ----------- view ------------
    public function lihatSuratIzin($id)
    {
        $this->izin_id = $id;
        $data = SuratIzin::where('id', $this->izin_id)->first();
        $user = $data->user()->first();

        $this->nama = $user->name;


        $this->keperluan_izin = $data->keperluan_izin;
        $this->tanggal_izin = Carbon::parse($data->tanggal_izin)->format('Y-m-d');
        $this->sampai_tanggal = Carbon::parse($data->sampai_tanggal)->format('Y-m-d');
        if ($data->jam_masuk != NULL) {
            $this->jam_masuk = Carbon::parse($data->jam_masuk)->format('H:i');
        } else {
            $this->jam_masuk = '-';
        }
        if ($data->jam_keluar != NULL) {
            $this->jam_keluar = Carbon::parse($data->jam_keluar)->format('H:i');
        } else {
            $this->jam_keluar = '-';
        }
        $this->keterangan = $data->keterangan_izin;
        $this->lama_izin = $data->lama_izin;
        $this->status = $data->status;
        $this->status_hrd = $data->status_hrd;
        $this->durasi_izin = $data->durasi_izin . ' hari';


        $this->dispatch('show-view-modal');
    }

    public function closeView()
    {
        $this->izin_id = '';
        $this->keperluan_izin = '';
        $this->tanggal_izin = '';
        $this->sampai_tanggal = '';
        $this->jam_masuk = '';
        $this->jam_keluar = '';
        $this->keterangan = '';
        $this->lama_izin = '';
        $this->durasi_izin = '';
        $this->status = '';
        $this->status_hrd = '';
    }

    // ------------ approve atasan ------------
    public function approveAtasan($id)
    {
        $this->izin_id = $id;

        SuratIzin::where('id', $this->izin_id)->update([
            'status' => 1,
            'status_hrd' => 0,
        ]);


        $this->izin_id = '';
        $this->dispatch('approveAtasan', [
            'title' => 'Data Berhasil di approve!',
            'icon' => 'success',
        ]);
    }

    // ------------ reject atasan ------------
    public function rejectAtasan($id)
    {
        $this->izin_id = $id;

        SuratIzin::where('id', $this->izin_id)->update([
            'status' => 2,
            'status_hrd' => NULL,
        ]);


        $this->izin_id = '';
        $this->dispatch('rejectAtasan', [
            'title' => 'Data Berhasil di reject!',
            'icon' => 'success',
        ]);
    }

    // ------------ reset atasan ------------
    public function resetAtasan($id)
    {
        $this->izin_id = $id;

        SuratIzin::where('id', $this->izin_id)->update([
            'status' => 0,
            'status_hrd' => NULL,
        ]);


        $this->izin_id = '';
        $this->dispatch('resetAtasan', [
            'title' => 'Data Berhasil di reset!',
            'icon' => 'success',
        ]);
    }

    // ------------ approve HRD ------------
    public function approveHrd($id)
    {
        $this->izin_id = $id;

        SuratIzin::where('id', $this->izin_id)->update([
            'status_hrd' => 1,
        ]);


        $this->izin_id = '';
        $this->dispatch('approveHrd', [
            'title' => 'Data Berhasil di approve!',
            'icon' => 'success',
        ]);
    }

    // ------------ reject HRD ------------
    public function rejectHrd($id)
    {
        $this->izin_id = $id;

        SuratIzin::where('id', $this->izin_id)->update([
            'status_hrd' => 2,
        ]);


        $this->izin_id = '';
        $this->dispatch('rejectHrd', [
            'title' => 'Data Berhasil di reject!',
            'icon' => 'success',
        ]);
    }

    // ------------ reset hrd ------------
    public function resetHrd($id)
    {
        $this->izin_id = $id;

        SuratIzin::where('id', $this->izin_id)->update([
            'status' => 1,
            'status_hrd' => 0,
        ]);


        $this->izin_id = '';
        $this->dispatch('resetHrd', [
            'title' => 'Data Berhasil di reset!',
            'icon' => 'success',
        ]);
    }

    #[Title('Data Izin')]
    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.data.data-izin', [
            'dataIzin' => SuratIzin::select('tb_izin.*', 'users.name')
                ->where('users.name', 'like', '%' . $this->search . '%')
                ->whereBetween('tb_izin.tanggal_izin', [$this->dari, $this->sampai])
                ->join('users', 'users.id', '=', 'tb_izin.user_id')
                ->orderBy($this->sortField, $this->sortDirection)
                ->paginate($this->perPage),
            'countAtasan' => SuratIzin::where('status', 0)->count(),

            'dataIzinHrd' => SuratIzin::select('tb_izin.*', 'users.name')
                ->where('tb_izin.status', 1)
                ->where('users.name', 'like', '%' . $this->search . '%')
                ->whereBetween('tb_izin.tanggal_izin', [$this->dari, $this->sampai])
                ->join('users', 'users.id', '=', 'tb_izin.user_id')
                ->orderBy($this->sortField, $this->sortDirection)
                ->paginate($this->perPage),
            'countHrd' => SuratIzin::where('status_hrd', 0)->count(),
        ]);
    }
}
