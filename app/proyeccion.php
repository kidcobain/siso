<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proyeccion extends Model
{
    protected $table = 'proyeccion';
    //
    public function Lote()
    {
        //return $this->belongsTo(Lote::class, 'lote_id', 'id');
        //return $this->hasMany(Lote::class, 'proyeccion_id', 'id');
        return $this->hasMany(Lote::class);
    }

    public function Inventario()
    {
        //return $this->belongsTo(Lote::class, 'lote_id', 'id');
        //return $this->hasMany(Lote::class, 'proyeccion_id', 'id');
        return $this->hasMany(Inventario::class);
    }

    protected $fillable = [
        'id','fecha_entrada' ];

}