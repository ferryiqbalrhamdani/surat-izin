<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lembur extends Model
{
    use HasFactory;

    protected $table = 'tb_lembur';
    protected $fillable = [
        'user_id',
        'tanggal_lembur',
        'hari_libur',
        'jam_mulai',
        'jam_akhir',
        'lama_lembur',
        'upah_lembur_perjam',
        'uang_makan',
        'upah_lembur',
        'keterangan_lembur',
        'status',
        'status_hrd',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
