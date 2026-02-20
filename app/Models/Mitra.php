<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\KelompokMitra;

class Mitra extends Model
{
    protected $table = 'mitra';
    protected $primaryKey = 'id_mitra';

    protected $fillable = [
        'nik',
        'nama_mitra',
        'no_whatsapp',
        'alamat',
        'nama_bank',
        'nama_rekening',
        'no_rekening',
        'jenis_mitra',
        'tanggal_mulai_kontrak',
        'tanggal_selesai_kontrak',
        'keterangan',
        'status'
    ];

    /**
     * 🔗 RELATIONSHIP
     * Mitra bisa ikut banyak kelompok
     */
    public function kelompok()
    {
        return $this->belongsToMany(
            KelompokMitra::class,
            'kelompok_mitra_detail',
            'mitra_id',
            'kelompok_id',
            'id_mitra',
            'id_kelompok'
        )->withTimestamps();
    }
}