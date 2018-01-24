<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
    protected $table = 'inventario';
    //
    public function Proyeccion()
    {
        //return $this->hasMany(proyeccion::class, 'lote_id', 'id');
        //return $this->hasMany(proyeccion::class);
        return $this->belongsTo(Proyeccion::class, 'proyeccion_id', 'id');
    }

    protected $fillable = [
        'id','tipo','g95','g91','dsl','proyeccion_id', 'fecha_entrada' ];

}
