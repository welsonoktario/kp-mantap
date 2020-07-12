<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    public function dompet()
    {
        return $this->belongsTo('App\Models\Dompet');
    }

    public function kategori()
    {
        return $this->belongsToMany('App\Models\Kategori', 'kategori_transaksis');
    }

    public function kegiatan()
    {
        return $this->belongsToMany('App\Models\Kegiatan', 'kegiatan_transaksis');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
