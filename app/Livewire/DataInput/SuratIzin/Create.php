<?php

namespace App\Livewire\DataInput\SuratIzin;

use App\Models\SuratIzin;
use Carbon\Carbon;
use DateInterval;
use DatePeriod;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\Component;
use RealRashid\SweetAlert\Facades\Alert;

class Create extends Component
{

    #[Rule('required')]
    public $keperluan_izin;
    #[Rule('required')]
    public $tanggal_izin;
    #[Rule('required', as: 'jam mulai')]
    public $jam_masuk;
    #[Rule('required', as: 'jam akhir')]
    public $jam_keluar;
    #[Rule('required')]
    public $keterangan;

    #[Rule('required')]
    public $lama_izin = 'Sehari';
    #[Rule('required')]
    public $sampai_tanggal;

    public function mount()
    {
        // $this->tanggal_izin = Carbon::now()->format('Y-m-d');
    }


    public function addAction()
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

        SuratIzin::create([
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

        Alert::toast('Data surat izin berhasil ditambahkan.', 'success');
        return redirect('surat-izin');
    }

    // ---------- reset -----
    public function resetData()
    {

        if ($this->keperluan_izin != 'Tugas Meninggalkan Kantor' || $this->keperluan_izin != 'Izin Tidak Masuk Kerja') {
            $this->lama_izin = 'Sehari';
        }
    }

    #[Title('Tambah Data')]
    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.data-input.surat-izin.create');
    }
}