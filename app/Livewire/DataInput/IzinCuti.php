<?php

namespace App\Livewire\DataInput;

use App\Models\Cuti;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use RealRashid\SweetAlert\Facades\Alert;

class IzinCuti extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $perPage = 5;
    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    #[Url()]
    public $search = '';

    public $dari, $durasi, $status, $status_hrd,
        $sampai,
        $cuti_id;

    #[Rule('required')]
    public $keperluan_cuti;
    #[Rule('required')]
    public $tanggal_cuti;
    #[Rule('required')]
    public $sampai_tanggal;
    #[Rule('required')]
    public $keterangan_cuti;
    #[Rule('required')]
    public $lama_cuti = 'Sehari';
    #[Rule('required')]
    public $pilihan;

    public function mount()
    {
        $dataDari = Cuti::orderBy('tanggal_cuti', 'asc')->first();
        $dataSampai = Cuti::orderBy('tanggal_cuti', 'desc')->first();

        $this->dari = Carbon::parse($dataDari->tanggal_cuti)->format('Y-m-d');
        $this->sampai = Carbon::parse($dataSampai->tanggal_cuti)->format('Y-m-d');
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

    // ------------ hapus -------------
    public function hapuscuti($id)
    {
        $this->cuti_id = $id;

        $this->dispatch('show-delete-modal');
    }

    public function closeHapus()
    {
        $this->cuti_id = '';
    }

    public function destroy()
    {
        Cuti::where('id', $this->cuti_id)->delete();

        $this->cuti_id = '';

        $this->dispatch('close-delete-modal');
        $this->dispatch('delete', [
            'title' => 'Data Berhasil dihapus!',
            'icon' => 'success',
        ]);
    }

    // ---------------- ubah ------------------
    public function ubahcuti($id)
    {
        $this->cuti_id = $id;

        $data = Cuti::where('id', $this->cuti_id)->first();
        $this->keperluan_cuti = $data->keperluan_cuti;
        $this->tanggal_cuti = Carbon::parse($data->tanggal_cuti)->format('Y-m-d');
        $this->sampai_tanggal = Carbon::parse($data->sampai_tanggal)->format('Y-m-d');
        $this->keterangan_cuti = $data->keterangan_cuti;
        $this->lama_cuti = $data->lama_cuti;
        $this->pilihan = $data->pilihan;

        $this->dispatch('show-edit-modal');
    }

    public function closeEdit()
    {
        $this->cuti_id = '';
        $this->keperluan_cuti = '';
        $this->tanggal_cuti = '';
        $this->sampai_tanggal = '';
        $this->keterangan_cuti = '';
        $this->lama_cuti = '';
        $this->pilihan = '';
    }

    public function edit()
    {
        if ($this->keperluan_cuti == 'Cuti Pribadi') {
            if ($this->lama_cuti == 'Sehari') {
                $v_pilihan = '';
                $v_sampai_tanggal = '';
            } else {
                $v_pilihan = '';
                $v_sampai_tanggal = 'required|date|after:' . $this->tanggal_cuti;
            }
        } elseif ($this->keperluan_cuti == 'Cuti Khusus') {
            $v_pilihan = 'required';
            if ($this->pilihan == 'Cuti Melahirkan') {
                $v_sampai_tanggal = '';
            } else {
                if ($this->lama_cuti == 'Sehari') {
                    $v_sampai_tanggal = '';
                } else {
                    $v_sampai_tanggal = 'required|date|after:' . $this->tanggal_cuti;
                }
            }
        } else {
            $v_pilihan = 'required';
            $v_sampai_tanggal = 'required';
        }

        $this->validate([
            'keperluan_cuti' => 'required',
            'tanggal_cuti' => 'required|date',
            'sampai_tanggal' => $v_sampai_tanggal,
            'keterangan_cuti' => 'required',
            'lama_cuti' => 'required',
            'pilihan' => $v_pilihan,
        ]);

        if ($this->keperluan_cuti == 'Cuti Pribadi') {
            if ($this->lama_cuti == 'Sehari') {
                $str = date_create($this->tanggal_cuti);
                $n = date_create($this->tanggal_cuti);

                $data = date_diff($str, $n);
                $lama_cuti = $data->d + 1 . " hari";
            } else {
                $str = date_create($this->tanggal_cuti);
                $n = date_create($this->sampai_tanggal);

                $data = date_diff($str, $n);
                $lama_cuti = $data->d + 1 . " hari";
            }
        } elseif ($this->keperluan_cuti == 'Cuti Khusus') {
            if ($this->pilihan == 'Cuti Melahirkan') {
                $str = date('Y-m-d', strtotime($this->tanggal_cuti));
                $n = date('Y-m-d', strtotime($str . " +3 month"));
                $lama_cuti = Carbon::parse($str)->diffInMonths(Carbon::parse($n), false) . " bulan";
            } else {
                if ($this->lama_cuti == 'Sehari') {
                    $str = date_create($this->tanggal_cuti);
                    $n = date_create($this->tanggal_cuti);

                    $data = date_diff($str, $n);
                    $lama_cuti = $data->d + 1 . " hari";
                } else {
                    $str = date_create($this->tanggal_cuti);
                    $n = date_create($this->sampai_tanggal);

                    $data = date_diff($str, $n);
                    $lama_cuti = $data->d + 1 . " hari";
                }
            }
        }

        Cuti::where('id', $this->cuti_id)->update([
            'keperluan_cuti' => $this->keperluan_cuti,
            'tanggal_cuti' => $str,
            'sampai_tanggal' => $n,
            'keterangan_cuti' => $this->keterangan_cuti,
            'lama_cuti' => $this->lama_cuti,
            'durasi' => $lama_cuti,
            'pilihan' => $this->pilihan,
        ]);

        $this->dispatch('close-edit-modal');
        $this->dispatch('update', [
            'title' => 'Data Berhasil diubah!',
            'icon' => 'success',
        ]);
    }

    // ------------ view -------------
    public function lihatcuti($id)
    {
        $this->cuti_id = $id;

        $data = Cuti::where('id', $this->cuti_id)->first();
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

    #[Title('Izin Cuti')]
    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.data-input.izin-cuti', [
            'cuti' => Cuti::whereBetween('tanggal_cuti', [$this->dari, $this->sampai])
                ->where('user_id', Auth::user()->id)
                ->where('keperluan_cuti', 'like', '%' . $this->search . '%')
                ->orWhere('user_id', Auth::user()->id)
                ->where('tanggal_cuti', 'like', '%' . $this->search . '%')
                ->whereBetween('tanggal_cuti', [$this->dari, $this->sampai])
                ->orWhere('user_id', Auth::user()->id)
                ->where('sampai_tanggal', 'like', '%' . $this->search . '%')
                ->whereBetween('tanggal_cuti', [$this->dari, $this->sampai])
                ->orWhere('user_id', Auth::user()->id)
                ->where('lama_cuti', 'like', '%' . $this->search . '%')
                ->whereBetween('tanggal_cuti', [$this->dari, $this->sampai])
                ->orderBy($this->sortField, $this->sortDirection)
                ->paginate($this->perPage),
        ]);
    }
}
