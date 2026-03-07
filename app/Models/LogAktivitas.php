<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class LogAktivitas extends Model
{
    protected $table = 'log_aktivitas';

    protected $fillable = [
        'user_id',
        'nama_user',
        'aktivitas',
        'modul',
        'detail',
        'ip_address',
        'user_agent'
    ];

    /**
     * Relasi ke user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}