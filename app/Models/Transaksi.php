<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    public function dompet()
    {
        return $this->belongsTo('App\Models\Kategori');
    }

    public function kategori()
    {
        return $this->belongsToMany('App\Models\Kategori');
    }

    public function kegiatan()
    {
        return $this->belongsToMany('App\Models\Kegiatan');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
