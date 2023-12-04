<?php

namespace App\Livewire\DataInput;

use App\Models\Lembur;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class IzinLembur extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $dari, $sampai, $lembur_id, $lama_lembur, $status, $status_hrd;

    public $perPage = 5;
    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    #[Url()]
    public $search = '';

    #[Rule('required')]
    public $tanggal_lembur;
    #[Rule('required')]
    public $jam_mulai;
    #[Rule('required')]
    public $jam_selesai;
    #[Rule('required')]
    public $keterangan;

    public function mount()
    {
        $dataDari = Lembur::where('user_id', Auth::user()->id)->orderBy('tanggal_lembur', 'asc')->first();
        $dataSampai = Lembur::where('user_id', Auth::user()->id)->orderBy('tanggal_lembur', 'desc')->first();

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

    // ---------- hapus ----------------------
    public function hapusLembur($id)
    {
        $this->lembur_id = $id;

        $this->dispatch('show-delete-modal');
    }

    public function closeHapus()
    {
        $this->lembur_id = '';
    }

    public function destroy()
    {
        Lembur::where('id', $this->lembur_id)->delete();

        $this->lembur_id = '';
        $this->dispatch('close-delete-modal');
        $this->dispatch('delete', [
            'title' => 'Data Berhasil dihapus!',
            'icon' => 'success',
        ]);
    }

    // -------- ubah -----------
    public function ubahLembur($id)
    {
        $this->lembur_id = $id;

        $data = Lembur::where('id', $this->lembur_id)->first();

        $this->tanggal_lembur = Carbon::parse($data->tanggal_lembur)->format('Y-m-d');
        $this->jam_mulai = $data->jam_mulai;
        $this->jam_selesai = $data->jam_akhir;
        $this->keterangan = $data->keterangan_lembur;

        $this->dispatch('show-edit-modal');
    }

    public function closeEdit()
    {
        $this->lembur_id = '';
        $this->tanggal_lembur = '';
        $this->jam_mulai = '';
        $this->jam_selesai = '';
        $this->keterangan = '';
    }

    public function edit()
    {
        $this->validate();

        $datetime1  = $this->jam_mulai;
        $datetime2  = $this->jam_selesai;
        $date1 = new DateTime($datetime1);
        $date2 = new DateTime($datetime2);
        $lamaLembur = $date1->diff($date2)->format('%H:%I');
        $pemisahan = explode(':', $lamaLembur);
        $jam = $pemisahan[0];
        $upahMakan = 0;
        $status = 0;
        $status_hrd = null;

        if ($lamaLembur > '05:00') {
            $upahLemburPerjam = 0;
            $upahLembur = 100000;
        } else if ($lamaLembur >= '03:00') {
            $upahLemburPerjam = 15000;
            $upahMakan = 20000;
            $upahLembur = 15000 * $jam + $upahMakan;
        } else {
            $upahLemburPerjam = 15000;
            $upahLembur = 15000 * $jam;
        }

        if (Auth::user()->role_id == 4) {
            $status = 1;
            $status_hrd = 0;
        }


        Lembur::where('id', $this->lembur_id)->update([
            'user_id' => Auth::user()->id,
            'tanggal_lembur' => date_create($this->tanggal_lembur),
            'jam_mulai' => $this->jam_mulai,
            'jam_akhir' => $this->jam_selesai,
            'lama_lembur' => $lamaLembur,
            'uang_makan' => $upahMakan,
            'upah_lembur_perjam' => $upahLemburPerjam,
            'upah_lembur' => $upahLembur,
            'status' => $status,
            'status_hrd' => $status_hrd,
            'keterangan_lembur' => $this->keterangan,
        ]);

        $this->lembur_id = '';
        $this->tanggal_lembur = '';
        $this->jam_mulai = '';
        $this->jam_selesai = '';
        $this->keterangan = '';

        $this->dispatch('close-edit-modal');
        $this->dispatch('update', [
            'title' => 'Data Berhasil diubah!',
            'icon' => 'success',
        ]);
    }

    // -------------- view -------------
    public function lihatLembur($id)
    {
        $this->lembur_id = $id;

        $data = Lembur::where('id', $this->lembur_id)->first();

        $this->tanggal_lembur = Carbon::parse($data->tanggal_lembur)->format('Y-m-d');
        $this->jam_mulai = $data->jam_mulai;
        $this->jam_selesai = $data->jam_akhir;
        $this->lama_lembur = $data->lama_lembur;
        $this->status = $data->status;
        $this->status_hrd = $data->status_hrd;
        $this->keterangan = $data->keterangan_lembur;

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
    }

    #[Title('Izin Lembur')]
    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.data-input.izin-lembur', [
            'lembur' => Lembur::whereBetween('tanggal_lembur', [$this->dari, $this->sampai])
                ->where('user_id', Auth::user()->id)
                ->where('tanggal_lembur', 'like', '%' . $this->search . '%')
                ->orWhere('user_id', Auth::user()->id)
                ->where('jam_mulai', 'like', '%' . $this->search . '%')
                ->whereBetween('tanggal_lembur', [$this->dari, $this->sampai])
                ->orWhere('user_id', Auth::user()->id)
                ->where('jam_akhir', 'like', '%' . $this->search . '%')
                ->whereBetween('tanggal_lembur', [$this->dari, $this->sampai])
                ->orderBy($this->sortField, $this->sortDirection)
                ->paginate($this->perPage),
        ]);
    }
}
