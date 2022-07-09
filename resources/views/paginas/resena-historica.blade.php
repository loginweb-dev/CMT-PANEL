@extends('master')

@section('content')

<section>
	<div class="container">
		<div class="row" data-aos="zoom-in">
			<div class="col-sm-6 mt-3">
				<h3>RESEÑA HISTÓRICA</h3>
				<p style="text-align: justify">
					Desde el siglo XVII, el territorio del Beni se constituye en área de expansión colonial militar y religiosa, es así que el año 1686 se crea a orillas del Río Mamoré la Santísima Trinidad por el padre Cipriano Barace como la 2da reducción de la Compañía de Jesús.
				</p>
				<p style="text-align: justify">
					Hacia 1701, se crean los Cabildos de cada misión como gobierno local y con la función de mediación entre los jesuitas y la sociedad indígena. (Lehm; 2000).
				</p>
				<p style="text-align: justify">
					En 1769 debido a la situación desfavorable por las inundaciones, la Santísima Trinidad fue trasladada a unos 14 kilómetros, donde se encuentra actualmente.
				</p>
				<p style="text-align: justify">
					El 8 de julio de 1849 se crea el Honorable Concejo Municipal, el primer presidente fue el gobernador José María Aguilar, Vicepresidente el Tcnl. Alejo Anglada, Alcalde el cura de San Pedro R.P. José Lorenzo de Rivero, el Decano el Sr. Mariano Jiménez. El acto de posesión se realizó en el Salón de audiencias de la Prefectura. (Extractado del libro “Algo para Recordar” de la Sra. Dora Ortiz Aponte).
				</p>
				<p>
					A continuación la relación de personas que presidieron el Concejo Municipal de Trinidad:
				</p>
			</div>
			<div class="col-sm-6 mt-3">
				<h3>GESTIONES</h3>
				@php
					$gestiones = App\Gestione::orderBy('created_at', 'desc')->get();
				@endphp
				<ul>
					@foreach ($gestiones as $item)
						<li>{{ $item->title }}</li>
					@endforeach
				</ul>
			</div>
			
		</div>
		{{-- <div class="row" data-aos="zoom-in">

			<div class="col-sm-6">
				<h4>GESTIONES</h4>
				<ul>
					<li>1900: Dr. Juan Ernesto Daza Palmero</li>
				</ul>
			</div>
			<div class="col-sm-6">

			</div>
		</div> --}}
	</div>
</section>

@endsection