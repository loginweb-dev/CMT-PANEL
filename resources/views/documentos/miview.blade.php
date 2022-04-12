@extends('voyager::master')

@section('css')
@stop

@php
	$midata = App\Documento::where('id', $id)->first();
	$copia = App\RelUserDoc::where('document_id', $midata->id)->get();
@endphp

@section('page_header')
	<h1 class="page-title">
		<i class="voyager-helm"></i>
		Compartir o Derivar
	</h1>
@stop

@section('content')
	 <div class="container-fluid">
		<div class="row text-center">
			{{-- <code>
				{{ $midata }}
			</code> --}}
			@switch($midata->estado_id)
				@case(1)
					<a href="#" onclick="derivar('{{ $midata->id }}')" class="btn btn-dark">Derivar</a>
					@break
				@case(2)
					<a href="#" onclick="derivar('{{ $midata->id }}')" class="btn btn-primary">Responder</a>
					<a href="#" onclick="derivar_a_terceros('{{$midata->id}}')"data-toggle="modal" data-target="#derivar_a_terceros" class="btn btn-success">Derivar</a>
					<a href="#" onclick="derivar('{{ $midata->id }}')" class="btn btn-danger">Rechazar</a>
					<br>
				
						<div class="col-sm-4 form-group">
							Mensaje Recibido: <p>{{ $midata->message }}</p>
							<textarea class="form-control"></textarea>
						</div>
						
						<div class="col-sm-4 form-group">
							<label for="">Image</label>
							<input type="file" name="" id="" class="form-control">
						</div>
						<div class="col-sm-4 form-group">
							<label for="">PDF</label>
							<input type="file" name="" id="" class="form-control">
						</div>
		
					@break
				@default
					
			@endswitch
		</div>
		<div class="row">
			<div class="col-sm-6">
			
				<table class="table table-responsive">
					<tbody>
						<tr>
							<td>ID</td>
							<td>{{ $midata->id }}</td>
						</tr>
						<tr>
							<td>PDF</td>
							<td>{{ $midata->pdf }}</td>
						</tr>
						<tr>
							<td>Estado</td>
							<td>{{ $midata->estado->name }}</td>
						</tr>
						<tr>
							<td>Tipo</td>
							<td>{{ $midata->tipo }}</td>
						</tr>
						<tr>
							<td>Remitente</td>
							<td>{{ $midata->remitente_externo ? $midata->remitente_externo->display : $midata->remitente_interno->name}}</td>
						</tr>
						<tr>
							<td>Description</td>
							<td>{{ $midata->description }}</td>
						</tr>
						<tr>
							<td>Destinatario</td>
							<td>{{ $midata->destinatario->name }}</td>
						</tr>
						<tr>
							<td>Copia Destinatarios</td>
							<td>
								@foreach ($copia as $item)
									@php 
										$user = TCG\Voyager\Models\User::where('id', $item->user_id)->first();								
									@endphp
									- {{ $user->name }} <br>
								@endforeach
							</td>
						</tr>
						<tr>
							<td>Catagoria</td>
							<td>{{ $midata->categoria->name }}</td>
						</tr>
						<tr>
							<td>Creado</td>
							<td>{{ $midata->created_at }}</td>
						</tr>
						<tr>
							<td>Actualizado</td>
							<td>{{ $midata->updated_at }}</td>
						</tr>
						<tr>
							<td>Editor</td>
							<td>{{ $midata->editor->name }}</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="col-sm-6 text-cneter">
				<img class="img-responsive" src="{{ setting('admin.url').'storage/'.$midata->archivo }}" alt="">
			</div>
		</div>
	
	</div>


	<!-- -------------------MODALES----------------------- -->
    <!-- -------------------MODALES----------------------- -->

	<div class="modal fade modal-primary" id="derivar_a_terceros">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"
							aria-hidden="true">&times;</button>
				<h4>Derivar a Otros </h4>
				</div>
				<div class="modal-body">

					{{-- <ul class="nav nav-tabs" role="tablist">
						<li role="presentation" class="active"><a href="#miderivar" aria-controls="miderivar" role="tab" data-toggle="tab"></a></li>
						<li role="presentation"><a href="#deliverys" aria-controls="deliverys" role="tab" data-toggle="tab">Deliverys</a></li>
						
					</ul> --}}

					<div class="tab-content">
						<div role="tabpanel" class="tab-pane active" id="miderivacion">

							<table class="table table-striped table-inverse table-responsive" id="derivaciones_otros">
								<thead class="thead-inverse">
									<tr>
										<th>ID</th>
										<th>Motivo de Derivación</th>
										<th>Destinatario</th>
										<th>Creado</th>
										<th>Acción</th>
									</tr>
								</thead>
								<tbody></tbody>
							</table>

						</div>

						{{-- <div role="tabpanel" class="tab-pane" id="deliverys">
							<input id="venta_id" type="hidden" class="form-control" hidden>
							<select id="mideliverys" class="form-control"></select>
							<a href="#" class="btn btn-sm btn-primary" onclick="save_set_chofer()">Asignar</a>
						</div> --}}
					</div>
				  
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>
					
				</div>
			</div>
		</div>
	</div>

@stop


@section('javascript')
	<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
	<script>
		async function derivar(id) {
			var midata = JSON.stringify({ documento_id: id, estado_id: 2 })
			var derivar = await axios("https://panel.cmt.gob.bo/api/derivar/"+midata)
			// console.log(derivar.data)
			location.reload()
		}

		async function derivar_a_terceros(id){
			$('#derivaciones_otros tbody').empty();

			$("#derivaciones_otros").append("<tr><td>"+id+"</td><td>"+'Mensaje'+"</td><td>"+'Seleccionar Destinatario'+"</td><td>"+'Fecha'+"</td><td>"+'Agregar mas Destinatario'+"</td></tr>");
		}
	</script>
@stop