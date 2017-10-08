@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                buscar 
                <form action="/buscarlote" method="get">
                <input name="numero" type="text">
                <input type="submit" value="buscar">
                    
                </form>
                <div class="panel-heading">proyeccion</div>

                <div class="panel-body">
                        <table class="latabla table table-bordered table-striped table-responsive">
                            <tr>
                                <tr>
                                    <th>lote</th>
                                    <th colspan="3">Reposicion por poliducto</th>
                                    <th colspan="3">Inventario inicial</th>
                                    <th colspan="3">Inventario final</th>
                                    <th colspan="3">Autonomia</th>
                                    <th colspan="1">accion</th>
                                </tr>
                                <tr>
                                    <th>nombre</th>
                                    <th>G95</th> <th>G91</th> <th>DSL</th>
                                    <th>G95</th> <th>G91</th> <th>DSL</th>
                                    <th>G95</th> <th>G91</th> <th>DSL</th>
                                    <th>G95</th> <th>G91</th> <th>DSL</th>
                                    <th>accion</th>
                                </tr>
                                @foreach ($lotes as $lote)           
                                    <tr class="datos" id="{{ $lote->numero}}">
                                        <td class="nombrelote">{{ $lote->numero}}</td>

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

                                        <td class="reposicion G95">{{ $proreposicion->g95?$proreposicion->g95:0 }}</td>
                                        <td class="reposicion G91">{{ $proreposicion->g91 }}</td>
                                        <td class="reposicion DSL">{{ $proreposicion->dsl }}</td>

                                        <td class="inicial G95">{{ $proinicial->g95 }}</td>
                                        <td class="inicial G91">{{ $proinicial->g91 }}</td>
                                        <td class="inicial DSL">{{ $proinicial->dsl }}</td>

                                        <td class="final G95">{{ $profinal->g95 }}</td>
                                        <td class="final G91">{{ $profinal->g91 }}</td>
                                        <td class="final DSL">{{ $profinal->dsl }}</td>

                                        <td class="autonomia G95">{{ $proautonomia->g95 }}</td>
                                        <td class="autonomia G91">{{ $proautonomia->g91 }}</td>
                                        <td class="autonomia DSL">{{ $proautonomia->dsl }}</td>

                                        <td class="accion"><a href="/fila/{{ $lote->numero}}/eliminar"> ELIMINAR</a></td>
                                        @break
                                        @endforeach
                                    </tr>
                                @endforeach
                            
                            </tr>
                        </table>
                        <p></p>
                        <input type="button" class="agregar" value="agregar nueva fila">

                            
                    </body>
                    <script src="js/jquery-2.1.4.js" type="text/javascript"></script>
                    <script src="js/bootstrap-datepicker.js"></script>
                    <script src="js/bootstrap-datepicker.es.min.js" type="text/javascript"></script>
                    <script src="js/jquery.maskedinput.min.js" type="text/javascript"></script>
                        <script>
                            var elhtml = ' \
                                <tr class="datos " id="">  \
                                    <td class="nombrelote"><input class="editando" type="text" size="5"/></td> \
                     \
                                    <td class="reposicion G95">0</td> \
                                    <td class="reposicion G91">0</td> \
                                    <td class="reposicion DSL">0</td> \
                     \
                                    <td class="inicial G95">0</td> \
                                    <td class="inicial G91">0</td> \
                                    <td class="inicial DSL">0</td> \
                     \
                                    <td class="final G95">0</td> \
                                    <td class="final G91">0</td> \
                                    <td class="final DSL">0</td> \
                     \
                                    <td class="autonomia G95">0</td> \
                                    <td class="autonomia G91">0</td> \
                                    <td class="autonomia DSL">0</td> \
                                    <td class="accion"><a href="/eliminarfila/"> ELIMINAR</a></td> \
                                </tr> \
                            ';

                        $(document).ready(function() {
                            
                            
                            
                                    

                            var editarCelda = function () {

                                 texto = $(this).text();
                                if($(this).hasClass('accion')){

                                }

                                else{


                                $(this).html('<input class="editando" type="text" size="5" value="'+texto+'">');
                                var $el = $(this).find('input');

                                    $el.focus();
                                    $el.click(function(event){
                                        event.stopPropagation();
                                    });
                                    $('.latabla').off('click','td');
                                $('.agregar').off('click');
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
                                var $el = $('.editando');

                                var valor = $el.val();
                                console.log(valor);

                                var idfila = 0;
                                var colfila = 0;
                                var tipofila = 0;

                                // $(element).attr("class").split(' ');
                                 var clases = $('.editando').parent().attr("class").split(' ');
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

                                                success: function(){
                                                    //alert('exito');
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

                                
                                

                            
                        });
                        </script>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
