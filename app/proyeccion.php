<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class proyeccion extends Model
{
    protected $table = 'proyeccion';
    //
    public function Lote()
    {
        return $this->belongsTo(Lote::class, 'lote_id', 'id');
        //return $this->belongsTo(Lote::class, 'lote_id', 'id');
    }

    protected $fillable = [
        'tipo','g95','g91','gsl','lote_id' ];

}
