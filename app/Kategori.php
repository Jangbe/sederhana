<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table = 'kategori';
    protected $fillable = ['nama_kategori', 'slug', 'detail'];

    public static function getKategori(){
        return Kategori::all();
    }

    public static function getDetail($id){
        return Kategori::where('id', $id)->first();
    }

    public static function updateKategori($data){
        Kategori::where('id', $data->id)->update(['nama_kategori' => $data->nama, 'slug' => $data->slug]);
    }
}

