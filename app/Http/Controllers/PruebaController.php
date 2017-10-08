<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Lote;
use App\proyeccion;

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
     	if($request->colfila=='nombrelote')
     	{ 

            
     		if(count($this->buscarPorNumero($request->oldidfila))>0)
     		{
     			$lote = $this->buscarPorNumero($request->oldidfila);
     			$lote->numero = $request->idfila;
     			$lote->save();
     			return 'actualizado';
     		}
            
     		 //$this->buscarPorNumero($request->oldidfila);
     		$ident = Lote::create([
     		    'numero' => $request->idfila,
     		    'tipo' => 'tipo',
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


     		     

     		 return 'nuevo';
     		 
     	}

     	else
     	{

            /*
            $lote = $this->buscarPorNumero($request->idfila);
            //$lote->numero = $request->idfila;
            $jaja = proyeccion::where("lote_id", $lote->id)->first();


                $lote->save();
                return 'actualizado';
                */

     	}
     }

}
