<?php

namespace App\Livewire\DataInput\IzinLembur;

use App\Models\Lembur;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\Component;

class Create extends Component
{
    #[Rule('required')]
    public $tanggal_lembur;
    #[Rule('required')]
    public $jam_mulai = '17:00';
    #[Rule('required')]
    public $jam_selesai = '18:00';
    #[Rule('required')]
    public $keterangan;

    public function mount()
    {
        $this->validate([
            'jam_selesai' => 'required|after:' . $this->jam_mulai
        ]);
    }

    public function addAction()
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


        Lembur::create([
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

        toast('Berhasil disimpan.', 'success');
        return redirect('izin-lembur');
    }

    #[Title('Izin Lembur')]
    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.data-input.izin-lembur.create');
    }
}
