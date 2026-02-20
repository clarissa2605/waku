<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Mitra;

class KelompokMitra extends Model
{
    protected $table = 'kelompok_mitra';
    protected $primaryKey = 'id_kelompok';

    protected $fillable = [
        'nama_kelompok',
        'nama_kegiatan',
        'tahun',
        'keterangan'
    ];

    /**
     * 🔗 RELATIONSHIP
     * Kelompok punya banyak mitra
     */
    public function mitra()
    {
        return $this->belongsToMany(
            Mitra::class,
            'kelompok_mitra_detail',
            'kelompok_id',
            'mitra_id',
            'id_kelompok',
            'id_mitra'
        )->withTimestamps();
    }
}