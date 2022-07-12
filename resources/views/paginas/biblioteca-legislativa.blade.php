@extends('master')

@section('content')
<section class="mt-5">
	<div class="container">
		
	  <div class="row" data-aos="zoom-in">
		<div class="col-sm-4 text-center text-lg-start">
		  <h3>GACETA OFICIAL</h3>
		  <p style="text-align: justify">Archivos digitales en formato PDF de las Leyes Autonómicas Municipales, las Resoluciones Municipales y las Ordenanzas Municipales del Concejo Municipal de la Santísima Trinidad.</p>
		  <h4>Resoluciones Municipales</h4>
		  <p style="text-align: justify">Las Resoluciones Municipales son normas de carácter interno y gestión administrativa del Gobierno Autónomo Municipal. Tienen carácter vinculante y son de cumplimiento obligatorio, son aprobadas por el voto de la mayoría absoluta de los Concejales y las Concejalas Municipales presentes, salvando los casos previstos por la Constitución Política del Estado y los Reglamentos especiales. </p>
		  <h4>Leyes Autonómicas Municipales</h4>
		  <p style="text-align: justify">La Ley Municipal es la disposición legal que emana del Concejo Municipal en ejercicio de su facultad legislativa, cumpliendo de forma estricta el procedimiento, requisitos y formalidades establecidos por Ley. Es de carácter general y su aplicación y cumplimiento es obligatorio desde el momento de su publicación en la Gaceta Municipal. </p>
		  <h4>Ordenanzas Municipales</h4>
		  <p style="text-align: justify">Las Ordenanzas Municipales es el equivalente a lo que ahora son las Leyes Autonómicas Municipales. El 20 de mayo de 2015 se promulgó la última Ordenanza Municipal. </p>
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

	/* A function that is called when the user presses a key on the keyboard. It is responsible for making
	a request to the API and displaying the results in the table. */
	$('#mibuscar').keyup(async function (e) {
		if (e.keyCode == 13) {
		  var result = await axios.post('https://cmt.gob.bo/api/gacetas/buscar', {criterio: this.value})
		  $("#mitable tbody tr").remove();
		  toastr.success('Resultados: '+result.data.length)
		  for (let index = 0; index < result.data.length; index++) {
			$("#mitable").append("<tr id="+result.data[index].id+"><td>"+result.data[index].name+"</td><td>"+result.data[index].categoria.name+"</td><td>"+result.data[index].gestion+"</td><td><a class='btn-boton' href='https://panel.cmt.gob.bo/storage/"+result.data[index].file+"'>Ver</a></td></tr>")
		  }
		}
	});
	
	
	/**
 	* It makes an HTTP request to the API, then it removes all the rows from the table, then it loops
 	* through the response and adds a new row for each item in the response
 	*/
	async function cargar() {
		var result = await axios('https://cmt.gob.bo/api/gacetas')
		$("#mitable tbody tr").remove();
		for (let index = 0; index < result.data.length; index++) {
		  $("#mitable").append("<tr id="+result.data[index].id+"><td>"+result.data[index].name+"</td><td>"+result.data[index].categoria.name+"</td><td>"+result.data[index].gestion+"</td><td><a class='btn-boton' href='https://cmt.gob.bo/storage/"+result.data[index].file+"'>Ver</a></td></tr>")
		}
		$("#mitable").append("<tr><td colspan='4'>Mostrando los Ultimos "+result.data.length+" Registros</td></tr>")
		var totales = await axios('https://cmt.gob.bo/api/gacetas/totales')
		$("#mitable").append("<tr><td colspan='4'>Total Registros "+totales.data.total+"</td></tr>")
	}
	
	/**
	* It takes the data from the API and adds it to the select element
	*/
	async function categorias() {
		var catg = await axios('https://cmt.gob.bo/api/catgacetas')
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
  
	/* A function that is called when the user clicks on the search button. It is responsible for making a
	request to the API and displaying the results in the table. */
	async function consulta() {
		$("#mitable tbody tr").remove();
		var categoria = $("#category").val();
		var gestion = $("#gestion").val();
		var result = await axios.post('https://cmt.gob.bo/api/gacetas/filtro', {categoria: categoria, gestion: gestion})
		toastr.success('Resultados: '+result.data.length)
		for (let index = 0; index < result.data.length; index++) {
		  $("#mitable").append("<tr id="+result.data[index].id+"><td>"+result.data[index].name+"</td><td>"+result.data[index].categoria.name+"</td><td>"+result.data[index].gestion+"</td><td><a class='btn-boton' href='https://cmt.gob.bo/storage/"+result.data[index].file+"'>Ver</a></td></tr>")
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