<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    protected $table = 'pegawai';
    protected $primaryKey = 'id_pegawai';

    protected $fillable = [
        'nip',
        'nama',
        'unit_kerja',
        'no_whatsapp',
        'mitra_id',
        'status',
    ];
}
