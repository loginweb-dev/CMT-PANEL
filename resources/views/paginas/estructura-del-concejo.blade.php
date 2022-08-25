@extends('master')

@section('content')


<section class="mt-5" data-aos="zoom-in">
	<div class="container">
	  <div class="row">
		<h3 class="text-center">ESTRUCTURA DEL CONCEJO</h3>
		<div class="col-lg-6 mt-3">
		  <img src="https://cmt.gob.bo//storage/landingpage/estructura.jpg" class="img-fluid" alt="">
		</div>
		<div class="col-lg-6 d-flex flex-column justify-contents-center mt-3" data-aos="fade-left">
		  <div class="content pt-4 pt-lg-0">
			{{-- <h3>Learn more about us</h3> --}}
			<p style="text-align: justify">
				El Pleno del Concejo Municipal es el conjunto de Concejales y Concejalas Municipales, que constituyen la máxima autoridad de decisión. Tiene esencia democrática, es representativo, deliberante, legislativo y fiscalizador, considera, aprueba y/o rechaza las políticas y decisiones del Municipio mediante Leyes Municipales, Resoluciones Municipales, Informes, Minutas, Proveídos y otros instrumentos normativos señalados para el efecto.
			</p>
			{{-- <ul>
			  <li><i class="bi bi-check-circle"></i> Ullamco laboris nisi ut aliquip ex ea commodo consequat.</li>
			  <li><i class="bi bi-check-circle"></i> Duis aute irure dolor in reprehenderit in voluptate velit.</li>
			  <li><i class="bi bi-check-circle"></i> Ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate trideta storacalaperd</li>
			</ul>
			<p>
			  Ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate tera noden carma palorp mades tera.
			</p> --}}
		  </div>
		</div>
	  </div>
	</div>
</section>

<section id="features" class="features">
	<div class="container">
	  <div class="row">
		<div class="col-lg-6 mt-2 mb-tg-0 order-2 order-lg-1">
		  <ul class="nav nav-tabs flex-column">
			<li class="nav-item" data-aos="fade-up">
			  <a class="nav-link active show" data-bs-toggle="tab" href="#tab-0">
				<h4>NUESTROS CONCEJALES</h4>
				{{-- <p>Quis excepturi porro totam sint earum quo nulla perspiciatis eius.</p> --}}
			  </a>
			</li>
			@foreach ($concejales as $item)
				<li class="nav-item" data-aos="fade-up" data-aos-delay="100">
					<a class="nav-link" data-bs-toggle="tab" href="#tab-{{ $item->id }}">
						<p>{{ $item->titular }}</p>
						{{-- <p>Voluptas vel esse repudiandae quo excepturi.</p> --}}
					</a>
				</li>
			@endforeach
		  </ul>
		</div>
		<div class="col-lg-6 order-1 order-lg-2" data-aos="zoom-in">
		  <div class="tab-content">
			<div class="tab-pane active show" id="tab-0">
			  <figure>
				<img src="https://cmt.gob.bo//storage/landingpage/BannerPrincipal.jpeg" alt="" class="img-fluid">
			  </figure>
			</div>

			@foreach ($concejales as $item)			
				<div class="tab-pane" id="tab-{{ $item->id }}">
				<figure>
					<img src="storage/{{ $item->image }}" alt="" class="img-fluid img-responsive" width="100%">
				</figure>
				</div>
			@endforeach
		  </div>
		</div>
	  </div>
	</div>
</section>

<section class="" data-aos="zoom-in">
	<div class="container">
	  <div class="row">
		<h3 class="text-center">LA DIRECTIVA</h3>
		<div class="col-lg-6 mt-3">
		  <img src="https://cmt.gob.bo//storage/landingpage/ladirectiva.jpg" class="img-fluid" alt="">
		</div>
		<div class="col-lg-6 d-flex flex-column justify-contents-center mt-3" data-aos="fade-left">
		  <div class="content pt-4 pt-lg-0">
			<p style="text-align: justify">
				La Directiva del Concejo Municipal es la segunda instancia de jerarquía institucional. Está conformada por un Presidente o una Presidenta, un Vicepresidente o una Vicepresidenta y un Secretario o una Secretaria, quienes tienen la finalidad de gestionar y facilitar las decisiones adoptadas por el Pleno del Concejo Municipal.
			</p>
		  </div>
		</div>
	  </div>
	</div>
</section>


@endsection