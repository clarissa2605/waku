<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogNotifikasi extends Model
{
    protected $table = 'log_notifikasi';
    protected $primaryKey = 'id_log';

    protected $fillable = [
        'recipient_type',
        'recipient_id',
        'no_whatsapp',
        'pesan',
        'status',
        'response',
    ];

    public function recipient()
    {
        return $this->morphTo();
    }
}