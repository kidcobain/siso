{{--dd($lotes)--}}
{{-- dd($lotes->proyeccion) --}}
{{--
 @foreach($lotes as $lote)
            <p>
                {{ $lote->numero }}
            </p>
            <ul>
            @foreach($lote->proyeccion as $pro)
                <li>
                    <strong>{{ $pro->id }}</strong>
                    {{ $pro->tipo}}
                </li>
            @endforeach
            </ul>
        @endforeach
--}}


{{'hello'}}

	{{-- 
	@foreach($lotes as $lote)
	    <li>
	        <strong>{{ $lote->id }}</strong>
	        {{ App\proyeccion::where('lote_id', $lote->id)->firstOrFail()}}
	    </li>
	@endforeach
	 --}}


@foreach($lotes as $lote)
            <p>
                {{ $lote->numero }}
            </p>
            <ul>
            @foreach($lote->proyeccion as $pro)
            	 {{ $proyection = collect($pro)}}

            	  @php
            	  $resultado = $pro::where('lote_id', $lote->id)
            	  ->where('tipo','inicial')->first();

            	  $res = App\proyeccion::where('lote_id', $lote->id)
            	  ->where('tipo','inicial')->first();

            	  @endphp
            	  	{{ $resultado->tipo }}
            	  	{{ $resultado->g95 }}
					

            	            	
                <li>
                    <strong>{{ $pro->id }}</strong>
                    {{ $pro->tipo}}
                </li>
            @endforeach
            </ul>
        @endforeach
 	
 