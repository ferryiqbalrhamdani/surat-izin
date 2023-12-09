<?php

namespace App\Livewire\Data;

use App\Models\SuratIzin;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class DataIzin extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['resetMySelected' => 'resetSelected'];

    public $perPage = 5;
    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    #[Url()]
    public $search = '';

    public $sampai,
        $dari,
        $jam,
        $menit,
        $oldPhoto,
        $photo,
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

        if ($data->jam_masuk != NULL && $data->jam_keluar != NULL) {
            $awal = Carbon::parse($data->jam_masuk)->format('H:i');
            $akhir = Carbon::parse($data->jam_keluar)->format('H:i');

            $jamAwal = explode(':', $awal);
            $jamAkhir = explode(':', $akhir);

            $jam = $jamAkhir[0] - $jamAwal[0];
            $menit = $jamAkhir[1] - $jamAwal[1];

            $this->jam = $jam;
            $this->menit = $menit;
        }
        $this->keterangan = $data->keterangan_izin;
        $this->lama_izin = $data->lama_izin;
        $this->status = $data->status;
        $this->status_hrd = $data->status_hrd;
        $this->durasi_izin = $data->durasi_izin;
        $this->oldPhoto = $data->photo;



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
        $this->photo = '';
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

    // ------------ lihat photo -------------
    public function lihatPhoto()
    {
        $this->dispatch('show-photo-modal');
    }

    // ----------- download data ---------------
    public function downloadData()
    {
        $this->validate();
        dd('ok');
    }

    // -------- bulk ---------------------------

    public function resetSelected()
    {
        $this->mySelected = [];
        $this->selectAll = false;
    }

    public function updatedMySelected()
    {
        // dd($value);
        $data = SuratIzin::select('tb_izin.*', 'users.name')
            ->where('tb_izin.status', 1)
            ->where('users.name', 'like', '%' . $this->search . '%')
            ->whereBetween('tb_izin.tanggal_izin', [$this->dari, $this->sampai])
            ->join('users', 'users.id', '=', 'tb_izin.user_id')
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        if (count($this->mySelected) == $data->count() || count($this->mySelected) == $this->perPage) {
            $this->selectAll = true;
        } else {
            $this->selectAll = false;
        }
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->mySelected = SuratIzin::whereBetween('id', [$this->firstId, $this->lastId])->pluck('id');
        } else {
            $this->mySelected = [];
        }
    }

    // -------- bulk HRD---------------------------
    public function approveSelected()
    {
        SuratIzin::whereIn('id', $this->mySelected)->update([
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
        SuratIzin::whereIn('id', $this->mySelected)->update([
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
        SuratIzin::whereIn('id', $this->mySelected)->update([
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
        $data = SuratIzin::whereIn('id', $this->mySelected)->where('status_hrd', '>', 0)->pluck('status_hrd');


        if ($data->count() == 0) {
            SuratIzin::whereIn('id', $this->mySelected)->update([
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
        $data = SuratIzin::whereIn('id', $this->mySelected)->where('status_hrd', '>', 0)->pluck('status_hrd');


        if ($data->count() == 0) {
            SuratIzin::whereIn('id', $this->mySelected)->update([
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
        $data = SuratIzin::whereIn('id', $this->mySelected)->where('status_hrd', '>', 0)->pluck('status_hrd');


        if ($data->count() == 0) {
            SuratIzin::whereIn('id', $this->mySelected)->update([
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


    #[Title('Data Izin')]
    #[Layout('layouts.app')]
    public function render()
    {
        $dataIzinHrd = SuratIzin::select('tb_izin.*', 'users.name')
            ->where('tb_izin.status', 1)
            ->where('users.name', 'like', '%' . $this->search . '%')
            ->whereBetween('tb_izin.tanggal_izin', [$this->dari, $this->sampai])
            ->join('users', 'users.id', '=', 'tb_izin.user_id')
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);



        $dataIzin =  SuratIzin::select('tb_izin.*', 'users.name')
            ->where('users.name', 'like', '%' . $this->search . '%')
            ->whereBetween('tb_izin.tanggal_izin', [$this->dari, $this->sampai])
            ->join('users', 'users.id', '=', 'tb_izin.user_id')
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);


        if (Auth::user()->role_id == 3) {
            $data = $dataIzinHrd->count();
            if ($data > 0) {
                $this->firstId = $dataIzinHrd[$data - 1]->id;
                $this->lastId = $dataIzinHrd[0]->id;
            }
        } elseif (Auth::user()->role_id == 4) {
            $data = $dataIzin->count();
            if ($data > 0) {
                $this->firstId = $dataIzin[$data - 1]->id;
                $this->lastId = $dataIzin[0]->id;
            }
        }

        return view('livewire.data.data-izin', [
            'dataIzin' => $dataIzin,
            'countAtasan' => SuratIzin::where('status', 0)->count(),

            'dataIzinHrd' => $dataIzinHrd,
            'countHrd' => SuratIzin::where('status_hrd', 0)->count(),
        ]);
    }
}
