@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="css/sweetalert2.css">
<div class="container">

    <div class="row">
        <div class="mensaje " style="height: 80px">
        </div>
    </div>
    <div class="row">
     <div class="col-md-8 col-md-offset-2">
         <div class="panel panel-default">

            <div class="panel-heading">busqueda</div>

            <div class="panel-body">
                <form action="/buscarlote" method="get">
                    buscar por numero de lote
                <input name="numero" type="text" class="busqueda numero">
                <input type="submit" value="buscar">
                </form>
                <form action="/buscarlotefecha" method="get">
                    buscar por fecha
                <input name="fecha" type="text" class="busqueda fecha">
                <input type="submit" value="buscar">
                </form>

         </div>
      </div>  
    </div>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">proyeccion</div>
                <div class="panel-body">
                        <table class="latabla table table-bordered table-striped table-responsive table-hover">
                            <tr>
                                <tr>
                                    <th>lote</th>
                                    <th colspan="1">fecha</th>
                                    <th colspan="3">Reposicion por poliducto</th>
                                    <th colspan="3">Inventario inicial</th>
                                    <th colspan="3">Inventario final</th>
                                    <th colspan="3">Autonomia</th>
                                    <th colspan="1">accion</th>
                                </tr>
                                <tr>
                                    <th>nombre</th>
                                    <th class="fecha">fecha</th>
                                    <th>G95</th> <th>G91</th> <th>DSL</th>
                                    <th>G95</th> <th>G91</th> <th>DSL</th>
                                    <th>G95</th> <th>G91</th> <th>DSL</th>
                                    <th>G95</th> <th>G91</th> <th>DSL</th>
                                    <th>accion</th>
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
                                        $proreposicion = $pro::where('lote_id', $lote->id)
                                          ->where('tipo','reposicion')->firstorfail();

                                        $proinicial = $pro::where('lote_id', $lote->id)
                                          ->where('tipo','inicial')->firstorfail();

                                        $profinal = $pro::where('lote_id', $lote->id)
                                          ->where('tipo','final')->firstorfail();

                                        $proautonomia = $pro::where('lote_id', $lote->id)
                                          ->where('tipo','autonomia')->firstorfail();

                                          @endphp

                                        <td class="reposicion g95">{{ $proreposicion->g95?$proreposicion->g95:0 }}</td>
                                        <td class="reposicion g91">{{ $proreposicion->g91 }}</td>
                                        <td class="reposicion dsl">{{ $proreposicion->dsl }}</td>

                                        <td class="inicial g95">{{ $proinicial->g95 }}</td>
                                        <td class="inicial g91">{{ $proinicial->g91 }}</td>
                                        <td class="inicial dsl">{{ $proinicial->dsl }}</td>

                                        <td class="final g95">{{ $profinal->g95 }}</td>
                                        <td class="final g91">{{ $profinal->g91 }}</td>
                                        <td class="final dsl">{{ $profinal->dsl }}</td>

                                        <td class="autonomia g95">{{ $proautonomia->g95 }}</td>
                                        <td class="autonomia g91">{{ $proautonomia->g91 }}</td>
                                        <td class="autonomia dsl">{{ $proautonomia->dsl }}</td>

                                        <td class="accion"><a href="/fila/{{ $lote->numero}}/eliminar"> <button type="button" class="btn btn-danger">Eliminar</button></a></td>
                                        @break
                                        @endforeach
                                    </tr>
                                @endforeach
                            
                            </tr>
                        </table>
                        <p></p>
                        <input type="button" class="agregar btn btn-info" value="agregar nueva fila">

                    </body>
                    <script src="js/jquery-2.1.4.js" type="text/javascript"></script>
                    <link href="css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css">
                    <script src="js/bootstrap-datepicker.js"></script>
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

                        $(document).ready(function() {
                            
                            
                            
                                    

                            var editarCelda = function () {

                                  var texto = $(this).text();
                                if($(this).hasClass('accion')){

                                }

                                else{

                                    if($(this).hasClass('nombrelote')){
                                        $(this).html('<input class="editando" type="text" size="5" value="'+texto+'">');
                                        $(this).attr('id',texto);

                                    }
                                    else if($(this).hasClass('fecha')){
                                        $(this).html('<input class="editando datepicker-here" data-language="es" type="text">');

                                    }
                                    else{

                                        $(this).html('<input class="editando" type="number" size="3" max="300" value="'+texto+'">');
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

                                $('tr:last').after(elhtml);
                                //var el = $('tr:last > td');
                                $('tr:last').css('background-color', 'gray');
                                $('.agregar').off('click');
                                $('.latabla').off('click','td');

                                var el = $('.editando');

                                el.click(function(event){
                                    event.stopPropagation();
                                });
                                el.focus();

                                //$('.latabla').off('click', 'tr:last >td');
                            };

                            var guardarDatoCelda = function () {
                                //console.log(texto);
                                var $el = $('.editando');

                                var valor = $el.val();
                                console.log(valor);

                                var idfila = 0;
                                var colfila = 0;
                                var tipofila = 0;

                                // $(element).attr("class").split(' ');
                                 var clases = $('.editando').parent().attr("class").split(' ');
                                  var anterior = $(this).parent().attr('id');
                                 //console.log(clases);

                                 colfila = clases[0] || 0;
                                 tipofila = clases[1] || 0;

                                
                                
                                trow = $el.parent().parent();

                                if($el.parent().hasClass('nombrelote')){
                                    trow.attr('id', valor)
                                }
                                idfila = trow.attr('id');
                                console.log(idfila);

                                if (!valor || valor == "" ) {
                                    if($el.parent().hasClass('nombrelote')){

                                        $(this).parent().parent().css('background-color', 'gray');
                                    }
                                    valor = 0;
                                }
                                else{

                                    $el.parent().text(valor);
                                    trow.css('background-color', '');
                                    trow.find('.accion > a').attr('href', '/fila/'+valor+'/eliminar');
                                    $('.latabla').on('click','td', editarCelda);
                                    //trow.find('td').on('click', editarCelda);
                                    $('.agregar').on('click',agregarFila);
                                    //url: '/datosAjax/InventarioPoliducto',

                                    /*
                                        
                                        $.ajax({
                                                    type: 'get',
                                                    url: '/sisor/public/datosAjax/InventarioPoliducto',
                                                    data: {
                                                        tipo: 'a',
                                                        nombre: 'a',
                                                        fecha_entrada: 'a',
                                                        fecha_salida: 'a',
                                                        proyeccion_tipo: 'a',
                                                        g95: 'a',
                                                        g91: 'a',
                                                        dsl: 'a',
                                                        lote_id: 'a',


                                                    },
                                                    dataType: 'json',
                                                    complete: function(){ 
                                                        alert('listo');
                                                    },

                                                    success: function(){
                                                        alert('exito');
                                                    }
                                                });
                                    */
                                    //var texto = texto || null;
                                    //texto = (isset(texto))?texto:valor;
                                   

                                    var texto = anterior || valor;



                                    $.ajax({
                                                type: 'get',
                                                url: '/poliducto',
                                                data: {
                                                    valor:valor,

                                                    idfila: idfila,
                                                    oldidfila : texto,
                                                    colfila: colfila,
                                                    tipofila: tipofila,
                                                    lote_id: idfila,


                                                },
                                                
                                                dataType: 'json',
                                                complete: function(){ 
                                                    //alert('listo');
                                                },

                                                success: function(data){
                                                    //console.log(data);
                                                    mostrarMensaje(data);
                                                }
                                            });


                                        
                                }
                                
                            };


                            $('.latabla ').on('click','td', editarCelda);

                            $('.latabla').on('blur','.editando', guardarDatoCelda);
                                    
                            $('.agregar').on('click',agregarFila);

                            //$('td ').on('click', editarCelda);
                                //$('.latabla > td ').on('click', editarCelda);
                                //verificar campo editando de nombrelote
                                //if (!el.parent('.datos').attr('id') == undefined) {}
                                //console.log('jaja');
                                //console.log($(this).text());
                                //$(this).parent().attr('id', $(this).text());
                                //$('#asdf > .inicial.DSL').text(5);
                                //$('#198-DSL199-G95 > .inicial.DSL').css('opacity','0.3')
                                //$('tr:last').after($('.datos:first').clone(true));
                                //.attr("id","capainterior3")
                                /*
                                $('.form-date').datepicker({
                                    format: "dd/mm/yyyy",
                                    maxViewMode: 3,
                                    todayBtn: "linked",
                                    clearBtn: true,
                                    language: "es",
                                    autoclose: true
                                });

                                $(".dada").mask("999-aaa-999-a99",{placeholder:"000-xxx-000-x00"});
                                //$(body).on('asdf','.editando .nombrelote',mask("999-aaa-999-a99"));
                                */

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
                                    // dismiss can be 'cancel', 'overlay',
                                    // 'close', and 'timer'
                                    if (dismiss === 'cancel') {
                                      swal(
                                        'Cancelado',
                                        'No se ha borrado la fila',
                                        'error'
                                      )
                                    }
                                  })
                                })

/*

filter:blur(5px);


background: #3db2e1;
background: -o-linear-gradient(top, #69c4e8, #21a1d4);
background: -ms-linear-gradient(top, #69c4e8, #21a1d4);
background: -webkit-linear-gradient(top, #69c4e8, #21a1d4);
background: -moz-linear-gradient(top, #69c4e8, #21a1d4);
background: linear-gradient(to bottom, #69c4e8, #21a1d4);
box-shadow: inset 0 -3px 0 #1f97c7, inset 0 -3px 3px #1f9acc, inset 0 2px 2px #9ad7ef, inset 1px 0 2px #22a4d9, inset -1px 0 2px #22a4d9, 0 1px 1px rgba(0, 0, 0, 0.1), 0 2px 2px rgba(0, 0, 0, 0.06), 0 3px 3px rgba(0, 0, 0, 0.17), 2px 1px 2px rgba(0, 0, 0, 0.05), -2px 1px 2px rgba(0, 0, 0, 0.05);
*/
/*
var mostrar_mensaje = function( informacion ){
    var texto = "", color = "";
    if( informacion.respuesta == "BIEN" ){
            texto = "<strong>Bien!</strong> Se han guardado los cambios correctamente.";
            color = "#379911";
    }else if( informacion.respuesta == "ERROR"){
            texto = "<strong>Error</strong>, no se ejecutó la consulta.";
            color = "#C9302C";
    }else if( informacion.respuesta == "EXISTE" ){
            texto = "<strong>Información!</strong> el usuario ya existe.";
            color = "#5b94c5";
    }else if( informacion.respuesta == "VACIO" ){
            texto = "<strong>Advertencia!</strong> debe llenar todos los campos solicitados.";
            color = "#ddb11d";
    }else if( informacion.respuesta == "OPCION_VACIA" ){
            texto = "<strong>Advertencia!</strong> la opción no existe o esta vacia, recargar la página.";
            color = "#ddb11d";
    }

    $(".mensaje").html( texto ).css({"color": color });
    $(".mensaje").fadeOut(5000, function(){
            $(this).html("");
            $(this).fadeIn(3000);
    });         
}
*/
var mostrarMensaje = function(informacion){
            var html = "";
            if( informacion.respuesta == "actualizarLote" )    html = "<div class='alert alert-success col-sm-offset-2 col-sm-8'><strong>Exito!</strong> se ha actualizado el lote numero "+informacion.oldlote+" a "+informacion.lote+"</div>";
            else if( informacion.respuesta == "agregarLote" )   html = "<div class='alert alert-info col-sm-offset-2 col-sm-8'><strong>Exito!</strong>, se ha registrado un nuevo lote</div>";
            else if( informacion.respuesta == "actualizardata" )   html = "<div class='alert alert-info col-sm-offset-2 col-sm-8'><strong>Exito</strong>,se ha actualizado el campo "+informacion.tipo+" de "+informacion.columna+"del lote "+informacion.lote+"</div>";


            $(".mensaje").html( html );
            $(".mensaje").fadeOut(12000, function(){
                    $(this).html("");
                    $(this).fadeIn(3000);
            });         
        }
/*
    var mostrarMensaje = function( informacion ){
        var texto = "", color = "";
        if( informacion.respuesta == "BIEN" ){
                texto = "<strong>Exito!</strong> se ha actualizado el lote numero"+informacion.oldidfila+"a "+informacion.lote;
                color = "#379911";
        }else if( informacion.respuesta == "agregarLote"){
                texto = "<strong>Exito!</strong>, se ha registrado un nuevo lote.";
                color = "#C9302C";
        }else if( informacion.respuesta == "actualizardata"){
                texto = "<strong>Exito</strong>,se ha actualizado el campo "+informacion.tipo+"de "+informacion.columna+"del lote "+informacion.lote;
                color = "#C9302C";
        }
        

        $(".mensaje").html( texto ).css({"color": color });
        $(".mensaje").fadeOut(5000, function(){
                $(this).html("");
                $(this).fadeIn(3000);
        });         
    }
*/

/*
$('.latabla ').on('click','td', applyDatapicker);


    var applyDatapicker = function () {
        
        $('.fecha > .editando').datepicker({
            format: "dd/mm/yyyy",
            maxViewMode: 3,
            todayBtn: "linked",
            clearBtn: true,
            language: "es",
            autoclose: true
        });
    }
   */ 
//$('.prueba').on('click', myDatepicker.show());
/*
if (jQuery.ui) {
    var datepicker = $.fn.datepicker.noConflict();
    $.fn.bootstrapDP = datepicker;
} else {
    $.fn.bootstrapDP = $.fn.datepicker;
}
*/

$('.busqueda.fecha').datepicker({
            format: "dd/mm/yyyy",
            maxViewMode: 3,
            todayBtn: "linked",
            clearBtn: true,
            language: "es",
            autoclose: true
        });

         


                            
                        });
                        </script>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
