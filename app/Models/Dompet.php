<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dompet extends Model
{
    public function transaksi()
    {
        return $this->hasMany('App\Models\Transaksi');
    }
}
