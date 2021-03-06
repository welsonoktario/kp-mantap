<?php

namespace App\Models;

use Alexmg86\LaravelSubQuery\Traits\LaravelSubQueryTrait;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use LaravelSubQueryTrait;

    public function transaksi()
    {
        return $this->belongsToMany('App\Models\Transaksi', 'kategori_transaksis', 'kategori_id', 'transaksi_id');
    }
}
