<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lote extends Model
{
    protected $table = 'lote';
    //

    public function Proyeccion()
    {
        //return $this->hasMany(proyeccion::class, 'lote_id', 'id');
        //return $this->hasMany(proyeccion::class);
        return $this->belongsTo(Proyeccion::class, 'proyeccion_id', 'id');
    }
    
    protected $fillable = [
        'id','numero','tipo','fecha_entrada','hora', 'proyeccion_id', 'cantidad' ];

}
