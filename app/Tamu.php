<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tamu extends Model
{
    protected $guarded = [];
    public function pegawai(){
        // return $this->belongsTo(TblPegawai::class);
        return $this->belongsTo('App\Category','id_pegawai','id');
    }
}
