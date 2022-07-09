@extends('master')

@section('content')
<section class="mt-5">
	<div class="container">		
		<div class="row" data-aos="zoom-in">
			<h3 class="text-center">CONCEJALES DEL ÓRGANO DELIBERATIVO, FISCALIZADOR Y LEGISLATIVO 2021/2026</h3>			
			<p style="text-align: justify">
				El Concejo Municipal de Trinidad, en uso de sus atribuciones que le confiere La Constitución Política del Estado, la Ley de Gobiernos Autónomos Municipales, Ley Marco de Autonomías y Descentralización y Ley de Régimen Electoral Que, el Art. 11 del Reglamento General del Concejo Municipal de la ciudad de Trinidad establece la Elección y Posesión de la Directiva disponiendo que se realizará en la primera sesión del Concejo mediante voto oral y nominal y por mayoría absoluta de los miembros titulares; el mismo artículo establece que La Directiva titular se encuentra compuesta por un Presidente (a), un Vicepresidente (a) y un Secretario (a).
			</p>
			{!! $reglamento->body !!}
		</div>
	</div>
</section>
@endsection

@section('javascript')
  <script>

  </script>
@endsection