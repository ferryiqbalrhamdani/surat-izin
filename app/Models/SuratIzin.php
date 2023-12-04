<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SuratIzin extends Model
{
    use HasFactory;

    protected $table = 'tb_izin';
    protected $fillable = [
        'user_id',
        'keperluan_izin',
        'lama_izin',
        'tanggal_izin',
        'sampai_tanggal',
        'durasi_izin',
        'jam_masuk',
        'jam_keluar',
        'keterangan_izin',
        'status',
        'status_hrd',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
