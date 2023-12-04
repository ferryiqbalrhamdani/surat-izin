<?php

namespace App\Livewire\DataInput\IzinCuti;

use App\Models\Cuti;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\Component;

class Create extends Component
{

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
    }

    public function addAction()
    {

        // dd('ok');
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

        Cuti::create([
            'user_id' => Auth::user()->id,
            'keperluan_cuti' => $this->keperluan_cuti,
            'tanggal_cuti' => $str,
            'sampai_tanggal' => $n,
            'keterangan_cuti' => $this->keterangan_cuti,
            'lama_cuti' => $this->lama_cuti,
            'durasi' => $lama_cuti,
            'pilihan' => $this->pilihan,
        ]);


        toast('Berhasil disimpan.', 'success');
        return redirect('izin-cuti');
    }

    // ---------- reset -----
    public function resetData()
    {

        if ($this->keperluan_cuti == 'Cuti Pribadi' || $this->keperluan_cuti == 'Cuti Khusus') {
            $this->lama_cuti = 'Sehari';
            $this->pilihan = '';
        }
    }

    #[Title('Tambah Data Cuti')]
    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.data-input.izin-cuti.create');
    }
}
