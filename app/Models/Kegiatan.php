<?php

namespace App\Models;

use Alexmg86\LaravelSubQuery\Traits\LaravelSubQueryTrait;
use Illuminate\Database\Eloquent\Model;

class Kegiatan extends Model
{
    use LaravelSubQueryTrait;

    public function transaksi()
    {
        return $this->belongsToMany('App\Models\Transaksi', 'kegiatan_transaksis');
    }
}
