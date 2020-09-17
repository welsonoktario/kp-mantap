<?php

namespace App\Models;

use Alexmg86\LaravelSubQuery\Traits\LaravelSubQueryTrait;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use LaravelSubQueryTrait;

    protected $hidden = ['created_at', 'updated_at'];

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

    public function pics()
    {
        return $this->belongsToMany('App\Models\User', 'user_transaksis');
    }
}
