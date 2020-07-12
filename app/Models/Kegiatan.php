<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kegiatan extends Model
{
    public function transaksi()
    {
        return $this->hasMany('App\Models\Transaksi', 'kegiatan_transaksis');
    }
}
