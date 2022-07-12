@extends('master')

@section('content')
	<section class="mt-5">
		<div class="container">
			
		<div class="row" data-aos="zoom-in">
			<div class="col-sm-4">
				<h3>CONVOCATORIA A SESIONES</h3>
				<p style="text-align: justify">El Presidente o la Presidenta del Concejo Municipal, convocará por escrito a sesión Ordinaria y Extraordinaria mediante Convocatoria Pública. La convocatoria para sesiones ordinarias se publicará en el tablero del Concejo Municipal. Las Sesiones Extraordinarias serán necesariamente publicadas en un medio de comunicación escrito, pudiendo prescindirse de estos requisitos, en caso de emergencia o desastre que afecten a la población, o al territorio del Gobierno Autónomo Municipal.</p>
				<div class="portfolio-details-slider swiper">
					<div class="swiper-wrapper align-items-center">
		
						<div class="swiper-slide">
							<h4>1. Convocatorias a Sesiones Ordinarias</h4>
							<p style="text-align: justify">
							Las Sesiones Ordinarias son reuniones que realiza el Concejo Municipal para la gestión ordinaria del ejercicio de sus atribuciones y competencias. Tienen carácter público y se llevan a cabo los días y horas hábiles definidos en la Convocatoria por lo menos dos veces por semana, a convocatoria de su Presidente o su Presidenta, fijando lugar, día y hora, de manera pública y escrita, debiendo citarse con 24 horas de anticipación.
							</p>
						</div>
						<div class="swiper-slide">
							<h4>2. Convocatorias a Sesiones Extraordinarias</h4>
							<p style="text-align: justify">
								Las Sesiones Extraordinarias son aquellas reuniones del Concejo Municipal convocadas de manera pública por su Presidente o su Presidenta, cuando menos con 48 horas de anticipación, sujetas a término específico y adjuntando antecedentes. 
							</p>
						</div>

						<div class="swiper-slide">
							<h4>3. Convocatorias a Actos Protocolares</h4>
							<p style="text-align: justify">
								Los Actos Protocolares, constituyen reuniones del Pleno del Concejo Municipal para realizar celebraciones, conmemoraciones, condecoraciones y distinciones especiales. Tienen carácter protocolar. No tienen carácter deliberante y constituyen un acto de cumplimiento formal y obligatorio por parte de todos los Concejales y las Concejalas Municipales. Se dispone su realización por mayoría absoluta de los miembros del Concejo Municipal y de acuerdo a temario especial aprobado para el efecto </p>
						</div>


						<div class="swiper-slide">
							<h4>4. Convocatorias a Audiencias Públicas </h4>
							<p style="text-align: justify">Las Audiencias Públicas son aquellas reuniones públicas, que realiza el Pleno y las Comisiones, distintas de las sesiones del Concejo Municipal, en las cuales se recibe a las personas individuales y/o colectivas, a objeto de escuchar y recepcionar sus solicitudes, necesidades y planteamientos sobre temas de competencia municipal y relativos al cumplimiento de sus atribuciones. Se realizarán como mínimo una vez al mes y serán notificadas a todos los Concejales y Concejalas Municipales con veinticuatro (24) horas de anticipación, siguiendo los mismos procedimientos para las sesiones ordinarias. </p>
						</div>

					</div>
					<div class="swiper-pagination"></div>
				</div>
				
			</div>

			<div class="col-sm-8 text-center text-lg-start">
				<table class="table">
					<tr>
					<td>
						<label for="">Categorias</label>
						<select name="category" id="category" class="form-control">
						</select>
					</td>
					<td>
						<label for="">Gestiones</label>
						<input class="form-control" type="search" name="text" id="gestion" placeholder="Gestion" value="2022">
					</td>
					<td>  
						<label for=""></label>
						<a class="form-control btn-boton" href="#" onclick="consulta()">Filtrar</a>
					</td>
					</tr>
					<tr>
					<td colspan="3">
						<input class="form-control" type="text" name="mibuscar" id="mibuscar" placeholder="Buscar">
					</td>
					</tr>
				</table>
				<table class="table table-responsive table-striped"  id="mitable">
					<thead>
					<tr>
						<th scope="col">Titulo</th>
						<th scope="col">Categoria</th>
						<th scope="col">Gestion</th>
						<th scope="col">Documento</th>
					</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>
		</div>
		
		</div>
	</section>
@endsection

@section('javascript')
  <script>
		$(document).ready(function() {
		cargar()
		categorias()
	});

	$('#mibuscar').keyup(async function (e) { 
		if (e.keyCode == 13) {
		  var result = await axios.post('https://cmt.gob.bo/api/convocatorias/buscar', {criterio: this.value})
		//   console.log(result.data)
		  $("#mitable tbody tr").remove();
		  toastr.success('Resultados: '+result.data.length)
		  for (let index = 0; index < result.data.length; index++) {
			$("#mitable").append("<tr id="+result.data[index].id+"><td>"+result.data[index].name+"</td><td>"+result.data[index].categoria.name+"</td><td>"+result.data[index].gestion+"</td><td><a class='btn-boton' href='https://cmt.gob.bo/storage/"+result.data[index].file+"'>Ver</a></td></tr>")
		  }
		}
	  });
	  async function cargar() {
		var conv = await axios('https://cmt.gob.bo/api/convocatorias')
		$("#mitable tbody tr").remove();
		for (let index = 0; index < conv.data.length; index++) {
		  $("#mitable").append("<tr id="+conv.data[index].id+"><td>"+conv.data[index].name+"</td><td>"+conv.data[index].categoria.name+"</td><td>"+conv.data[index].gestion+"</td><td><a class='btn-boton' href='https://cmt.gob.bo/storage/"+conv.data[index].file+"'>Ver</a></td></tr>")
		}
		$("#mitable").append("<tr><td colspan='4'>Mostrando los Ultimos "+conv.data.length+" Registros</td></tr>")
		var totales = await axios('https://cmt.gob.bo/api/convocatorias/totales')
		$("#mitable").append("<tr><td colspan='4'>Total Registros "+totales.data.total+"</td></tr>")
	  }
  
	  async function categorias() {
		var catg = await axios('https://cmt.gob.bo/api/catconvocatoria')
		$('#category').append($('<option>', {
			value: 0,
			text: 'Elige una Categoria'
		}));
		for (let index = 0; index < catg.data.length; index++) {
			$('#category').append($('<option>', {
				value: catg.data[index].id,
				text: catg.data[index].name
			}));
		}
	  }
  
	  async function consulta() {
		$("#mitable tbody tr").remove();
		var categoria = $("#category").val();
		var gestion = $("#gestion").val();
		var result = await axios('https://cmt.gob.bo/api/convocatorias/filtro/'+categoria+'/'+gestion)
		toastr.success('Resultados: '+result.data.length)
		for (let index = 0; index < result.data.length; index++) {
		  $("#mitable").append("<tr id="+result.data[index].id+"><td>"+result.data[index].name+"</td><td>"+result.data[index].categoria.name+"</td><td>"+result.data[index].gestion+"</td><td><a class='btn-boton' href='https://panel.cmt.gob.bo/storage/"+result.data[index].file+"'>Ver</a></td></tr>")
		}
	  }
	  $('#category').change(function (e) { 
		e.preventDefault();

		if (this.value) {
			cargar()
		}
	});
  </script>
@endsection