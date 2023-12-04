<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cuti extends Model
{
    use HasFactory;

    protected $table = 'tb_cuti';
    protected $fillable = [
        'user_id',
        'keperluan_cuti',
        'pilihan',
        'durasi',
        'tanggal_cuti',
        'sampai_tanggal',
        'lama_cuti',
        'keterangan_cuti',
        'status',
        'status_hrd',
    ];
}
