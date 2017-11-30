@extends('layouts.app')
{{-- \Debugbar::disable() --}}
@section('content')
<link rel="stylesheet" href="/css/sweetalert2.css">
<link rel="stylesheet" href="/css/tablestyle.css">
<div class="container" style=" width: unset;">
        {{-- dd(session('success')['lote']) --}}
    
    
    
     
    <div class="row">
        <div class="mensaje " style="height: 80px">
        </div>
        
    </div>
    <div class="row">
     <div class="col-md-8 col-md-offset-2">
         <div class="panel panel-default panelbusqueda">

            <div class="panel-heading">busqueda</div>

            <div class="panel-body">
                <div class="buscarnumero">
                    <form action="/buscarlote" method="get">
                        <label for="numero">buscar por numero de lote</label>
                        <input name="numero" type="text" class="busqueda numero">
                        <input type="submit" value="buscar">
                    </form>
                </div>
                <div class="buscarfecha">
                    <form action="/buscarlotefecha" method="get">
                        <p>buscar por fecha</p>
                        <label for="fechainicio">desde</label>
                        <input name="fechainicio" type="text" class="busqueda fecha">

                        <label for="fechafin">hasta</label>
                        <input name="fechafin" type="text" class="busqueda fecha">

                        <input type="submit" value="buscar">
                    </form>
                </div>
         </div>
      </div>  
    </div>
    <div class="row">
        <div class="col-md-8 col-md-offset-2"">
                @if (!empty($exito))
                <div class="alert alert-success alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button> 
                        <strong>{{ $exito }}</strong>
                </div>
                @endif
            <div class="panel panel-default">
                <div class="panel-heading">proyeccion -> <a href="javascript:window.print()">imprimir</a></div>
                <div class="panel-body">
                        <table class="latabla table table-bordered table-striped table-responsive table-hover">
                            <thead>
                                <tr>
                                    <th colspan="1" class="lote">lote</th>
                                    <th colspan="1" class="fecha">fecha</th>
                                    <th colspan="3" class="reposicion">Reposicion por poliducto</th>
                                    <th colspan="3" class="inicial">Inventario inicial</th>
                                    <th colspan="3" class="ventas">ventas</th>
                                    <th colspan="3" class="final">Inventario final</th>
                                    <th colspan="3" class="autonomia">Autonomia</th>
                                    <th colspan="1" class="accion">accion</th>
                                </tr>
                                <tr>
                                    <th class="lote"></th>
                                    <th class="fecha"></th>

                                    <th class="reposicion">G95</th>
                                    <th class="reposicion">G91</th>
                                    <th class="reposicion">DSL</th>
                                    
                                    <th class="inicial">G95</th> 
                                    <th class="inicial">G91</th> 
                                    <th class="inicial">DSL</th>
                                    
                                    <th class="ventas">G95</th> 
                                    <th class="ventas">G91</th> 
                                    <th class="ventas">DSL</th>
                                    
                                    <th class="final">G95</th> 
                                    <th class="final">G91</th> 
                                    <th class="final">DSL</th>
                                    
                                    <th class="autonomia">G95</th> 
                                    <th class="autonomia">G91</th> 
                                    <th class="autonomia">DSL</th>
                                    
                                    <th class="accion"></th>
                                </tr>
                            </thead>
                            @if(count($lotes)>=1)
                                <tbody>
                                    <tr class="desplegable">
                                        <td colspan="6">
                                            
                                            <tr class="datosdesplegable" id="123-kjh">
                                                <td class="nombrelote">123-kjh</td>
                                                <td class="hora">06:05 pm</td>
                                                <td class="reposicion g95">
                                                    12
                                                </td>
                                                <td class="reposicion g91">
                                                    5
                                                </td>
                                                <td class="reposicion dsl">
                                                    0
                                                </td>
                                                <td colspan="2"><input type="button" value="eliminar lote" class="eliminarlotedesplegable"></td>
                                            </tr>

                                            <tr>
                                                <td><input type="button" value="agregar lote" class="agregarlotedesplegable"></td>
                                            </tr>

                                        </td>
                                    </tr>
                                
                                @foreach ($lotes as $lote)           
                                    <tr class="datos" id="{{ $lote->numero}}">
                                        <td class="nombrelote">{{ $lote->numero}}</td>
                                        <td class="fecha">
                                            {{-- \Carbon\Carbon::createFromFormat('d/m/Y', $lote->fecha_entrada) --}}

                                                {{-- (Carbon::createFromFormat('d/m/Y', $lote->fecha_entrada)?$lote->fecha_entrada:'00/00/0000' --}}

                                                {{-- ($lote->fecha_entrada)?$lote->fecha_entrada:'00/00/0000' --}}
                                                @php 
                                                $date = new DateTime($lote->fecha_entrada);
                                                $fecha = date_format($date, 'd/m/Y');
                                                @endphp
                                                {{ ($fecha)?$fecha :'00/00/0000' }}

                                                


                                        </td>

                                        @foreach($lote->proyeccion as $pro)
                                         {{-- $proyection = collect($pro)--}}

                                          @php
                                            $proreposicion = 0;
                                            $proreposicion = $pro::where('lote_id', $lote->id)
                                              ->where('tipo','reposicion')->firstorfail();

                                            $proinicial = 0;
                                            $proinicial = $pro::where('lote_id', $lote->id)
                                              ->where('tipo','inicial')->firstorfail();

                                            $proventas = 0;
                                            $proventas = $pro::where('lote_id', $lote->id)
                                              ->where('tipo','ventas')->firstorfail();

                                            $profinal = 0;
                                            $profinal = $pro::where('lote_id', $lote->id)
                                              ->where('tipo','final')->firstorfail();

                                            $proautonomia = 0;
                                            $proautonomia = $pro::where('lote_id', $lote->id)
                                              ->where('tipo','autonomia')->firstorfail();

                                          @endphp

                                        <td class="reposicion g95">
                                            {{ $proreposicion->g95 }}
                                        </td>
                                        <td class="reposicion g91">
                                            {{ $proreposicion->g91 }}
                                        </td>
                                        <td class="reposicion dsl">
                                            {{ $proreposicion->dsl }}
                                        </td>

                                        <td class="inicial g95">
                                            {{ $proinicial->g95 }}
                                        </td>
                                        <td class="inicial g91">
                                            {{ $proinicial->g91 }}
                                        </td>
                                        <td class="inicial dsl">
                                            {{ $proinicial->dsl }}
                                        </td>
                                        
                                        <td class="ventas g95">
                                            {{ $proventas->g95 }}
                                        </td>
                                        <td class="ventas g91">
                                            {{ $proventas->g91 }}
                                        </td>
                                        <td class="ventas dsl">
                                            {{ $proventas->dsl }}
                                        </td>

                                        <td class="final g95">
                                            {{ $profinal->g95 }}
                                        </td>
                                        <td class="final g91">
                                            {{ $profinal->g91 }}
                                        </td>
                                        <td class="final dsl">
                                            {{ $profinal->dsl }}
                                        </td>

                                        <td class="autonomia g95">
                                            {{ $proautonomia->g95 }}
                                        </td>
                                        <td class="autonomia g91">
                                            {{ $proautonomia->g91 }}
                                        </td>
                                        <td class="autonomia dsl">
                                            {{ $proautonomia->dsl }}
                                        </td>

                                        <td class="accion">
                                            @can('eliminar_lotes')
                                            <a href="/fila/{{ $lote->numero}}/eliminar"> 
                                                <button type="button" class="btn btn-danger">Eliminar</button>
                                            </a>
                                            @endcan
                                        </td>
                                        @break
                                        @endforeach
                                    </tr>
                                @endforeach
                                    </tbody>
                                    @else
                                        
                                    </table>
                                    <div class="sinregistros">
                                        <p> Por los momentos no existen proyecciones registradas en el sistema </p>
                                    </div>
                                              
                                    @endif
                                </table>
                                    @if(method_exists($lotes,'links'))
                                        {{$lotes->links()}}
                                    @endif

                        <p></p>
                        @can('agregar_lotes')
                           <input type="button" class="agregar btn btn-info" value="agregar nueva fila">
                        @endcan
    <!-- /body -->
                    <link href="css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css">



                </div>
            </div>
        </div>
    </div>
</div>
<script src="js/bootstrap-datepicker.js"></script>
<script src="js/jquery-ui.min.js"></script>
<script src="js/bootstrap-datepicker.es.min.js" type="text/javascript"></script>
<script src="js/sweetalert2.all.min.js"></script>
<script src="js/jquery.maskedinput.min.js" type="text/javascript"></script>
<script>
    var elhtml = ' \
            <tr class="datos " id="">  \
                <td class="nombrelote"><input class="editando" type="text" size="5"/></td> \
                <td class="fecha">00/00/000</td> \
 \
                <td class="reposicion g95">0</td> \
                <td class="reposicion g91">0</td> \
                <td class="reposicion dsl">0</td> \
 \
                <td class="inicial g95">0</td> \
                <td class="inicial g91">0</td> \
                <td class="inicial dsl">0</td> \
 \
                <td class="ventas g95">0</td> \
                <td class="ventas g91">0</td> \
                <td class="ventas dsl">0</td> \
 \
                <td class="final g95">0</td> \
                <td class="final g91">0</td> \
                <td class="final dsl">0</td> \
 \
                <td class="autonomia g95">0</td> \
                <td class="autonomia g91">0</td> \
                <td class="autonomia dsl">0</td> \
                <td class="accion"><a href="/eliminarfila/"><button type="button" class="btn btn-danger">Eliminar</button></a></td> \
            </tr> \
        ';

var filadesplegable = '\
                        <tr class="datos" id="123-kjh">\
                            <td class="nombrelote">123-kjh</td>\
                            <td class="hora">06:05 pm</td>\
                            <td class="reposicion g95">\
                                12\
                            </td>\
                            <td class="reposicion g91">\
                                5\
                            </td>\
                            <td class="reposicion dsl">\
                                0\
                            </td>\
                            <td colspan="2"><input type="button" value="eliminar lote" class="eliminarlotedesplegable"></td>\
                        </tr>\
                        ';

$(document).ready(function() {
    $('.agregarlotedesplegable').click(function(event) {
       $('.datosdesplegable').after(filadesplegable);
       //$('.desplegable ').append(filadesplegable);
    });
    var editarCelda = function () {

          var texto = $(this).text();
        if(!$(this).hasClass('accion')){

       

            if($(this).hasClass('nombrelote')){
                $(this).html('<input class="editando" type="text" size="5" value="'+texto+'">');
                $(this).attr('id',texto);

            }
            else if($(this).hasClass('fecha')){
                $(this).html('<input class="editando datepicker-here" data-language="es" type="text">');

            }
            else if($(this).hasClass('autonomia')){
               return;

            }
            else if($(this).hasClass('final')){
               return;

            }
            else{

                $(this).html('<input class="editando" type="number" size="3" max="300" min="0" value="'+parseInt(texto)+'">');
            }
        var $el = $(this).find('input');

            $el.focus();
            $el.click(function(event){
                event.stopPropagation();
            });
            $('.latabla').off('click','td');
        $('.agregar').off('click');

        
        $('.fecha > .editando').datepicker({
            format: "dd/mm/yyyy",
            endDate: "0d",
            maxViewMode: 3,
            todayBtn: "linked",
            clearBtn: true,
            language: "es",
            autoclose: false
        });

        
        
        
        $el.focus();
        $el.trigger('click');
        }
    };

    var agregarFila = function () {

        if($('.sinregistros')){$('.sinregistros').html('')};

        $('.latabla tr:last').after(elhtml);
        $('.latabla tr:last').css('background-color', 'gray');
        $('.agregar').off('click');
        $('.latabla').off('click','td');

        var el = $('.editando');

        el.click(function(event){
            event.stopPropagation();
        });
        el.focus();

    };

    var guardarDatoCelda = function () {
        ////console.log(texto);
        var $el = $('.editando');

        var valor = $el.val();
        //console.log(valor);

        var idfila = 0;
        var colfila = 0;
        var tipofila = 0;

         var clases = $('.editando').parent().attr("class").split(' ');
          var anterior = $(this).parent().attr('id');

         colfila = clases[0] || 0;
         tipofila = clases[1] || 0;

        
        
        trow = $el.parent().parent();

        if($el.parent().hasClass('nombrelote')){
            trow.attr('id', valor)
            trow.find('.accion > a').attr('href', '/fila/'+valor+'/eliminar');
        }
        idfila = trow.attr('id');
        //console.log(idfila);

        if (!valor || valor == "" ) {
            if($el.parent().hasClass('nombrelote')){

                $(this).parent().parent().css('background-color', 'gray');
            }
            valor = 0;
        }
        else{

            var decimales = (colfila=='inicial')? 2 : 1;
            if (colfila == 'reposicion'){
                valor = parseInt(valor);
            }
            else if (colfila == 'reposicion' || colfila == 'inicial' || colfila == 'ventas')
            {
                valor = parseFloat(valor,decimales).toFixed(decimales);
            }

            $el.parent().text(valor);
            trow.css('background-color', '');
            $('.latabla').on('click','td', editarCelda);
            $('.agregar').on('click',agregarFila);


            //formulas
            //parseFloat(s,radix);
            //$('.final.g95').effect('highlight',{},1000); 

            var reposicionval = parseInt($('[id=\"'+idfila+'\"] .reposicion.'+clases[1]).text());
            var inicialval    = parseFloat($('[id=\"'+idfila+'\"] .inicial.'+clases[1]).text(),2);
            //inicialval    = inicialval.toFixed(2);
            var ventasval     = parseFloat($('[id=\"'+idfila+'\"] .ventas.'+clases[1]).text(),1);
            //ventasval = ventasval.toFixed(1);

            var final = (reposicionval + inicialval) - ventasval;
            final = final.toFixed(1);

            $('[id=\"'+idfila+'\"] .final.'+clases[1]).text(final).effect('highlight',{},1000);

            if(final != 0 ){
                var autotipo = [];
                autotipo['g95'] = 1.8;
                autotipo['g91'] = 2.8;
                autotipo['dsl'] = 1.2;
                var autonomia = final / autotipo[clases[1]];
                //autonomia = autonomia.toFixed(2);
                autonomia = Math.round(autonomia);
                //console.log('autonomia: '+autonomia);
                $('[id=\"'+idfila+'\"] .autonomia.'+clases[1]).text(autonomia).effect('highlight',{},1000);
            }




           

            var texto = anterior || valor;



            $.ajax({
                        type: 'get',
                        url: '/poliducto',
                        data: {
                            valor:valor,

                            idfila    : idfila,
                            oldidfila : texto,
                            colfila   : colfila,
                            tipofila  : tipofila,
                            lote_id   : idfila,
                            final     : final,
                            autonomia : autonomia


                        },
                        
                        dataType: 'json',
                        complete: function(){ 
                        },

                        success: function(data){
                            mostrarMensaje(data);
                        }
                    });


                
        }
        
    };
//role('admin|avanzado')
@can('editar_lotes')

                            //$('.latabla ').on('click','td', editarCelda);
                            
@endcan

@can('agregar_lotes')   
                                    
                            $('.agregar').on('click',agregarFila);
@endcan

@can(['agregar_lotes','agregar_lotes'])  

                            $('.latabla').on('blur','.editando', guardarDatoCelda);

@endcan
                           
                            

                                $('.latabla').on('click','.accion > a', function(e){
                                    e.preventDefault();
                                    var $_this = $(this);

                                  swal({
                                    title: 'Confirmación',
                                    text: "¿Desea borrar la fila?",
                                    type: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: '#3085d6',
                                    cancelButtonColor: '#d33',
                                    confirmButtonText: 'Si, borrar',
                                    cancelButtonText: 'No, cancelar!',
                                    confirmButtonClass: 'btn btn-success',
                                    cancelButtonClass: 'btn btn-danger',
                                    buttonsStyling: false
                                  }).then(function () {
                                    swal(
                                      'Borrado!',
                                      'La fila fue borrada',
                                      'success'
                                    )
                                     $lnk = $_this.attr('href');
                                     window.location = $lnk;
                                  }, function (dismiss) {
                                    if (dismiss === 'cancel') {
                                      swal(
                                        'Cancelado',
                                        'No se ha borrado la fila',
                                        'error'
                                      )
                                    }
                                  })
                                })


var mostrarMensaje = function(informacion){
            var html = "";
            if( informacion.respuesta == "actualizarLote" )    html = "<div class='alert alert-success col-sm-offset-2 col-sm-8'><strong>Exito!</strong>, se ha actualizado el lote numero "+informacion.oldlote+" a "+informacion.lote+"</div>";
            else if( informacion.respuesta == "agregarLote" )   html = "<div class='alert alert-info col-sm-offset-2 col-sm-8'><strong>Exito!</strong>, se ha registrado un nuevo lote</div>";
            else if( informacion.respuesta == "actualizardata" )   html = "<div class='alert alert-info col-sm-offset-2 col-sm-8'><strong>Exito!</strong>, se ha actualizado el campo "+informacion.tipo+" de "+informacion.columna+"del lote "+informacion.lote+"</div>";
            else if( informacion.respuesta == "eliminarlote" )   html = "<div class='alert alert-info col-sm-offset-2 col-sm-8'><strong>Exito!</strong>, se ha eliminate el lote "+informacion.lote+"</div>";
                //console.log(informacion);


            $(".mensaje").html( html );
            $(".mensaje").fadeOut(12000, function(){
                    $(this).html("");
                    $(this).fadeIn(3000);
            });         
        }


$('.busqueda.fecha').datepicker({
            format: "dd/mm/yyyy",
            endDate: "0d",
            maxViewMode: 3,
            todayBtn: "linked",
            clearBtn: true,
            language: "es",
            autoclose: true,
        });

      

    @if (session('success'))
         var variable = {!! json_encode(session('success')) !!};
         mostrarMensaje(variable);
     
    @endif                         
                        
});
                        </script>
@endsection
