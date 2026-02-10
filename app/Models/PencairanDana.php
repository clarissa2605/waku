<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PencairanDana extends Model
{
    protected $table = 'pencairan_dana';
    protected $primaryKey = 'id_pencairan';

    protected $fillable = [
    'pegawai_id',
    'jenis_dana',
    'nominal',
    'potongan',
    'nominal_bersih',
    'tanggal',
    'keterangan',
    'status_notifikasi',
    ];


    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'pegawai_id', 'id_pegawai');
    }
}
