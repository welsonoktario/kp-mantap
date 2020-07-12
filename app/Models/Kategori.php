<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    public function transaksi()
    {
        return $this->hasMany('App\Models\Transaksi', 'kategori_transaksis');
    }
}
