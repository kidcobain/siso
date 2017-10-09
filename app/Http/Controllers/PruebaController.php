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
            $fecha = Carbon::createFromFormat('d/m/Y', $request->fecha)->toDateString();
            $lotes = Lote::all()->where('fecha_entrada', $fecha);
            return view('tabla', compact('lotes')); 
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
    	return redirect()->back();
    }

    

    public function store(Request $request)
    {
        //dd($request);
        //dd($request->cedula);
        
        $request->validate([
            'cedula' => 'required|string|max:9|unique:personas',
          
        ]);
        
         personas::create([
            'cedula' => $request->cedula,
           
            

        ]);
         return redirect('/persona/'.$request->cedula);
     }

     public function editar(Request $request, $id)
     {
     	$solicitud = solicitudes::find($id);

     	$solicitud->lugar = $request->lugar;
     	$solicitud->tipo = $request->tipo;
     	$solicitud->solicitud = $request->solicitud;
     	$solicitud->observaciones = $request->observaciones;
     	$solicitud->fundo = $request->fundo;
     	$solicitud->persona_Cedula = $request->persona_Cedula;
     	$solicitud->funcionario_Cedula = $request->funcionario_Cedula;

     	$solicitud->save();
     	return redirect('/persona/'.$request->persona_Cedula);
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
                $informacion["oldlote"] = $request->oldidfila;
                $informacion["lote"] = $request->idfila;
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
                $informacion["oldlote"] = $request->oldidfila;
                $informacion["fechanueva"] = $request->valor;
                $informacion["lote"] = $request->idfila;
                $informacion["respuesta"] = "actualizarLote";
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
            $columna = $lote->proyeccion->where('tipo',$tipo);
            //dd($request->valor);
            //var_dump($columna);
            $tipofila = $request->tipofila;
            $valor = $request->valor;
            //$columna->first()->$tipofila = $valor;
            $columna->first()
            ->update([$tipofila => $valor]);
            //$columna->first()->$request->tipofila = $request->valor;


                //$lote->save();
                $informacion["columna"] = $tipo;
                $informacion["tipo"] = $request->tipofila;
                $informacion["lote"] = $request->idfila;
                $informacion["respuesta"] = "actualizardata";
                        //echo json_encode( $informacion );
                return json_encode( $informacion );
                //return 'actualizado valor';
                

     	}
     }

}
