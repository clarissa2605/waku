<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogPencairan extends Model
{
    protected $table = 'log_pencairan';
    protected $primaryKey = 'id_log';

    protected $fillable = [
        'id_pencairan',
        'pegawai_id',
        'aksi',
        'deskripsi',
    ];

    public function pencairan()
    {
        return $this->belongsTo(PencairanDana::class, 'id_pencairan', 'id_pencairan');
    }

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'pegawai_id', 'id_pegawai');
    }
}
