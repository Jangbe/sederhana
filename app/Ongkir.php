<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ongkir extends Model
{
    protected $fillable = ['kec', 'desa', 'kampung', 'harga'];
}
