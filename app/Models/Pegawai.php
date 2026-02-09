<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

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

    // 🔗 RELATIONSHIP: Pegawai punya satu akun login
    public function user()
    {
        return $this->hasOne(User::class, 'pegawai_id', 'id_pegawai');
    }
}
