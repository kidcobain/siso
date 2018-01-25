@extends('layouts.app')
{{-- {{ \Debugbar::disable() }} --}}
{{-- app('debugbar')->disable(); --}}
@section('content')
<link rel="stylesheet" href="/css/sweetalert2.css">
<link rel="stylesheet" href="/css/tablestyle.css">
<link rel="stylesheet" href="/css/bootstrap-material-design.min.css">
<link rel="stylesheet" href="/css/ripples.min.css">
<link rel="stylesheet" href="/css/bootstrap-material-datetimepicker.css">

<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

<style>
    i.fa-check {
        background-color: #94cf35;
        border-radius: 5px;
    }

    i.fa-times {
        background-color: #f68989;
        border-radius: 5px;
    }

    span.loteguardar, span.lotecancelar {
        cursor: pointer;
    }
    span.opciones {
        position: absolute;
        height: 20px;
        width: 20px;
    }
    input.editando {
        width: 40px;
    }
    table  {
     position: relative;
    }
   

    table.loading tbody:after {
        /*background-image: url(/img/378.gif);*/
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        /*background-color: rgba(0, 0, 0, 0.6);*/
        background-color: rgba(117, 203, 90, 0.6);
        
        background-image: url(/img/Ellipsis.svg);
        background-position: center;
        background-repeat: no-repeat;
        /*background-size: 50px 50px;*/
        content: "";
    }
</style>
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> --}}
    {{-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> --}}
<div class="container" style=" width: unset;">
    <div class="row">
        <div class="mensaje " style="height: 80px">
            <!-- 
            <i class="fa fa-check" aria-hidden="true"></i>
            <i class="fa fa-times" aria-hidden="true"></i> 
            -->
        </div>
    </div>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default panelbusqueda">
                <div class="panel-heading">busqueda</div>
                <div class="panel-body">
                   <!-- <div class="buscarnumero">
                       <form action="/buscarlote" method="get">
                           <label for="numero">buscar por numero de lote</label>
                           <input name="numero" type="text" class="busqueda numero">
                           <input type="submit" value="buscar">
                       </form>
                   </div> -->
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
            <div class="col-md-10 col-md-offset-1"">
                @if (!empty($exito))
                <div class="alert alert-success alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>{{ $exito }}</strong>
                </div>
                @endif
                <div class="panel panel-default">
                    <div class="panel-heading">proyecciones<span class="imprimir"> -> <a href="javascript:window.print()">imprimir</a></span></div>
                    <div class="panel-body paneltabla">
                        <span class="none""><img src="/img/Ellipsis.svg" alt=""></span>
                        <table class="latabla table table-bordered table-striped table-responsive table-hover">
                            <thead>
                                <tr>
                                    <th colspan="1" class="lotes">lote</th>
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
                            @if(count($proyecciones)>=1)
                            {{-- @if(1) --}}
                            <tbody>
                        
                        @foreach ($proyecciones as $proyeccion)
                        @php
                        $date = new DateTime($proyeccion->fecha_entrada);
                        $fecha = date_format($date, 'd-m-Y');
                        @endphp
                        <tr class="datos {{ $fecha }}" id="{{ $proyeccion->id }}">
                            <td class="lotes lotestotal">{{ count($proyeccion->lote) }} lotes</td>
                            <td class="fecha">
                                {{ ($fecha)?$fecha :'00/00/0000' }}
                                
                            </td>
                            {{-- eager load para cargar inventarios --}}
                            @foreach($proyeccion->inventario as $pro)
                            @php
                            $proreposicion = 0;
                            $proreposicion = $pro::where('proyeccion_id', $proyeccion->id)
                            ->where('tipo','reposicion')->firstorfail();
                            $proinicial = 0;
                            $proinicial = $pro::where('proyeccion_id', $proyeccion->id)
                            ->where('tipo','inicial')->firstorfail();
                            $proventas = 0;
                            $proventas = $pro::where('proyeccion_id', $proyeccion->id)
                            ->where('tipo','ventas')->firstorfail();
                            $profinal = 0;
                            $profinal = $pro::where('proyeccion_id', $proyeccion->id)
                            ->where('tipo','final')->firstorfail();
                            $proautonomia = 0;
                            $proautonomia = $pro::where('proyeccion_id', $proyeccion->id)
                            ->where('tipo','autonomia')->firstorfail();
                            @endphp
                            <td class="reposicion G95">
                                {{ $proreposicion->g95 }}
                            </td>
                            <td class="reposicion G91">
                                {{ $proreposicion->g91 }}
                            </td>
                            <td class="reposicion DSL">
                                {{ $proreposicion->dsl }}
                            </td>
                            <td class="inicial G95">
                                {{ $proinicial->g95 }}
                            </td>
                            <td class="inicial G91">
                                {{ $proinicial->g91 }}
                            </td>
                            <td class="inicial DSL">
                                {{ $proinicial->dsl }}
                            </td>
                            
                            <td class="ventas G95">
                                {{ $proventas->g95 }}
                            </td>
                            <td class="ventas G91">
                                {{ $proventas->g91 }}
                            </td>
                            <td class="ventas DSL">
                                {{ $proventas->dsl }}
                            </td>
                            <td class="final G95">
                                {{ $profinal->g95 }}
                            </td>
                            <td class="final G91">
                                {{ $profinal->g91 }}
                            </td>
                            <td class="final DSL">
                                {{ $profinal->dsl }}
                            </td>
                            <td class="autonomia G95">
                                {{ $proautonomia->g95 }}
                            </td>
                            <td class="autonomia G91">
                                {{ $proautonomia->g91 }}
                            </td>
                            <td class="autonomia DSL">
                                {{ $proautonomia->dsl }}
                            </td>
                            <td class="accion">
                                @can('eliminar_lotes')
                                <a href="/fila/{{ $proyeccion->id}}/eliminar">
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
            @if(method_exists($proyecciones,'links'))
            {{$proyecciones->links()}}
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
{{-- <script src="js/bootstrap-datepicker.js"></script> --}}
{{-- <script src="/js/moment-with-locales.min.js"></script> --}}
<script src="/js/moment-with-locales.min.js"></script>
{{-- <script src="/js/material.min.js"></script> --}}
<script src="{{ asset('js/material.min.js') }}"></script>
<script src="{{ asset('js/ripples.min.js') }}"></script>
{{-- <script src="/js/ripples.min.js"></script> --}}
<script src="/js/jquery-ui.min.js"></script>
<script src="/js/bootstrap-material-datetimepicker.js"></script>
{{-- <script src="js/bootstrap-datepicker.es.min.js" type="text/javascript"></script> --}}
<script src="/js/sweetalert2.all.min.js"></script>
{{-- <script src="js/jquery.maskedinput.min.js" type="text/javascript"></script> --}}

<script>
$(document).ready(function() {
$('.none').hide('fast', function() {
});;
    
var elhtml = `
<tr class="datos " id="">
    <td class="lotes lotestotal">0 lotes</td>
    <td class="fecha">
        <input class="editando datepicker" type="text" size="8">
        <span class="opciones">
            <span class="loteguardar">
                <i class="fa fa-check" aria-hidden="true"></i>
            </span>
            <span class="lotecancelar">
                <i class="fa fa-times" aria-hidden="true"></i>
            </span>
        </span>

    </td>
    
    <td class="reposicion G95">0</td>
    <td class="reposicion G91">0</td>
    <td class="reposicion DSL">0</td>
    
    <td class="inicial G95">0</td>
    <td class="inicial G91">0</td>
    <td class="inicial DSL">0</td>
    
    <td class="ventas G95">0</td>
    <td class="ventas G91">0</td>
    <td class="ventas DSL">0</td>
    
    <td class="final G95">0</td>
    <td class="final G91">0</td>
    <td class="final DSL">0</td>
    
    <td class="autonomia G95">0</td>
    <td class="autonomia G91">0</td>
    <td class="autonomia DSL">0</td>
    <td class="accion"><a href="/eliminarfila/"><button type="button" class="btn btn-danger">Eliminar</button></a></td>
</tr>
`;

var botondelotes = `
        <tr class="rowagregarlotes">
            <td>
                <input type="button" value="agregar lote" class="agregarlotedesplegable">
            </td>
        </tr>
    `;

function showTime() {
  var timeNow = new Date();
  var hours   = timeNow.getHours();
  var minutes = timeNow.getMinutes();
  var timeString = "" + ((hours > 12) ? hours - 12 : hours);
  timeString  += ((minutes < 10) ? ":0" : ":") + minutes;
  timeString  += (hours >= 12) ? " pm" : " am";
  return timeString;
}

var calcular = function(idfila, clases) {

    var reposicionval = parseInt($('[id=\"' + idfila + '\"] .reposicion.' + clases[1]).text());
    var inicialval = parseFloat($('[id=\"' + idfila + '\"] .inicial.' + clases[1]).text(), 2);
    var ventasval = parseFloat($('[id=\"' + idfila + '\"] .ventas.' + clases[1]).text(), 1);
    console.log('calculando');
    var final = (reposicionval + inicialval) - ventasval;
    final = final.toFixed(1);

    $('[id=\"' + idfila + '\"] .final.' + clases[1]).text(final).effect('highlight', {}, 1000);

    if (final != 0) {
        var autotipo = [];
        autotipo['G95'] = 1.8;
        autotipo['G91'] = 2.8;
        autotipo['DSL'] = 1.2;
        var autonomia = final / autotipo[clases[1]];
        autonomia = Math.round(autonomia);
        $('[id=\"' + idfila + '\"] .autonomia.' + clases[1]).text(autonomia).effect('highlight', {}, 1000);
    }
};



var eliminarlotedesplegable = function() {


    if ($(this).parent().parent().attr('data-idlote')){
       
        var idlote = $(this).parent().parent().attr('data-idlote');
        var idproyeccion = $(this).parent().parent().attr('data-idproyeccion');
        var tipolote = $(this).parent().parent().find('.nombrelote').text().split('-');
        $.ajax({
            type: 'get',
            url: '/eliminarlote',
            data: {
                idlote: idlote,

            },
            dataType: 'json',
            success: function(data) {
                //mostrarMensaje(data);
            }
        });
        var datolote = parseInt($(this).parent().parent().find('.'+tipolote[1]).text());

        var valorpro = parseInt($('#'+idproyeccion).find('.reposicion.'+tipolote[1]).text());
        var newvalor = valorpro - datolote;
        $('#'+idproyeccion).find('.reposicion.'+tipolote[1]).text(newvalor);
        calcular(idproyeccion, tipolote);

    } 
        $(this).parent().parent()
            .find('td')
            .wrapInner('<div style="display: block;" />')
            .parent()
            .find('td > div')
            .slideUp(700, function() {

                $(this).parent().parent().remove();

        });
}

var agregarlotedesplegable = function(event) {
    //event.stopPropagation();
    var ultimo = '';

    $('.latabla').off('click','.agregarlotedesplegable');
    $('.latabla').off('click','.eliminarlotedesplegable');
    $('.latabla').off('click','.lotedatos .nombrelote');
    $('.latabla').off('click','.lotedatos .reposicion');
    $('.latabla').off('click','td.ventas');

    var idproyeccion = $(this).parent().parent().attr('data-idproyeccion');
    //console.log(idproyeccion);

    var horaActual = showTime();
       //$consulta = App\Lote::all(['numero'])->last();
    var filadesplegable = `
    <tr class="lotedatos" data-idproyeccion="${idproyeccion}"colspan="6">
        
        <td class="nombrelote"><input class="editando numero" type="text" size="3" maxlength="3" value="${ultimo}"/> -
        <select name="tipo" class="editando">
            <option value="">tipo</option>
            <option value="G95">G95</option>
            <option value="G91">G91</option>
            <option value="DSL">DSL</option>
            option
        </select>
        <span class="opciones">
            <span class="loteguardar">
                <i class="fa fa-check" aria-hidden="true"></i>
            </span>
            <span class="lotecancelar">
                <i class="fa fa-times" aria-hidden="true"></i>
            </span>
        </span>
    </td>
    <td class="hora">${horaActual}</td>
    <td class="reposicion G95">
        0
    </td>
    <td class="reposicion G91">
        0
    </td>
    <td class="reposicion DSL">
        0
    </td>
    <td colspan="2"><input type="button" value="eliminar lote" class="eliminarlotedesplegable"></td>
    </tr>
    `;

    var $filadesplegable = $(filadesplegable);
    $(this).parent().parent().prevAll('.datos:first').after($filadesplegable);

    $filadesplegable
        .find('td')
        .wrapInner('<div style="display: none;" />')
        .parent()
        .find('td > div')
        .slideDown(700, function() {

            var $set = $(this);
            $set.replaceWith($set.contents());

        });
    
   $.get( "/ultimo", function( data ){

        var ultimo = parseInt(data.numero) || 0;
        var ultimonro = ultimo  + 1;
        $filadesplegable.find('.editando:first').val(ultimonro);
    });
        
    $('.loteguardar').click(guardarCelda);
    $('.lotecancelar').click(cancelarCelda);
}





var editarLote = function(event) {
    //event.stopPropagation();
    //$(this)= _this;
    var texto = $(this).text();
    var valores = texto.split('-');
    if (!$(this).hasClass('accion')) {


            if ($(this).hasClass('nombrelote')) {
                var seleccionado = "selected";
                var noSeleccionado = "";


                var inputslote = `<input class="editando" type="text" size="3" maxlength="3" value="${valores[0]}"/> - 
                                    <select name="tipo" class="selectipo editando">
                                        <option value="">tipo </option>
                                        <option value="G95" ${ (valores[1] == "G95")? seleccionado : noSeleccionado }>G95</option>
                                        <option value="G91" ${ (valores[1] == "G91")? seleccionado : noSeleccionado }>G91</option>
                                        <option value="DSL" ${ (valores[1] == "DSL")? seleccionado : noSeleccionado }>DSL</option>
                                    </select>
                                    <span class="opciones">
                                        <span class="loteguardar">
                                            <i class="fa fa-check" aria-hidden="true"></i>
                                        </span>
                                        <span class="lotecancelar">
                                            <i class="fa fa-times" aria-hidden="true"></i>
                                        </span>
                                    </span>

                                    `;


                $(this).html(inputslote);

            } else if ($(this).hasClass('fecha')) {

                $(this).html('<input class="editando datepicker-here" data-language="es" type="text">');

            } else if ($(this).hasClass('reposicion')) {

                var textolote = $(this).parent().find('.nombrelote').text()
                var valoresinput = textolote.split('-');
                var clases = $(this).attr('class').split(' ');                
                if(clases[1] != valoresinput[1]){
                    return;
                }
                var editarinput =`
                <input class="editando" type="number" size="3" max="300" min="0" value="${parseInt(texto)}" />


                <span class="opciones">
                    <span class="loteguardar">
                        <i class="fa fa-check" aria-hidden="true"></i>
                    </span>
                    <span class="lotecancelar">
                        <i class="fa fa-times" aria-hidden="true"></i>
                    </span>
                </span>
                `; 
                $(this).html(editarinput);

            } else{
                    var editarinput =`
                    <input class="editando" type="number" size="3" max="300" min="0" value="${parseInt(texto)}" />


                    <span class="opciones">
                        <span class="loteguardar">
                            <i class="fa fa-check" aria-hidden="true"></i>
                        </span>
                        <span class="lotecancelar">
                            <i class="fa fa-times" aria-hidden="true"></i>
                        </span>
                    </span>
                    `; 
                $(this).html(editarinput);
            }



        } else {

            //$(this).html('<input class="editando" type="number" size="3" max="300" min="0" value="' + parseInt(texto) + '">');
        }

        var $input = $(this).find('.editando');

        $input.focus();

            $(this).children().click(function(event) {
                event.stopPropagation();
            });
        
        //$('.latabla').off('click', 'td');
        $('.latabla').off('click','.agregarlotedesplegable');
        $('.latabla').off('click','.eliminarlotedesplegable');
        $('.latabla').off('click','.lotedatos .nombrelote');
        $('.latabla').off('click','.lotedatos .reposicion');
        $('.latabla').off('click','td.ventas');

        $('.loteguardar').click( function(){guardarCelda(event,texto, $(this))});
        $('.lotecancelar').click( function(){cancelarCelda(event, texto, $(this))});

};

var desplegarlotes = function(event) {
    event.preventDefault();
    var $este = $(this);
    var idproyeccion = $este.parent().attr('id');

    if ( $este.attr('data-desplegado')=='abierto') {

 
        $('*[data-idproyeccion=\"'+idproyeccion+'\"]').find('td')
            .wrapInner('<div style="display: block;" />')
            .parent()
            .find('td > div')
            .slideUp(700, function() {

                $(this).parent().parent().remove();

            });
            $este.attr('data-desplegado', 'cerrado');
        
        
    } else {

        if ($este.attr('data-desplegado') == undefined || $este.attr('data-desplegado')=='cerrado'){

            $.ajax({
                type: 'get',
                url: '/lotes',
                data: {
                    id: idproyeccion,
                },
                beforeSend: function(){ 
                    $('.latabla').addClass('loading');
                },

                dataType: 'json',
                complete: function(){ 
                    $este.attr('data-desplegado', 'abierto');
                    $('.latabla').removeClass('loading');
                }
            })

                .done( function(data) {
                    //mostrarMensaje(data);
                    var filasdesplegables= "";
                    var botondelotes = `
                            <tr class="rowagregarlotes" data-idproyeccion="${idproyeccion}">
                                <td>
                                    <input type="button" value="agregar lote" class="agregarlotedesplegable">
                                </td>
                            </tr>
                        `;
                    for(var i in data){
// coloca clase fecha id  
                    filasdesplegables += `
                    <tr class="lotedatos" data-idlote="${data[i].id}" data-idproyeccion="${data[i].proyeccion_id}" colspan="6">
                        <td class="nombrelote">${data[i].numero}-${data[i].tipo}</td>
                        <td class="hora">${data[i].hora}</td>
                        <td class="reposicion G95">${(data[i].tipo=="G95")? data[i].cantidad : 0}</td>
                        <td class="reposicion G91">${(data[i].tipo=="G91")? data[i].cantidad : 0}</td>
                        <td class="reposicion DSL">${(data[i].tipo=="DSL")? data[i].cantidad : 0}</td>
                        <td colspan="2">
                            <input type="button" value="eliminar lote" class="eliminarlotedesplegable">
                        </td>
                    </tr>
                        `;
                    }
                    var $filasdesplegables = $(filasdesplegables);
                    $('#'+idproyeccion)
                    .after(botondelotes)
                    .after($filasdesplegables);                

                    $filasdesplegables
                        .find('td')
                        .wrapInner('<div style="display: none;" />')
                        .parent()
                        .find('td > div')
                        .slideDown(700, function() {

                             var $set = $(this);
                            $set.replaceWith($set.contents());

                        });
                });
            }
        }

};

var cancelarCelda = function(event, datos, _this) {
    event.preventDefault();

    if (datos!=undefined) {
        _this.parent().parent().text(datos);
    } else {
       

        
        $(this).parent().parent().parent()
            .find('td')
            .wrapInner('<div style="display: block;" />')
            .parent()
            .find('td > div')
            .slideUp(700, function() {

                $(this).parent().parent().remove();

            });
    }

    $('.latabla').on('click', '.agregarlotedesplegable', agregarlotedesplegable);
    $('.latabla').on('click', '.eliminarlotedesplegable', eliminarlotedesplegable);
    $('.latabla').on('click','.lotedatos .nombrelote', editarLote);
    $('.latabla').on('click','.lotedatos .reposicion', editarLote);
    $('.latabla').on('click','td.ventas', editarLote);
    
};

var guardarCelda = function(event, texto, _this) {
    event.preventDefault();

    var valores = (texto)?texto.split('-'):null;

    _this = (_this)?_this:$(this);

    var $fila = _this.parent().parent().parent();

    var $elemento = _this.parent().parent();

    var $editando = $elemento.find('.editando');

    var valornum = $editando[0].value;
    var hora = $fila.find('.hora').text();

    var $idproyeccion = ($fila.attr('data-idproyeccion'))?$fila.attr('data-idproyeccion') : "vacio";   
    var $idlote = ($fila.attr('data-idlote'))? $fila.attr('data-idlote') : "vacio";


    if($elemento.hasClass('reposicion')){
        var valortipo = _this.parent().parent().attr("class").split(' ');
        var oldvalor = parseInt(texto);
        var newvalor = parseInt(valornum);

        $.ajax({
            type: 'get',
            url: '/reposicion',
            data: {
                idlote       : $idlote,
                idproyeccion : $idproyeccion,
                cantidad       : valornum,
                tipo       : valortipo[1],
                oldvalor    : oldvalor,
            },
            dataType: 'json',
        })

        .done( function(data) {
        });

        var oldtotal = parseInt($('#'+$idproyeccion).find('.reposicion.'+valortipo[1]).text());

        oldtotal = oldtotal - oldvalor;
        newtotal = oldtotal + newvalor;

        $('#'+$idproyeccion).find('.reposicion.'+valortipo[1]).text(newtotal).effect('highlight', {}, 1000);
        _this.parent().parent().text(valornum).effect('highlight', {}, 1000);
        var tipo = [0, valortipo[1]];
        calcular($idproyeccion, tipo);



    }

    if($elemento.hasClass('ventas')){
        var valortipo = $elemento.attr("class").split(' ');
        var oldvalor = parseInt(texto);
        var newvalor = parseInt(valornum);
        var $idproyeccion = $elemento.parent().attr('id');

        $.ajax({
            type: 'get',
            url: '/ventas',
            data: {
                idproyeccion       : $idproyeccion,
                cantidad       : valornum,
                tipo       : valortipo[1],
                oldvalor    : oldvalor,
            },
            dataType: 'json',
        })

        .done( function(data) {
        });

        _this.parent().parent().text(newvalor).effect('highlight', {}, 1000);
        var tipo = [0, valortipo[1]];
        calcular($idproyeccion, tipo);

    }

    if($elemento.hasClass('fecha')){
        var fecha = $elemento.find('.editando').val();

        $.ajax({
            type: 'get',
            url: '/nuevapro',
            data: {
                fecha         : fecha,
            },
            dataType: 'json',
            beforeSend: function(){ 
                $('.latabla').addClass('loading');
            },
        }).done(function (data) {
            $('.latabla').removeClass('loading');
            $elemento.parent().attr('id',data.idproyeccionguardado);
            $elemento.text(fecha);

            var $elem = $('#'+data.idproyeccionguardado);

            $elem.find('.accion a').attr('href', '/fila/'+data.idproyeccionguardado+'/eliminar');;

            $elem.find('.inicial.G95, .final.G95').text(data.final.g95);
            $elem.find('.inicial.G91, .final.G91').text(data.final.g91);
            $elem.find('.inicial.DSL, .final.DSL').text(data.final.dsl);

            $elem.find('.autonomia.G95').text(data.autonomia.g95);
            $elem.find('.autonomia.G91').text(data.autonomia.g91);
            $elem.find('.autonomia.DSL').text(data.autonomia.dsl);
        });
    }   


    if ($elemento.hasClass('nombrelote')) {

        var valortipo = $editando[1].value;
        var valor = valornum + '-' + valortipo;
        $elemento.text(valor);

        $.ajax({
            type: 'get',
            url: '/lote',
            data: {
                idlote       : $idlote,
                idproyeccion : $idproyeccion,
                numero       : valornum,
                tipo         : valortipo,
                hora         : hora,
            },
            dataType: 'json',
        }).done(function (data) {
            $elemento.parent().attr('data-idlote',data.idloteguardado);
        });

        
            if (!valortipo[1]===undefined) {
                if (valortipo != valores[1]){

                    var oldvalor = parseInt($fila.find('.'+valores[1]).text());
                    $fila.find('.'+valores[1]).text("0").effect('highlight', {}, 1000);
                    $fila.find('.'+valortipo).text(oldvalor).effect('highlight', {}, 1000);

                    var oldtotal = parseInt($('#'+$idproyeccion).find('.reposicion.'+valores[1]).text());

                    var newtotal = parseInt($('#'+$idproyeccion).find('.reposicion.'+valortipo).text());

                    oldtotal = oldtotal - oldvalor;
                    newtotal = newtotal + oldvalor;

                    $('#'+$idproyeccion).find('.reposicion.'+valortipo).text(newtotal).effect('highlight', {}, 1000);;

                    $('#'+$idproyeccion).find('.reposicion.'+valores[1]).text(oldtotal).effect('highlight', {}, 1000);;

                    var tipo = [0,valortipo];
                    calcular($idproyeccion, tipo);
                    calcular($idproyeccion, valores);

                }

            }

    }

    

    $elemento.css('background-color', '');
    //habilitarListeners();
    $('.latabla').on('click', '.agregarlotedesplegable', agregarlotedesplegable);
    $('.latabla').on('click', '.eliminarlotedesplegable', eliminarlotedesplegable);
    $('.latabla').on('click', '.lotedatos .nombrelote', editarLote);
    $('.latabla').on('click', '.lotedatos .reposicion', editarLote);
    $('.latabla').on('click', 'td.ventas', editarLote);

};

$('.latabla').on('click', '.lotes', desplegarlotes);

$('.latabla').on('click', '.agregarlotedesplegable', agregarlotedesplegable);
$('.latabla').on('click', '.eliminarlotedesplegable', eliminarlotedesplegable);

$('.latabla').on('click', '.lotedatos .nombrelote', editarLote);
$('.latabla').on('click', '.lotedatos .reposicion', editarLote);
$('.latabla').on('click', 'td.ventas', editarLote);

//$('.latabla').on('click', '.loteguardar', guardarCelda);
//$('.latabla').on('click', '.lotecancelar', cancelarCelda);








//**********************************************************************************
var agregarFila = function() {

    if ($('.sinregistros')) { $('.sinregistros').html('') };

    $('.latabla tr:last').after(elhtml);


    $('.editando.datepicker').bootstrapMaterialDatePicker({ 
        weekStart : 0, 
        time: false, 
        lang: 'es',
        format: 'DD/MM/YYYY',
        cancelText : 'cancelar',
        nowButton : true,
        nowText: 'hoy',
        switchOnClick: true
    });

    var el = $('.editando');

    el.click(function(event) {
        event.stopPropagation();
    });
    el.focus();
    $('.latabla').off('click','.agregarlotedesplegable');
    $('.latabla').off('click','.eliminarlotedesplegable');
    $('.latabla').off('click','.lotedatos .nombrelote');
    $('.latabla').off('click','.lotedatos .reposicion');
    $('.latabla').off('click','td.ventas');

    $('.loteguardar').click( guardarCelda);
    $('.lotecancelar').click( cancelarCelda);

};
    
@can('editar_lotes')

                            
                            
@endcan

@can('agregar_lotes')   
                                    
                            $('.agregar').on('click',agregarFila);
@endcan

@can(['agregar_lotes','agregar_lotes'])  

//$('.latabla').on('blur','.editando', guardarDatoCelda);
//$('.latabla').on('blur','.editando', guardarCelda);

//$('.latabla').on('click','td', editarCelda);

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

/*
$('.busqueda.fecha').datepicker({
    format: "dd/mm/yyyy",
    endDate: "0d",
    maxViewMode: 3,
    todayBtn: "linked",
    clearBtn: true,
    language: "es",
    autoclose: true,
});
*/
$('.busqueda.fecha').bootstrapMaterialDatePicker({ 
    weekStart : 0, 
    time: false, 
    lang: 'es',
    format: 'DD/MM/YYYY',
    cancelText : 'cancelar',
    nowButton : true,
    nowText: 'hoy',
    switchOnClick: true
});

$('.editando.datepicker').bootstrapMaterialDatePicker({ 
    weekStart : 0, 
    time: false, 
    lang: 'es',
    format: 'DD/MM/YYYY',
    cancelText : 'cancelar',
    nowButton : true,
    nowText: 'hoy',
    switchOnClick: true
});

$('.busqueda.numero').bootstrapMaterialDatePicker
({
    date: false,
    shortTime: true,
    lang: 'es',
    format: 'hh:mm a',
    nowButton : true,
    nowText: 'ahora',
    switchOnClick: true,
});


$.material.init();



    @if (session('success'))
         var variable = {!! json_encode(session('success')) !!};
         mostrarMensaje(variable);
     
    @endif                         
                        
});
//opcion cerrar/desplegar todos los lotes
                        </script>
@endsection