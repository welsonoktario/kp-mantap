<?php

namespace App\Models;

use Alexmg86\LaravelSubQuery\Traits\LaravelSubQueryTrait;
use Illuminate\Database\Eloquent\Model;

class Dompet extends Model
{
    use LaravelSubQueryTrait;

    public function transaksi()
    {
        return $this->hasMany('App\Models\Transaksi');
    }
}
