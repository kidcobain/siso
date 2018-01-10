<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Lote;
use App\proyeccion;
use \Carbon\Carbon ;

class PruebaController extends Controller
{
    //

    public function aprueba(Request $request)
    {
        

        
        return view('pruebatabla',[
            'request' => $request
        ]);
    }



    public function buscar(Request $request)
    {
            $lotes = $this->buscarPorNumeroget($request->numero);
            return view('tabla', compact('lotes')); 
    }

    public function buscarfecha(Request $request)
    {   
        if ($request->fechainicio) {
            $fechainicio = Carbon::createFromFormat('d/m/Y', $request->fechainicio)->toDateString();
        }

        else{
            $fechainicio = '';
        }
        if ($request->fechafin) {
            $fechafin = Carbon::createFromFormat('d/m/Y', $request->fechafin)->toDateString();
        }
        
        else{
            $fechafin = '';
        }
            //$lotes = Lote::paginate(15)->where('fecha_entrada', $fecha);
            $lotes = Lote::whereBetween('fecha_entrada', [$fechainicio, $fechafin])->paginate(10);
            //$lotes = Lote::where('fecha_entrada', '>=', $fechainicio)->where('fecha_entrada', '<=', $fechafin)->paginate(10);
            return view('tabla')->with('lotes',$lotes)->with('exito','Mostrando lotes desde: '.$request->fechainicio.' hasta: '.$request->fechafin); 
    }
    public function mostrarlotes(Request $request)
    {
        //return Proyeccion::find($request->id)->lotes()->get();
        return Proyeccion::find($request->id)->lote()->get();
    }

    public function buscarPorNumero($numero)
    {
    	return Lote::where("numero", $numero)->first();
    }

     public function buscarPorNumeroget($numero)
    {
        return Lote::where("numero", $numero)->get();
    }

    public function eliminar($numero)
    {
    	//Lote::destroy( ($request->numero) );
    	//$data = 
    	$this->buscarPorNumero($numero)->delete();
        $informacion["lote"]      = $numero;
        $informacion["respuesta"] = "eliminarlote";
                //json_encode( $informacion );
        return redirect()->back()->withSuccess($informacion);
    	//return redirect()->back()->withSuccess('Se han eliminado los datos satisfactoriamente');
    }

    
     public function guardar(Request $request)
     {
        $informacion = [];
     	if($request->colfila=='nombrelote')
        { 

     		if(count($this->buscarPorNumero($request->oldidfila))>0)
     		{
     			$lote = $this->buscarPorNumero($request->oldidfila);
     			$lote->numero = $request->idfila;
     			$lote->save();
                $informacion["oldlote"]   = $request->oldidfila;
                $informacion["lote"]      = $request->idfila;
                $informacion["respuesta"] = "actualizarLote";
                        //echo json_encode( $informacion );
     			return json_encode( $informacion );
     		}
        
        

            else{

                
                 //$this->buscarPorNumero($request->oldidfila);
                    $fecha = Carbon::now();
                    //$fecha = DateTime::createFromFormat('d-m-Y');
                $ident = Lote::create([
                    'numero' => $request->idfila,
                    'tipo' => 'tipo',
                    'fecha_entrada' => $fecha,
                ]);
                $elid =$ident->id;
                    

                 proyeccion::create([

                    'tipo' => 'reposicion',

                     'g95' => 0,
                    
                     'g91' => 0,
                    
                     'dsl' => 0,

                     'lote_id' => $ident->id,

                 ]);

                  proyeccion::create([

                    'tipo' => 'inicial',

                     'g95' => 0,
                    
                     'g91' => 0,
                    
                     'dsl' => 0,

                     'lote_id' => $ident->id,

                 ]);

                proyeccion::create([

                    'tipo' => 'ventas',

                     'g95' => 0,
                    
                     'g91' => 0,
                    
                     'dsl' => 0,

                     'lote_id' => $ident->id,

                 ]);

                  proyeccion::create([

                    'tipo' => 'final',

                     'g95' => 0,
                    
                     'g91' => 0,
                    
                     'dsl' => 0,

                     'lote_id' => $ident->id,


                 ]);
                  
                  proyeccion::create([

                    'tipo' => 'autonomia',

                     'g95' => 0,
                    
                     'g91' => 0,
                    
                     'dsl' => 0,

                     'lote_id' => $ident->id,
                    

                 ]);


                     
                           $informacion["respuesta"] = "agregarLote";
                                   //echo json_encode( $informacion );
                            return json_encode( $informacion );
                 //return 'nuevo';
                }
             
        }

        else if($request->colfila==='fecha'){
               $lote = $this->buscarPorNumero($request->idfila);
                //$lote->numero = $request->idfila;
               $fecha = Carbon::createFromFormat('d/m/Y', $request->valor);
               //$date = new DateTime($request->valor);
                //$fecha = date_format($date, 'Y-m-d');
               //$fecha = date_format($request->valor, 'Y-m-d');
               //$fecha = Carbon::createFromFormat('Y/m/d', $request->valor);
               //$fecha = Carbon::createFromFormat('Y-m-d',$request->valor )->toDateTimeString();
                $lote->fecha_entrada = $fecha;
                $lote->save();
                $informacion["oldlote"]    = $request->oldidfila;
                $informacion["fechanueva"] = $request->valor;
                $informacion["lote"]       = $request->idfila;
                $informacion["respuesta"]  = "actualizarLote";
                        //echo json_encode( $informacion );
                return json_encode( $informacion ); 

            }

        else
        {

             $tipo = $request->colfila;

            
            $lote = $this->buscarPorNumero($request->idfila);
            //$lote->numero = $request->idfila;
            //$jaja = proyeccion::where("lote_id", $lote->id)->first();
            //App\Lote::with('proyeccion')->first()->proyeccion->where('tipo','inicial');
            // App\Lote::first()->proyeccion->where('tipo','inicial')
            //App\Lote::where('numero','123434')->first()->proyeccion->where('tipo','inicial')
            $tipofila = $request->tipofila;
            
            $final = $lote->proyeccion->where('tipo','final');
            $final->first()->update([$tipofila => $request->final]);

            $autonomia = $lote->proyeccion->where('tipo','autonomia');
            $autonomia->first()->update([$tipofila => $request->autonomia]);


            $columna = $lote->proyeccion->where('tipo',$tipo);
            //dd($request->valor);
            //var_dump($columna);
            $valor = $request->valor;
            //$columna->first()->$tipofila = $valor;
            $columna->first()->update([$tipofila => $valor]);
            //$columna->first()->$request->tipofila = $request->valor;


                //$lote->save();
                $informacion["columna"]   = $tipo;
                $informacion["tipo"]      = $request->tipofila;
                $informacion["lote"]      = $request->idfila;
                $informacion["respuesta"] = "actualizardata";
                        //echo json_encode( $informacion );
                return json_encode( $informacion );
                //return 'actualizado valor';
                

     	}
     }

}
/*
[
    {
        "id": 1,
        "numero": "1",
        "tipo": "g91",
        "cantidad": "4",
        "fecha_entrada": "2018-01-02",
        "hora": "08:07 am",

        "proyeccion_id": 1,
        "created_at": null,
        "updated_at": null,
        "deleted_at": null 
    },
    
    {
        "id": 2,
        "numero": "2",
        "tipo": "g95",
        "cantidad": "8",
        "fecha_entrada": "2018-01-04",
        "hora": "09:08 am",

        "proyeccion_id": 1,
        "created_at": null,
        "updated_at": null,
        "deleted_at": null 
    }
]

$.each(json, function(i, item) {
    console.log(json[i].tipo);
});

for(var i in json){
    console.log(json[i].tipo);
}
*/