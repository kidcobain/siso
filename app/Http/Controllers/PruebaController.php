<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PruebaController extends Controller
{
    //

    public function prueba(Request $request)
    {
        

        
        return view('pruebatabla',[
            'request' => $request
        ]);
    }
}
