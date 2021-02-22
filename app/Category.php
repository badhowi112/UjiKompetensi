<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = [];
    public function tamu(){
        return $this->hasMany('App\Tamu','id_pegawai');
        // return $this->hasMany(TblTamu::class);
    }
}
