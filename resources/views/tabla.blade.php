@extends('layouts.app')
{{-- \Debugbar::disable() --}}
@section('content')
<link rel="stylesheet" href="/css/sweetalert2.css">
<link rel="stylesheet" href="/css/tablestyle.css">
<div class="container" style=" width: unset;">
    <div class="row">
        <div class="mensaje " style="height: 80px">
        </div>
    </div>
    <div class="row">
        <div class="col-md-9 col-md-offset-2">
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
            <div class="col-md-9 col-md-offset-2"">
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
<script src="js/bootstrap-datepicker.js"></script>
<script src="js/jquery-ui.min.js"></script>
<script src="js/bootstrap-datepicker.es.min.js" type="text/javascript"></script>
<script src="js/sweetalert2.all.min.js"></script>
<script src="js/jquery.maskedinput.min.js" type="text/javascript"></script>
<script>
$(document).ready(function() {
    
//"05/06/1986".replace(/\//g,"-")
function showTime() {
  var timeNow = new Date();
  var hours   = timeNow.getHours();
  var minutes = timeNow.getMinutes();
  var timeString = "" + ((hours > 12) ? hours - 12 : hours);
  timeString  += ((minutes < 10) ? ":0" : ":") + minutes;
  timeString  += (hours >= 12) ? " pm" : " am";
  return timeString;
}
var elhtml = `
<tr class="proyecciondatos " id="">
    <td class="tdlote"><input class="editando" type="text" size="5"/></td>
    <td class="fecha">00/00/000</td>
    
    <td class="reposicion g95">0</td>
    <td class="reposicion g91">0</td>
    <td class="reposicion dsl">0</td>
    
    <td class="inicial g95">0</td>
    <td class="inicial g91">0</td>
    <td class="inicial dsl">0</td>
    
    <td class="ventas g95">0</td>
    <td class="ventas g91">0</td>
    <td class="ventas dsl">0</td>
    
    <td class="final g95">0</td>
    <td class="final g91">0</td>
    <td class="final dsl">0</td>
    
    <td class="autonomia g95">0</td>
    <td class="autonomia g91">0</td>
    <td class="autonomia dsl">0</td>
    <td class="accion"><a href="/eliminarfila/"><button type="button" class="btn btn-danger">Eliminar</button></a></td>
</tr>
`;
var filadesplegable = `
<tr class="lotedatos" colspan="6">
    
    <td class="nombrelote"><input class="editando" type="text" size="3" maxlength="3" /> -
    <select name="tipo" class="editando">
        <option value="">tipo</option>
        <option value="G95">G95</option>
        <option value="G91">G91</option>
        <option value="DSL">DSL</option>
        option
    </select>
    <p>
        <a href="#" class="lotecancelar">cancelar</a>
        <a href="#" class="loteguardar">guardar</a>
    </p>
</td>
<td class="hora"></td>
<td class="reposicion g95">
    0
</td>
<td class="reposicion g91">
    0
</td>
<td class="reposicion dsl">
    0
</td>
<td colspan="2"><input type="button" value="eliminar lote" class="eliminarlotedesplegable"></td>
</tr>
`;
var eliminarlotedesplegable = function() {
    //console.log($(this));
    //var $este = dis || $(this);
    var $este = $(this)
    $este.parent().parent()
        .find('td')
        .wrapInner('<div style="display: block;" />')
        .parent()
        .find('td > div')
        .slideUp(700, function() {

            $este.parent().parent().remove();

        });
}

var habilitarListeners = function(){
//$('.latabla').on('click','.nombrelote', editarLote);
$('.latabla').on('click','.eliminarlotedesplegable', eliminarlotedesplegable);
$('.latabla').on('click','.agregarlotedesplegable', agregarlotedesplegable);
$('.latabla').on('click','.loteguardar', guardarCelda);
$('.latabla').on('click','.lotecancelar', cancelarCelda);

};

var deshabilitarListeners = function(){
        $('.latabla').off('click','td');
    $('.agregarlotedesplegable').off('click');
    $('.eliminarlotedesplegable').off('click');
    //$('.latabla').off('click', '.eliminarlotedesplegable');
};


var agregarlotedesplegable = function() {

    //otrafila += filadesplegable;

    var $filadesplegable = $(filadesplegable);
    $(this).parent().parent().prevAll('.datos:first').after($filadesplegable);
    var horaActual = showTime();
    //$filadesplegable.find('.hora').text(hour);

    //$filadesplegable.css('background-color', 'gray');
    /*
       $('.lotedatos').find('> td')
       .css({'height':'0px'})
       .wrapInner('<div style=\"display:block;\" />')
       .parent().find('td > div')
       .slideUp('slow', function() {
        $(this).parent().parent().remove();

    });
    */

    //$('.lotedatos')
    $filadesplegable
        .find('td')
        .wrapInner('<div style="display: none;" />')
        .parent()
        .find('td > div')
        .slideDown(700, function() {

            var $set = $(this);
            $set.replaceWith($set.contents());

        });

    /*

    $('.lotedatos').each(function(){
     $(this)
    .find('td')
     .wrapInner('<div style="display: block;" />')
     .parent()
     .find('td > div')
     .slideUp(700, function(){

      $(this).parent().parent().remove();

     })
    });
    */


    $(this).click(function(event) {
        event.stopPropagation();
    });
    //deshabilitarListeners();
}


$('.latabla').on('click', '.agregarlotedesplegable', agregarlotedesplegable);




var editarLote = function() {


    var texto = $(this).text();
    console.log(texto);
    var valores = texto.split('-');
    console.log(valores);
    if (!$(this).hasClass('accion')) {


        var seleccionado = "selected";
        var noSeleccionado = "";


        var inputslote = `<input class="editando" type="text" size="3" maxlength="3" value="${valores[0]}"/> - 
                            <select name="tipo" class="selectipo editando">
                                <option value="">tipo </option>
                                <option value="G95" ${ (valores[1] == "G95")? seleccionado : noSeleccionado }>G95</option>
                                <option value="G91" ${ (valores[1] == "G91")? seleccionado : noSeleccionado }>G91</option>
                                <option value="DSL" ${ (valores[1] == "DSL")? seleccionado : noSeleccionado }>DSL</option>
                            </select>
                            <p>
                                <a href="#" class="lotecancelar">cancelar</a>
                                <a href="#" class="loteguardar">guardar</a>
                            </p>

                            `;


        if ($(this).hasClass('nombrelote')) {
            $(this).html(inputslote);
            //$(this).attr('id', texto);

        } else if ($(this).hasClass('fecha')) {
            $(this).html('<input class="editando datepicker-here" data-language="es" type="text">');

        } 

        } else {

            $(this).html('<input class="editando" type="number" size="3" max="300" min="0" value="' + parseInt(texto) + '">');
        }
        var $input = $(this).find('.editando');

        $input.focus();

        $(this).click(function(event) {
            event.stopPropagation();
        });

        $('.latabla').off('click', 'td');
        $('.agregarlotedesplegable').off('click');
        $('.eliminarlotedesplegable').off('click');

        $('.latabla').on('click','.loteguardar', guardarCelda);
        //var _this = $(this);
        $('.lotecancelar').on('click', function(){cancelarCelda(event,texto,$(this))});


        $('.fecha > .editando').datepicker({
            format: "dd/mm/yyyy",
            endDate: "0d",
            maxViewMode: 3,
            todayBtn: "linked",
            clearBtn: true,
            language: "es",
            autoclose: false
        });



    
};


var identificarCelda = function(argument) {
    var $el = $('.editando');
    var idfila = 0;
    var colfila = 0;
    var tipofila = 0;

    var clases = $('.editando').parent().attr("class").split(' ');
    console.log(clases);
    var anterior = $el.parent().attr('id');
    console.log(anterior);

    colfila = clases[0] || 0;
    tipofila = clases[1] || 0;
    trow = $el.parent().parent();
    console.log(trow);
};

var cancelarCelda = function(event, datos, _this) {
    event.preventDefault();
    //if ($(this).parent().parent().parent().attr('id')) {
    if (datos) {
        //var datos = cargardatos();
        _this.parent().parent().text(datos);
    } else {
        //eliminarlotedesplegable();
        //var $este = $(this);
        //eliminarlotedesplegable($este);


        $(this).parent().parent().parent()
            .find('td')
            .wrapInner('<div style="display: block;" />')
            .parent()
            .find('td > div')
            .slideUp(700, function() {

                $(this).parent().parent().remove();

            });

    }
};
var botondelotes = `
        <tr class="rowagregarlotes">
            <td>
                <input type="button" value="agregar lote" class="agregarlotedesplegable">
            </td>
        </tr>
    `;


$('.latabla').on('click', '.lotes', function(event) {
    event.preventDefault();
    //console.log($(this));
    //console.log($(this).parent().next('.lotedatos'));
    if ($(this).parent().next('.lotedatos').length > 0 || $(this).parent().next('.rowagregarlotes').length > 0) {

        
        //$(this).parent().nextAll('.lotedatos:first, .rowagregarlotes:first').find('td')

        $(this).parent().nextAll('.lotedatos, .rowagregarlotes').find('td')
            .wrapInner('<div style="display: block;" />')
            .parent()
            .find('td > div')
            .slideUp(700, function() {

                $(this).parent().parent().remove();

            });
        
        
    } else {


        var idpro = $(this).parent().attr('id');

        $.ajax({
            type: 'get',
            url: '/lotes',
            data: {
                id: idpro,
                


            },

            dataType: 'json',
            complete: function() {},

            success: function(data) {
                //mostrarMensaje(data);
                var filasdesplegables= "";
                for(var i in data){

                filasdesplegables += `
                <tr class="lotedatos" colspan="6">
                    <td class="nombrelote">${data[i].numero}-${data[i].tipo}</td>
                    <td class="hora">${data[i].hora}</td>
                    <td class="reposicion g95">${(data[i].tipo=="G95")? data[i].cantidad : 0}</td>
                    <td class="reposicion g91">${(data[i].tipo=="G91")? data[i].cantidad : 0}</td>
                    <td class="reposicion dsl">${(data[i].tipo=="DSL")? data[i].cantidad : 0}</td>
                    <td colspan="2">
                        <input type="button" value="eliminar lote" class="eliminarlotedesplegable">
                    </td>
                </tr>
                    `;
                }
                var $filasdesplegables = $(filasdesplegables);
                $('#'+idpro)
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
            }
        });
    }
    //$('.desplegable').slideToggle('slow');
    //$(this).parent().parent().prevAll('.datos:first').after($filadesplegable);
    /*
    $(this > ).parent().parent()
     .find('td')
     .wrapInner('<div style="display: block;" />')
     .parent()
     .find('td > div')
     .slideUp(700, function(){

      $(this).parent().parent().remove();
      console.log($this);

     });
     */


});
var cargardatos = function() {
    var $el = $('.editando');

    var valornum = $el[0].value;
    var valortipo = $el[1].value;
    //console.log(valornum+' '+valortipo);

    var valor = valornum + '-' + valortipo;
    return valor;
};

var guardarCelda = function(event) {
    event.preventDefault();

    var $fila = $(this).parent().parent().parent();
    var $idproyeccion = $fila.prevAll('.datos:first').attr('id');

    $fila.attr('id', $idproyeccion);
    $fila.addClass($idproyeccion)

    var $el = $(this).parent().parent();
    var $editando = $el.find('.editando');

    var valornum = $editando[0].value;
    var valortipo = $editando[1].value;

    var valor = valornum + '-' + valortipo;


    if ($editando.hasClass('nombrelote')) {
        $el.attr('id', valor)
        //trow.find('.accion > a').attr('href', '/fila/'+valor+'/eliminar');
    }

    $el.text(valor);
    $el.css('background-color', '');
    //habilitarListeners();

};


var operaciones = function() {
idfila = trow.attr('id');

if (!valor || valor == "") {
    if ($el.parent().hasClass('nombrelote')) {

        $(this).parent().parent().css('background-color', 'gray');
    }
    valor = 0;
} else {

    var decimales = (colfila == 'inicial') ? 2 : 1;
    if (colfila == 'reposicion') {
        valor = parseInt(valor);
    } else if (colfila == 'reposicion' || colfila == 'inicial' || colfila == 'ventas') {
        valor = parseFloat(valor, decimales).toFixed(decimales);
    }

    $el.parent().text(valor);
    trow.css('background-color', '');
    //$('.latabla').on('click','td', editarCelda);
    $('.agregar').on('click', agregarFila);


    var texto = anterior || valor;
    }
};





var calcular = function() {

    var reposicionval = parseInt($('[id=\"' + idfila + '\"] .reposicion.' + clases[1]).text());
    var inicialval = parseFloat($('[id=\"' + idfila + '\"] .inicial.' + clases[1]).text(), 2);
    var ventasval = parseFloat($('[id=\"' + idfila + '\"] .ventas.' + clases[1]).text(), 1);

    var final = (reposicionval + inicialval) - ventasval;
    final = final.toFixed(1);

    $('[id=\"' + idfila + '\"] .final.' + clases[1]).text(final).effect('highlight', {}, 1000);

    if (final != 0) {
        var autotipo = [];
        autotipo['g95'] = 1.8;
        autotipo['g91'] = 2.8;
        autotipo['dsl'] = 1.2;
        var autonomia = final / autotipo[clases[1]];
        autonomia = Math.round(autonomia);
        $('[id=\"' + idfila + '\"] .autonomia.' + clases[1]).text(autonomia).effect('highlight', {}, 1000);
    }
};



var mandarDatos = function() {
    $.ajax({
        type: 'get',
        url: '/poliducto',
        data: {
            valor: valor,

            idfila: idfila,
            oldidfila: texto,
            colfila: colfila,
            tipofila: tipofila,
            lote_id: idfila,
            final: final,
            autonomia: autonomia


        },

        dataType: 'json',
        complete: function() {},

        success: function(data) {
            mostrarMensaje(data);
        }
    });
};





var editarCelda = function() {

    var texto = $(this).text();
    if (!$(this).hasClass('accion')) {



        if ($(this).hasClass('nombrelote')) {
            $(this).html('<input class="editando" type="text" size="5" value="' + texto + '">');
            $(this).attr('id', texto);

        } else if ($(this).hasClass('fecha')) {
            $(this).html('<input class="editando datepicker-here" data-language="es" type="text">');

        } else if ($(this).hasClass('autonomia')) {
            return;

        } else if ($(this).hasClass('final')) {
            return;

        } else if ($(this).hasClass('finala')) {

            $(this).html('<input class="editando" type="number" size="3" max="300" min="0" value="' + parseInt(texto) + '">');
        }
        var $el = $(this).find('input');

        $el.focus();
        $el.click(function(event) {
            event.stopPropagation();
        });
        //$('.latabla').off('click', 'td');
        //$('.agregar').off('click');


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

//**********************************************************************************
var agregarFila = function() {

    if ($('.sinregistros')) { $('.sinregistros').html('') };

    $('.latabla tr:last').after(elhtml);
    $('.latabla tr:last').css('background-color', 'gray');
    $('.agregar').off('click');
    $('.latabla').off('click', 'td');

    var el = $('.editando');

    el.click(function(event) {
        event.stopPropagation();
    });
    el.focus();

};
    
@can('editar_lotes')

                            $('.latabla ').on('click','.nombrelote', editarLote);
                            
@endcan

@can('agregar_lotes')   
                                    
                            //$('.agregar').on('click',agregarFila);
@endcan

@can(['agregar_lotes','agregar_lotes'])  

//$('.latabla').on('blur','.editando', guardarDatoCelda);
//$('.latabla').on('blur','.editando', guardarCelda);
$('.latabla').on('click','.loteguardar', guardarCelda);
$('.latabla').on('click','.lotecancelar', cancelarCelda);
$('.latabla').on('click','.eliminarlotedesplegable', eliminarlotedesplegable);
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