<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PencairanDanaMitra extends Model
{
    protected $table = 'pencairan_dana_mitra';
    protected $primaryKey = 'id_pencairan';

    protected $fillable = [
        'mitra_id',
        'kelompok_id',
        'jenis_dana',
        'nominal',
        'potongan',
        'nominal_bersih',
        'tanggal',
        'nama_bank',
        'nama_rekening',
        'no_rekening',
        'keterangan',
        'status_notifikasi',
    ];

    public function mitra()
    {
        return $this->belongsTo(Mitra::class, 'mitra_id', 'id_mitra');
    }
}