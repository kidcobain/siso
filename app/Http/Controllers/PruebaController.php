<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Lote;
use App\Proyeccion;
use App\Inventario;
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

    //$pro = App\Proyeccion::all()->sortBy('fecha_entrada')->last()
    //$pro->inventario()->where('tipo','final')->get()


    public function nuevaproyeccion(Request $request)
    {

            $pro = Proyeccion::all()->sortBy('fecha_entrada')->last();
            $final = $pro->inventario()->where('tipo','final')->get()->first();

            // dd($final);

            $fecha = Carbon::createFromFormat('d/m/Y', $request->fecha)->toDateString();
            $pro = Proyeccion::create([
                'fecha_entrada' => $fecha,
            ]);
            $elid =$pro->id;
                

             Inventario::create([

                'tipo' => 'reposicion',

                 'g95' => 0,
                
                 'g91' => 0,
                
                 'dsl' => 0,

                 'proyeccion_id' => $pro->id,

             ]);


              Inventario::create([

                'tipo' => 'inicial',

                 'g95' => (isset($final->g95))?$final->g95:0,
                
                 'g91' => (isset($final->g91))?$final->g91:0,
                
                 'dsl' => (isset($final->dsl))?$final->dsl:0,

                 'proyeccion_id' => $pro->id,

             ]);


            Inventario::create([

                'tipo' => 'ventas',

                 'g95' => 0,
                
                 'g91' => 0,
                
                 'dsl' => 0,

                 'proyeccion_id' => $pro->id,

             ]);

              Inventario::create([

                'tipo' => 'final',

                 'g95' => (isset($final->g95))?$final->g95:0,
                 
                 'g91' => (isset($final->g91))?$final->g91:0,
                 
                 'dsl' => (isset($final->dsl))?$final->dsl:0,

                 'proyeccion_id' => $pro->id,


             ]);
                
        
              
              Inventario::create([

                'tipo' => 'autonomia',

                 'g95' => 0,
                
                 'g91' => 0,
                
                 'dsl' => 0,

                 'proyeccion_id' => $pro->id,
                

             ]);


                 
                       $informacion["respuesta"] = "agregarproyeccion";
                       $informacion["idproyeccionguardado"] = $pro->id;

                       $informacion["g95"] = (isset($final->g95))?$final->g95:0;
                       $informacion["g91"] = (isset($final->g91))?$final->g91:0;
                       $informacion["dsl"] = (isset($final->dsl))?$final->dsl:0;

                               //echo json_encode( $informacion );
                        return json_encode( $informacion );
    }

    public function buscar(Request $request)
    {
            $lotes = $this->buscarPorNumeroget($request->numero);
            return view('tabla', compact('lotes')); 
    }

    public function ultimo(Request $request)
    {
            //$lotes = $this->buscarPorNumeroget($request->numero);
            return Lote::all(['numero'])->last(); 
    }

    public function buscarfecha(Request $request)
    {   
        if ($request->fechainicio) {
            $fechainicio = Carbon::createFromFormat('d/m/Y', $request->fechainicio)->toDateString();
        }

        else{
            $fechainicio = '2010-01-01';
        }
        if ($request->fechafin) {
            $fechafin = Carbon::createFromFormat('d/m/Y', $request->fechafin)->toDateString();
        }
        
        else{
            $fechafin = Carbon::now();
        }
            //$lotes = Lote::paginate(15)->where('fecha_entrada', $fecha);
            $proyecciones = Proyeccion::whereBetween('fecha_entrada', [$fechainicio, $fechafin])->paginate(10);
            //$proyecciones = Lote::where('fecha_entrada', '>=', $fechainicio)->where('fecha_entrada', '<=', $fechafin)->paginate(10);
            return view('tabla')->with('proyecciones',$proyecciones)->with('exito','Mostrando proyecciones desde: '.$request->fechainicio.' hasta: '.$request->fechafin); 
    }
    public function mostrarlotes(Request $request)
    {
        //return Proyeccion::find($request->id)->lotes()->get();
        return Proyeccion::find($request->id)->lote()
        ->select('id','proyeccion_id', 'numero','tipo','cantidad','hora')
        ->get();
    }

    public function buscarPorNumero($numero)
    {
    	return Lote::where("numero", $numero)->first();
    }

     public function buscarPorNumeroget($numero)
    {
        return Lote::where("numero", $numero)->get();
    }

    public function eliminarlote(Request $request)
    {
        Lote::find($request->idlote)->delete();
        $informacion["lote"]      = $request->idlote;
        $informacion["respuesta"] = "eliminarlote";
        return json_encode( $informacion );
    }

    public function eliminar($numero)
    {
    	//Lote::destroy( ($request->numero) );
    	//$data = 
        //$this->buscarPorNumero($numero)->delete();
    	Proyeccion::find($numero)->delete();
        $informacion["lote"]      = $numero;
        $informacion["respuesta"] = "eliminarlote";
                //json_encode( $informacion );
        return redirect()->back()->withSuccess($informacion);
    	//return redirect()->back()->withSuccess('Se han eliminado los datos satisfactoriamente');
    }

    public function reposicionactualizar(Request $request)
    {
       $informacion = [];
    
       $lote = Lote::find($request->idlote);
       $lote->cantidad = $request->numero;
        $lote->save();

       $informacion["oldlote"]   = $request->idlote;
       $informacion["lote"]      = $request->numero;
       $informacion["respuesta"] = "reposicion actualizar";
        return json_encode( $informacion );
    }
     public function guardarlote(Request $request)
     {
        $informacion = [];
     	
 		if($request->idlote != "vacio")
 		{
            $valor = $request->numero .'-'. $request->tipo;

            $lote = Lote::find($request->idlote);
            $lote->numero = $request->numero;
 			$lote->tipo = $request->tipo;
 			$lote->save();
            $informacion["oldlote"]   = $request->idlote;
            $informacion["lote"]      = $valor;
            $informacion["respuesta"] = "actualizarLote";
                    //echo json_encode( $informacion );
 			return json_encode( $informacion );
 		}
        else{

            $loteguardado = Lote::create([
                'numero' => $request->numero,
                'tipo' => $request->tipo,
                'hora' => $request->hora,
                'cantidad' => 0,
                'proyeccion_id' => $request->idproyeccion,
            ]);
            $elid =$loteguardado->id;

            $informacion["respuesta"] = "agregarLote";
            $informacion["idloteguardado"] = $elid;
             return json_encode( $informacion );

        }

        
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