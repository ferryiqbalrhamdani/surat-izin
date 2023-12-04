<?php

namespace App\Livewire\DataInput;

use App\Models\SuratIzin as ModelsSuratIzin;
use Carbon\Carbon;
use DateInterval;
use DatePeriod;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class SuratIzin extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $perPage = 5;
    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    public $suratIzin_id,
        $durasi_izin,
        $status,
        $dari,
        $sampai,
        $status_hrd;

    #[Rule('required')]
    public $keperluan_izin;
    #[Rule('required')]
    public $tanggal_izin;
    #[Rule('required')]
    public $jam_masuk;
    #[Rule('required')]
    public $jam_keluar;
    #[Rule('required')]
    public $keterangan;

    #[Rule('required')]
    public $lama_izin = 'Sehari';
    #[Rule('required')]
    public $sampai_tanggal;

    #[Url()]
    public $search = '';

    public function mount()
    {
        $dataDari = ModelsSuratIzin::where('user_id', Auth::user()->id)->orderBy('tanggal_izin', 'asc')->first();
        $dataSampai = ModelsSuratIzin::where('user_id', Auth::user()->id)->orderBy('tanggal_izin', 'desc')->first();

        // dd($dataDari, $dataSampai);

        if ($dataDari == NULL) {
            $this->dari = Carbon::now()->format('Y-m-d');
            $this->sampai = Carbon::now()->format('Y-m-d');
        } else {
            $this->dari = Carbon::parse($dataDari->tanggal_izin)->format('Y-m-d');
            $this->sampai = Carbon::parse($dataSampai->tanggal_izin)->format('Y-m-d');
        }
    }

    protected function rules()
    {
        return ['sampai' => 'after:' . $this->dari];
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
        $this->suratIzin_id = $id;
        $data = ModelsSuratIzin::where('id', $this->suratIzin_id)->first();


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
        $this->suratIzin_id = '';
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

    // ----------- hapus -----------
    public function hapusSuratIzin($id)
    {
        $this->suratIzin_id = $id;

        $this->dispatch('show-delete-modal');
    }

    public function destroy()
    {
        ModelsSuratIzin::where('id', $this->suratIzin_id)->delete();

        $this->dispatch('close-delete-modal');
        $this->dispatch('delete', [
            'title' => 'Data Berhasil dihapus!',
            'icon' => 'success',
        ]);
    }

    public function closeHapus()
    {
        $this->suratIzin_id = '';
    }

    // ------------ ubah ------------------
    public function ubahSuratIzin($id)
    {
        $this->suratIzin_id = $id;
        $data = ModelsSuratIzin::where('id', $this->suratIzin_id)->first();


        $this->keperluan_izin = $data->keperluan_izin;
        $this->tanggal_izin = Carbon::parse($data->tanggal_izin)->format('Y-m-d');
        $this->sampai_tanggal = Carbon::parse($data->sampai_tanggal)->format('Y-m-d');
        if ($data->keperluan_izin == 'Izin Datang Terlambat') {
            $this->jam_masuk = Carbon::parse($data->jam_keluar)->format('H:i');
        } else {
            $this->jam_masuk = Carbon::parse($data->jam_masuk)->format('H:i');
        }
        $this->jam_keluar = Carbon::parse($data->jam_keluar)->format('H:i');
        $this->keterangan = $data->keterangan_izin;
        $this->lama_izin = $data->lama_izin;
        $this->status = $data->status;
        $this->status_hrd = $data->status_hrd;
        $this->durasi_izin = $data->durasi_izin;


        $this->dispatch('show-edit-modal');
    }

    public function edit()
    {
        if ($this->keperluan_izin == 'Izin Datang Terlambat') {
            $v_keperluan_izin = 'required';
            $v_tanggal_izin = 'required';
            $v_jam_masuk = 'required';
            $v_jam_keluar = '';
            $v_keterangan = 'required';
            $v_lama_izin = '';
            $v_sampai_tanggal = '';
        } elseif ($this->keperluan_izin == 'Izin Tidak Masuk Kerja') {
            if ($this->lama_izin == 'Sehari') {
                $v_keperluan_izin = 'required';
                $v_tanggal_izin = 'required';
                $v_jam_masuk = '';
                $v_jam_keluar = '';
                $v_keterangan = 'required';
                $v_lama_izin = 'required';
                $v_sampai_tanggal = '';
            } else {
                $v_keperluan_izin = 'required';
                $v_tanggal_izin = 'required';
                $v_jam_masuk = '';
                $v_jam_keluar = '';
                $v_keterangan = 'required';
                $v_lama_izin = 'required';
                $v_sampai_tanggal = 'required|after:' . $this->tanggal_izin;
            }
        } elseif ($this->keperluan_izin == 'Izin Meninggalkan Kantor') {
            $v_keperluan_izin = 'required';
            $v_tanggal_izin = 'required';
            $v_jam_masuk = 'required';
            $v_jam_keluar = 'required';
            $v_keterangan = 'required';
            $v_lama_izin = '';
            $v_sampai_tanggal = '';
        } elseif ($this->keperluan_izin == 'Tugas Meninggalkan Kantor') {
            if ($this->lama_izin == 'Sehari') {
                $v_keperluan_izin = 'required';
                $v_tanggal_izin = 'required';
                $v_jam_masuk = 'required';
                $v_jam_keluar = 'required';
                $v_keterangan = 'required';
                $v_lama_izin = 'required';
                $v_sampai_tanggal = '';
            } else {
                $v_keperluan_izin = 'required';
                $v_tanggal_izin = 'required';
                $v_jam_masuk = '';
                $v_jam_keluar = '';
                $v_keterangan = 'required';
                $v_lama_izin = 'required';
                $v_sampai_tanggal = 'required|after:' . $this->tanggal_izin;
            }
        } else {
            $v_keperluan_izin = 'required';
            $v_tanggal_izin = 'required';
            $v_jam_masuk = 'required';
            $v_jam_keluar = 'required';
            $v_keterangan = 'required';
            $v_lama_izin = 'required';
            $v_sampai_tanggal = 'required';
        }

        $this->validate([
            'keperluan_izin' => $v_keperluan_izin,
            'tanggal_izin' => $v_tanggal_izin,
            'jam_masuk' => $v_jam_masuk,
            'jam_keluar' => $v_jam_keluar,
            'keterangan' => $v_keterangan,
            'lama_izin' => $v_lama_izin,
            'sampai_tanggal' => $v_sampai_tanggal,
        ]);

        if ($this->keperluan_izin == 'Izin Datang Terlambat') {
            $keperluan_izin = $this->keperluan_izin;
            $tanggal_izin = $this->tanggal_izin;
            $jam_masuk = '08:00';
            $jam_keluar = $this->jam_masuk;
            $keterangan = $this->keterangan;
            $sampai_tanggal = $this->tanggal_izin;

            $str = date_create($tanggal_izin);
            $n = date_create($sampai_tanggal);

            $data = date_diff($str, $n);
            $diff = $data->d + 1;

            $lama_izin = $diff;
        } elseif ($this->keperluan_izin == 'Izin Tidak Masuk Kerja') {
            $keperluan_izin = $this->keperluan_izin;
            $tanggal_izin = $this->tanggal_izin;
            $jam_masuk = NULL;
            $jam_keluar = NULL;
            $keterangan = $this->keterangan;
            $sampai_tanggal = $this->sampai_tanggal;

            $start = new DateTime($tanggal_izin);
            $end = new DateTime($sampai_tanggal);
            // otherwise the  end date is excluded (bug?)
            $end->modify('+1 day');

            $interval = $end->diff($start);

            // total days
            $days = $interval->days;

            // create an iterateable period of date (P1D equates to 1 day)
            $period = new DatePeriod($start, new DateInterval('P1D'), $end);

            // best stored as array, so you can add more than one
            $holidays = array('2012-09-07');

            foreach ($period as $dt) {
                $curr = $dt->format('D');

                // substract if Saturday or Sunday
                if ($curr == 'Sat' || $curr == 'Sun') {
                    $days--;
                }

                // (optional) for the updated question
                elseif (in_array($dt->format('Y-m-d'), $holidays)) {
                    $days--;
                }
            }

            if ($this->lama_izin == 'Sehari') {
                $lama_izin = (int)$days + 1;
            } else {
                $lama_izin = (int)$days;
            }
        } elseif ($this->keperluan_izin == 'Izin Meninggalkan Kantor') {
            $keperluan_izin = $this->keperluan_izin;
            $tanggal_izin = $this->tanggal_izin;
            $jam_masuk = $this->jam_masuk;
            $jam_keluar = $this->jam_keluar;
            $keterangan = $this->keterangan;
            $sampai_tanggal = $this->tanggal_izin;

            $str = date_create($tanggal_izin);
            $n = date_create($sampai_tanggal);

            $data = date_diff($str, $n);
            $diff = $data->d + 1;

            $lama_izin = $diff;
        } elseif ($this->keperluan_izin == 'Tugas Meninggalkan Kantor') {
            if ($this->lama_izin == 'Sehari') {
                $keperluan_izin = $this->keperluan_izin;
                $tanggal_izin = $this->tanggal_izin;
                $jam_masuk = $this->jam_masuk;
                $jam_keluar = $this->jam_keluar;
                $keterangan = $this->keterangan;
                $sampai_tanggal = $this->tanggal_izin;

                $str = date_create($tanggal_izin);
                $n = date_create($sampai_tanggal);

                $data = date_diff($str, $n);
                $diff = $data->d + 1;

                $lama_izin = $diff;
            } else {
                $keperluan_izin = $this->keperluan_izin;
                $tanggal_izin = $this->tanggal_izin;
                $jam_masuk = NULL;
                $jam_keluar = NULL;
                $keterangan = $this->keterangan;
                $sampai_tanggal = $this->sampai_tanggal;

                $start = new DateTime($tanggal_izin);
                $end = new DateTime($sampai_tanggal);
                // otherwise the  end date is excluded (bug?)
                $end->modify('+1 day');

                $interval = $end->diff($start);

                // total days
                $days = $interval->days;

                // create an iterateable period of date (P1D equates to 1 day)
                $period = new DatePeriod($start, new DateInterval('P1D'), $end);

                // best stored as array, so you can add more than one
                $holidays = array('2012-09-07');

                foreach ($period as $dt) {
                    $curr = $dt->format('D');

                    // substract if Saturday or Sunday
                    if ($curr == 'Sat' || $curr == 'Sun') {
                        $days--;
                    }

                    // (optional) for the updated question
                    elseif (in_array($dt->format('Y-m-d'), $holidays)) {
                        $days--;
                    }
                }

                $lama_izin = (int)$days;
            }
        }

        ModelsSuratIzin::where('id', $this->suratIzin_id)->update([
            'user_id' => Auth::user()->id,
            'keperluan_izin' => $keperluan_izin,
            'lama_izin' => $this->lama_izin,
            'tanggal_izin' => $tanggal_izin,
            'sampai_tanggal' => $sampai_tanggal,
            'durasi_izin' => $lama_izin,
            'jam_masuk' => $jam_masuk,
            'jam_keluar' => $jam_keluar,
            'keterangan_izin' => $keterangan,
        ]);

        $this->suratIzin_id = '';
        $this->keperluan_izin = '';
        $this->tanggal_izin = '';
        $this->sampai_tanggal = '';
        $this->jam_masuk = '';
        $this->jam_keluar = '';
        $this->keterangan = '';
        $this->lama_izin = '';
        $this->durasi_izin = '';

        $this->dispatch('close-edit-modal');
        $this->dispatch('update', [
            'title' => 'Data Berhasil diubah!',
            'icon' => 'success',
        ]);
    }

    public function closeEdit()
    {
        $this->suratIzin_id = '';
        $this->keperluan_izin = '';
        $this->tanggal_izin = '';
        $this->sampai_tanggal = '';
        $this->jam_masuk = '';
        $this->jam_keluar = '';
        $this->keterangan = '';
        $this->lama_izin = '';
        $this->durasi_izin = '';
    }

    // ---------- reset -----
    public function resetData()
    {
        $data = ModelsSuratIzin::where('id', $this->suratIzin_id)->first();

        if ($this->keperluan_izin != 'Tugas Meninggalkan Kantor' || $this->keperluan_izin != 'Izin Tidak Masuk Kerja') {
            $this->lama_izin = 'Sehari';
        } else {
            $this->lama_izin = $data->lama_izin;
        }
    }


    #[Title('Surat Izin')]
    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.data-input.surat-izin', [
            'suratIzin' => ModelsSuratIzin::whereBetween('tanggal_izin', [$this->dari, $this->sampai])
                ->where('user_id', Auth::user()->id)
                ->where('keperluan_izin', 'like', '%' . $this->search . '%')
                ->orWhere('user_id', Auth::user()->id)
                ->where('tanggal_izin', 'like', '%' . $this->search . '%')
                ->whereBetween('tanggal_izin', [$this->dari, $this->sampai])
                ->orWhere('user_id', Auth::user()->id)
                ->where('durasi_izin', 'like', '%' . $this->search . '%')
                ->whereBetween('tanggal_izin', [$this->dari, $this->sampai])
                ->orWhere('user_id', Auth::user()->id)
                ->where('jam_keluar', 'like', '%' . $this->search . '%')
                ->whereBetween('tanggal_izin', [$this->dari, $this->sampai])
                ->orWhere('user_id', Auth::user()->id)
                ->where('jam_masuk', 'like', '%' . $this->search . '%')
                ->whereBetween('tanggal_izin', [$this->dari, $this->sampai])
                ->orderBy($this->sortField, $this->sortDirection)
                ->paginate($this->perPage),
        ]);
    }
}
