<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lote extends Model
{
    protected $table = 'lote';
    //

    public function proyeccion()
    {
        //return $this->hasMany(proyeccion::class, 'lote_id', 'id');
        return $this->hasMany(proyeccion::class);
    }
    protected $fillable = [
        'numero','tipo','fecha_entrada','hora', 'proyeccion_id' ];

}
