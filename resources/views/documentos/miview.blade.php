@extends('voyager::master')

@section('css')
@stop

@section('page_title', 'Mi Vista'))

@php
	$tipo = App\Documento::find($id);
	if ($tipo->tipo == 'Externo') {
		$midata = App\Documento::where('id', $id)->first();
		$copia = App\RelUserDoc::where('document_id', $midata->id)->get();
	} else {
		$midata = App\Documento::where('id', $id)->first();
		$copia = App\RelUserDoc::where('document_id', $midata->id)->get();
	}
@endphp

@section('page_header')
	<h1 class="page-title">
		<i class="voyager-helm"></i>
		Compartir o Derivar
		
	</h1>
	<span>{{ $midata->name }}</span>
@stop

@section('content')
	 <div class="container-fluid">
		<div class="row text-center">
			@switch($midata->estado_id)
				@case(1)
					<a href="#" onclick="derivar('{{ $midata->id }}')" class="btn btn-dark">Derivar</a>
					@break
				@case(2)
					<a href="#" onclick="derivar('{{ $midata->id }}')" class="btn btn-primary">Responder</a>
					<a href="#" onclick="derivar('{{ $midata->id }}')" class="btn btn-success">Rechazar</a>
					@break
				@default
					
			@endswitch
			
			{{-- <a href="#" class="btn btn-default">Whatsapp</a>
			<a href="#" class="btn btn-default">Correo</a> --}}
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
	</script>
@stop