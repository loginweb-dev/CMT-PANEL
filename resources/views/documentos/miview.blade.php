@extends('voyager::master')

@section('css')
@stop

@php
	$midata = App\Documento::where('id', $id)->first();
	$copia = App\RelUserDoc::where('documento_id', $midata->id)->get();
	$derivadores=App\RelDerivDoc::where('documento_id', $midata->id)->get();
	$remitente_interno= $midata->remitente_interno ? $midata->remitente_interno->id : null ;
	$remitente_externo= $midata->remitente_externo ? $midata->remitente_externo->id : null ;
	
	$copias=[];
	foreach ($copia as $item) {
		array_push($copias,$item->user_id);
	}

	$deriv=[];
	foreach ($derivadores as $item) {
		array_push($deriv,$item->user_id);
	}
@endphp

@section('page_header')
	<h1 class="page-title">
		<i class="voyager-helm"></i>
		Compartir o Derivar
	</h1>
@stop

@section('content')
	 <div class="page-content edit-add container-fluid">
		<div class="row text-center">
			{{-- <code>
				{{ $midata }}
			</code> --}}
			@if($midata->estado_id!=1)
				@if(Auth::user()->role_id == 3 OR Auth::user()->role_id == 1 OR Auth::user()->id == $midata->editor_id OR in_array(Auth::user()->id, $copias) OR in_array(Auth::user()->id, $deriv) OR $midata->destinatario_id== Auth::user()->id)
					<div class="col-sm-6 form-group">		
						<div class="col-sm-12 form-group">
							<a data-toggle="modal" data-target="#arbol_detalle" class="btn btn-primary">Flujograma de Correspondencia</a>
						</div>
					</div>
				@endif
			@endif
			@switch($midata->estado_id)
				@case(1)
					@if($midata->editor_id== Auth::user()->id)
						{{-- <a  onclick="derivar('{{ $midata->id }}')" class="btn btn-dark">Derivar</a> --}}
						<button onclick="derivar('{{ $midata->id }}')" class="btn btn-dark">Derivar <i class="voyager-forward"></i></button>

					@endif
					@break
				@case(2)
					{{-- <a href="#" onclick="derivar_a_terceros('{{$midata->id}}')"data-toggle="modal" data-target="#derivar_a_terceros" class="btn btn-dark">Derivar a Otros</a> --}}
						
						@if($midata->destinatario_id== Auth::user()->id)
							<div class="col-sm-6 form-group">
								<div class="col-sm-12 form-group">
									<a data-toggle="modal" data-target="#AccionesDestinatario" class="btn btn-dark">Acciones</a>
								</div>
							</div>
						@endif


					@break
				@default

			@endswitch
		</div>
		<div class="row">
		
			<div class="col-sm-12">
				<div class="panel panel-bordered">
                {{-- <div class="form-group col-md-4">
                    <label for="">Imagen Auxiliar</label>
                    <select class="form-control js-example-basic-single" value="{{$midata->archivo}}" name="user_remitente" id="user_remitente"></select>
                </div>

                <input type="text" class="form-control" id="total_ventas" value="{{$midata->archivo}}" readonly>
 --}}			
			
							

			

					<table class="table table-responsive">
						
						<thead>
							<td><h5>Remitente</h5> </td>
							<td><h5>Destinatario</h5></td>
							<td><h5>Categoria</h5></td>
							<td><h5>Estado</h5></td>
						</thead>
						<tbody>
							<tr>
								<td>{{ $midata->remitente_externo ? $midata->remitente_externo->display : $midata->remitente_interno->name}}</td>
								<td>{{ $midata->destinatario->name }}</td>
								<td>{{ $midata->categoria->name }}</td>
								<td>{{ $midata->estado->name }}</td>
							</tr>
						
						
						
						</tbody>
					</table>
					<div class="col-sm-6">
						<table class="table table-responsive">
						
							
							<thead>
								<td><h5>Mensaje</h5></td>
							</thead>						
							<tbody>
								<tr>
									<td>
										<textarea id="editor_prueba" class="form-control richTextBox" cols="70" rows="10" readonly>{{$midata->message}}</textarea>
									</td>
								</tr>
							</tbody>
						</table>
					</div>

					<div class="col-sm-6">
						<table class="table table-responsive">		
							<thead>
								<td class="col-sm-6"><h5>Archivos</h5></td>
								<td class="col-sm-6"><h5>Imágenes</h5></td>
							</thead>			
							<tbody>
								<tr>
									<td>
										<div class="col-sm-6"  id="pdf_body"></div>
									</td>
									<td>
										<div class="col-sm-6"  id="images_body"></div>
									</td>
									{{-- <td>
										@php
											$imagenes=$midata->archivo;
										@endphp
										@foreach ($imagenes as $item)
											{{ $item }}<br>
										@endforeach
									</td> --}}
								</tr>
							</tbody>
						</table>
						<table class="table table-responsive">
							<thead>
								<td><h5>Tipo</h5></td>
								<td><h5>Copia Destinatarios</h5></td>
								<td><h5>Derivadores</h5></td>
							</thead>
							<tbody>
								<tr>
									<td>{{ $midata->tipo }}</td>
									<td>
										@foreach ($copia as $item)
											@php
												$user = TCG\Voyager\Models\User::where('id', $item->user_id)->first();
											@endphp
											- {{ $user->name }} <br>
										@endforeach
									</td>
									<td>
										@foreach ($derivadores as $item)
											@php
												$user = TCG\Voyager\Models\User::where('id', $item->user_id)->first();
											@endphp
											- {{ $user->name }} <br>
										@endforeach
									</td>
								</tr>
							</tbody>
							<thead>
								<td><h5>Editor</h5></td>
								<td><h5>Creado</h5></td>
								<td><h5>Actualizado</h5></td>
							</thead>
							<tbody>
								<td>{{ $midata->editor->name }}</td>
								<td>{{ $midata->created_at }}</td>
								<td>{{ $midata->updated_at }}</td>
							</tbody>		
						</table>
					</div>
					
					
				</div>
			</div>
			<div class="col-sm-12">
				{{-- <div class="col-sm-12 form-group">
					
						@php
							$detalle= App\DocumentoDetalle::where('documento_id',$midata->id)->get();	
						@endphp
						<h5>Árbol</h5>
						<table class="table table-responsive">
							<tbody>
								<tr>
									<td>ID</td>
									<td>Documento ID</td>
									<td>User ID</td>
									<td>Mensaje</td>
									<td>Imagen</td>
									<td>PDF</td>
									<td>Destinatario</td>
									<td>Fecha</td>
								</tr>
								<br>
								@foreach ($detalle as $item)
									
									<tr>
										<td>{{ $item->id }}</td>
										<td>{{$item->documento_id}}</td>
										<td>{{$item->user_id}}</td>
										<td>{{$item->mensaje}}</td>
										<td>{{$item->image}}</td>
										<td>{{$item->pdf}}</td>
										<td>{{$item->destinatario}}</td>
										<td>{{$item->created_at}}</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					
				</div> --}}
                {{-- @php

                    const $vector=$midata->archivo;

                @endphp --}}

                {{-- @foreach ( $cadena as $item )
                    <img class="img-responsive" src="{{ setting('admin.url').'storage/'.$item }}" alt="">
                @endforeach --}}
                {{-- <img class="img-responsive" src="{{ setting('admin.url').'storage/'.'documentos\/April2022\/8bVgIeV3UmrayLBVm56G.png' }}" alt=""> --}}
				<div class="container mt-4 mb-4">
					<!--Bootstrap classes arrange web page components into columns and rows in a grid -->
					<div class="row justify-content-md-center">
						<div class="col-md-12 col-lg-8">
							<div class="form-group">
								{{-- <textarea id="editor" hidden></textarea> --}}
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>


	<!-- -------------------MODALES----------------------- -->
    <!-- -------------------MODALES----------------------- -->

	{{-- <div class="modal fade modal-primary" id="derivar_a_terceros">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"
							aria-hidden="true">&times;</button>
				<h4>Derivar a Otros </h4>
				</div>
				<div class="modal-body">
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

					</div>

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>

				</div>
			</div>
		</div>
	</div> --}}

	<div class="modal modal-primary fade" tabindex="-1" id="AccionesDestinatario" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('voyager::generic.close') }}"><span aria-hidden="true">&times;</span></button>
                   <h4>Acciones</h4>
                </div>
                <div class="modal-body">
                    <div id="tabs">
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#responder" aria-controls="responder" role="tab" data-toggle="tab">Responder</a></li>
                            <li role="presentation" ><a href="#derivar" aria-controls="derivar" role="tab" data-toggle="tab">Derivar</a></li>
                            <li role="presentation" ><a href="#rechazar" aria-controls="rechazar" role="tab" data-toggle="tab">Rechazar</a></li>
                        </ul>
                        <div class="tab-content">

                            <div role="tabpanel" class="tab-pane active" id="responder">
                                <div class="row">
									<form action="{{route("respuesta_documento")}}" id="form_responder" method="POST" enctype="multipart/form-data">
										{{ csrf_field() }}
										<div class="col-sm-6 form-group">
											{{-- Mensaje Recibido: <p>{{ $midata->message }}</p> --}}
											<label for="mensaje_respuesta">Escribe un Mensaje</label>
											<textarea class="form-control richTextBox" name="mensaje_respuesta_respondido" id="mensaje_respuesta_respondido"  ></textarea>
										</div>

					
										<input type="text" name="user_id" value="{{Auth::user()->id}}" hidden>
										<input type="text" name="documento_id" value="{{$midata->id}}" hidden>
										<input type="text" name="destinatario_interno" value="{{$remitente_interno}}" hidden>
										<input type="text" name="destinatario_externo" value="{{$remitente_externo}}" hidden>
										<input type="text" name="estado_id_responder" value="3" hidden>

										<div class="col-sm-6 form-group">

											<div class="col-sm-12 form-group">
												<label for="">Image</label>
												<input type="file" name="images_respuesta[]" id="images_respuesta" class="form-control" accept="image/gif, image/jpeg, image/png, image/jpg" multiple>
											</div>
											<div class="col-sm-12 form-group">
												<label for="">Archivos</label>
												<input type="file" name="pdf_respuesta[]" id="pdf_respuesta" class="form-control" accept="application/pdf,.csv,.zip,.rar,.tar,.docx,.doc,.xlsx,.xls , application/vnd.openxmlformats-officedocument.spreadsheetml.sheet , application/vnd.ms-excel" multiple>
												<small><b>Si quiere enviar otro tipo de archivos comprímalo en un ZIP para que posteriormente se pueda descargar con normalidad.</b></small>
											</div>
											<div class="col-sm-12 form-group">
												<button type="submit" onclick="deshabilitar_botones()" id="button_respuesta" class="btn btn-primary" > Responder <i class="voyager-paper-plane"></i> </button>
												{{-- <a href="#" onclick="responder('{{ $midata->id }}')" class="btn btn-primary">Responder</a> --}}
											</div>

										</div>

									</form>
									
                                   
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="derivar">
                                <div class="row">
									<form action="{{route("derivar_documento")}}" id="form_derivar" method="POST" enctype="multipart/form-data">
										{{ csrf_field() }}
										<div class="col-sm-6 form-group">
											<label for="mensaje_respuesta">Escribe un Mensaje</label>
											<textarea class="form-control richTextBox" name="mensaje_respuesta_derivado" id="mensaje_respuesta_derivado"  ></textarea>
										</div>
										<input type="text" name="documento_id_derivacion" value="{{$midata->id}}" hidden>
										<input type="text" name="user_id_derivacion" value="{{Auth::user()->id}}" hidden>
										<input type="text" name="estado_id_derivacion" value="2" hidden>

										<div class="col-sm-6 form-group">

											<div class="col-sm-12 form-group">
												<label for="destinatario_id_derivacion">Usuarios</label>
												<select class="form-control" name="destinatario_id_derivacion" id="destinatario_id_derivacion" ></select>
											</div>
											<div class="col-sm-12 form-group">
												<button type="submit" onclick="deshabilitar_botones()" id="button_derivacion" class="btn btn-success">Derivar <i class="voyager-forward"></i></button>
											</div>
										</div>


									</form>
                                    
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="rechazar">
                                <div class="row">
									<form action="{{route("rechazar_documento")}}" id="form_rechazar" method="POST" enctype="multipart/form-data">
										{{ csrf_field() }}										
										<div class="col-sm-6 form-group">
											<label for="mensaje_respuesta">Escribe un Mensaje</label>
											<textarea class="form-control richTextBox" name="mensaje_respuesta_rechazado" id="mensaje_respuesta_rechazado"  ></textarea>
										</div>
										<input type="text" name="documento_id_rechazo" value="{{$midata->id}}" hidden>
										<input type="text" name="user_id_rechazo" value="{{Auth::user()->id}}" hidden>
										<input type="text" name="estado_id_rechazo" value="4" hidden>
										<input type="text" name="destinatario_interno_rechazo" value="{{$remitente_interno}}" hidden>
										<input type="text" name="destinatario_externo_rechazo" value="{{$remitente_externo}}" hidden>

										<div class="col-sm-6 form-group">
											<div class="col-sm-12 form-group">
												<button type="submit" onclick="deshabilitar_botones()" id="button_rechazo" class="btn btn-danger">Rechazar <i class="voyager-x"></i></button>
											</div>
										</div>
										
									</form>
									
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

	<div class="modal fade modal-primary" id="arbol_detalle">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"
							aria-hidden="true">&times;</button>
				<h4>Flujograma del Documento </h4>
				</div>
				<div class="modal-body">
					<div class="tab-content">
						<div role="tabpanel" class="tab-pane active" id="home">

							{{-- <table class="table table-striped table-inverse table-responsive" id="derivaciones_otros">
								<thead class="thead-inverse">
									
								</thead>
								<tbody></tbody>

								
							</table> --}}
							@php
							$detalle= App\DocumentoDetalle::where('documento_id',$midata->id)->get();	
							@endphp
							<table class="table table-responsive">
								<thead>
									<tr>
										{{-- <td>ID</td>
										<td>Documento ID</td>
										<td>User ID</td> --}}
										<td>Orden</td>
										<td>Mensaje</td>
										<td>Imagen</td>
										<td>Archivo</td>
										<td>Remitente</td>
										<td>Destinatario</td>
										<td>Estado</td>
										{{-- <td>Destinatario Interno</td> --}}
										<td>Fecha</td>
									</tr>
								</thead>
									
								<tbody>
									@php
										$index_arbol_orden=0;
									@endphp
									@foreach ($detalle as $item)
										@php
											$index_arbol_orden+=1;
										@endphp
										<tr>
											{{-- <td>{{ $item->id }}</td>
											<td>{{$item->documento_id}}</td>
											<td>{{$item->user_id}}</td> --}}
											<td>
												{{$index_arbol_orden}}
											</td>
											<td>
												<div id="message_arbol_{{$item->id}}"></div>
											</td>
											{{-- <td>{{$item->mensaje}}</td> --}}
											<td>
												<div id="images_arbol_{{$item->id}}"></div>
											</td>
											<td>
												<div id="pdfs_arbol_{{$item->id}}"></div>
											</td>
											<td>
												<div id="remitente_arbol_{{$item->id}}"></div>
											</td>
											<td>
												<div id="destinatario_arbol_{{$item->id}}"></div>
												{{-- {{$destinatario_arbol }} --}}
											</td>
											<td>
												{{ $item->estado->name }}
											</td>
											{{-- <td>{{$item->destinatario_externo}}</td> --}}
											<td>{{$item->published}}</td>
										</tr>
									@endforeach
								</tbody>
							</table>

						</div>

					</div>

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>

				</div>
			</div>
		</div>
	</div>

@stop

@push('javascript')
	<script>
		$(document).ready(function() {
			var additionalConfig = {
				// selector: 'textarea.richTextBox[name="editor_prueba"]',

				// selector: 'textarea#editor_prueba',
				selector: '.richTextBox'

			}

			$.extend(additionalConfig, {!! json_encode($options->tinymceOptions ?? '{}') !!})

			tinymce.init(window.voyagerTinyMCE.getConfig(additionalConfig));
		});
	</script>
@endpush

@section('javascript')
	<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
	{{-- <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script> --}}

	{{-- <script>
	tinymce.init({
		selector: 'textarea#editor',
		skin: 'bootstrap',
		plugins: 'lists, link, image, media',
		toolbar: 'h1 h2 bold italic strikethrough blockquote bullist numlist backcolor | link image media | removeformat help',
		menubar: false,
		});
	</script> --}}
	
	<script>

        $('document').ready(function () {
			destinatario_simple()
			mostrar_imgs_documento()
			mostrar_pdfs_documento()
			mostrar_message_arbol()
			mostrar_imgs_arbol()
			mostrar_pdfs_arbol()
			remitente_arbol()
			destinatario_arbol()
			
        });
		function htmlToText(html) {
			var temp = document.createElement('div');
			temp.innerHTML = html;
			return temp.textContent; // Or return temp.innerText if you need to return only visible text. It's slower.
		}
		async function mostrar_message_arbol(){
			// message_arbol
			var id='{{$midata->id}}'
			// var id_doc={
			// 	id:id
			// }
			// var arbol_messages=await axios.post("{{setting('admin.url')}}api/find/message/arbol", id_doc)
			var detalle= await axios("{{setting('admin.url')}}api/find/documento/detalle/"+id)

			if (detalle.data.length>0) {
				var lista=""
				for (let index = 0; index < detalle.data.length; index++) {
					var mensaje= htmlToText(detalle.data[index].mensaje)
					lista="<tr><td>"+mensaje+"</td></tr>"
					$('#message_arbol_'+detalle.data[index].id+'').html(lista)
				}
			}
		}
		async function mostrar_imgs_documento(){
			var id='{{$midata->id}}'
			var id_doc={
				id:id
			}
			var images= await axios.post("{{setting('admin.url')}}api/obtener/img/documento", id_doc)
			if (images.data) {
				var lista=""
				for (let index = 0; index < images.data.length; index++) {
					lista+="<tr><td><a href='{{ setting('admin.url').'storage/' }}"+images.data[index]+"' class='link-primary'><img class='img-responsive' src='{{ setting('admin.url').'storage/' }}"+images.data[index]+"' ></a></td></tr>"
				}
				$('#images_body').html(lista)
			}
		}
		async function mostrar_pdfs_documento(){
			var id='{{$midata->id}}'
			var id_doc={
				id:id
			}
			var pdfs= await axios.post("{{setting('admin.url')}}api/obtener/pdf/documento", id_doc)
			if (pdfs.data) {
				var lista=""
				for (let index = 0; index < pdfs.data.length; index++) {
					
					var validacion_pdf=pdfs.data[index].original_name.split(".").pop()

					if (validacion_pdf=="pdf") {
						// lista+="<tr><td><object data='https://www.uv.mx/personal/artulopez/files/2012/08/02_TS-y-TI.pdf' type='application/pdf' ><iframe src='https://docs.google.com/viewer?url=https://www.uv.mx/personal/artulopez/files/2012/08/02_TS-y-TI.pdf&embedded=true'></iframe></object></td></tr>"
						lista+="<tr><td><iframe src='https://docs.google.com/viewer?url={{ setting('admin.url').'storage/' }}"+pdfs.data[index].download_link+"&embedded=true'></iframe></td></tr>"

					}
					else{
						lista+="<tr><td><a href='{{ setting('admin.url').'storage/' }}"+pdfs.data[index].download_link+"' class='link-primary'>"+pdfs.data[index].original_name+"</a></td></tr>"
					}
				}
				$('#pdf_body').html(lista)
			}
		}
		async function mostrar_imgs_arbol(){
			var id='{{$midata->id}}'
			var detalle= await axios("{{setting('admin.url')}}api/find/documento/detalle/"+id)
			for (let contador = 0; contador < detalle.data.length; contador++) {
				var id_doc={
					id:detalle.data[contador].id
				}
				var images= await axios.post("{{setting('admin.url')}}api/obtener/img/arbol", id_doc)
				if (detalle.data[contador].image.length>2) {
					var lista=""
					for (let index = 0; index < images.data.length; index++) {
						lista+="<tr><td><a href='{{ setting('admin.url').'storage/' }}"+images.data[index]+"' class='link-primary'>Imagen "+(index+1)+"</a></td></tr>"
					}
					$('#images_arbol_'+detalle.data[contador].id+'').html(lista)
				}
			}	
		}
		async function mostrar_pdfs_arbol(){
			var id='{{$midata->id}}'
			var detalle= await axios("{{setting('admin.url')}}api/find/documento/detalle/"+id)
			for (let contador = 0; contador < detalle.data.length; contador++) {
				var id_doc={
					id:detalle.data[contador].id
				}
				var pdf= await axios.post("{{setting('admin.url')}}api/obtener/pdf/arbol", id_doc)
				if (detalle.data[contador].pdf.length>2) {
					var lista=""
					for (let index = 0; index < pdf.data.length; index++) {
						lista+="<tr><td><a href='{{ setting('admin.url').'storage/' }}"+pdf.data[index].download_link+"' class='link-primary'>"+pdf.data[index].original_name+"</a></td></tr>"
					}
					$('#pdfs_arbol_'+detalle.data[contador].id+'').html(lista)
				}
			}
		}
		async function remitente_arbol(){
			var id='{{$midata->id}}'
			var documento= await axios("{{setting('admin.url')}}api/find/documento/"+id)
			var detalle= await axios("{{setting('admin.url')}}api/find/documento/detalle/"+id)
			for (let index = 0; index < detalle.data.length; index++) {
				if (index==0) {
					//Cuando se manda por primera vez
					if (documento.data.remitente_externo) {
						$('#remitente_arbol_'+detalle.data[index].id+'').html(documento.data.remitente_externo.display)
					}
					else{
						$('#remitente_arbol_'+detalle.data[index].id+'').html(documento.data.remitente_interno.name)
					}
				}
				else{
					//Cuerpo del Arbol
					var user= await axios("{{setting('admin.url')}}api/find/user/"+detalle.data[index].user_id)
					$('#remitente_arbol_'+detalle.data[index].id+'').html(user.data.name)
				}	
			}
		}
		async function destinatario_arbol(){
			var id='{{$midata->id}}'
			var detalle= await axios("{{setting('admin.url')}}api/find/documento/detalle/"+id)
			for (let index = 0; index < detalle.data.length; index++) {
				if (detalle.data[index].destinatario_externo) {
					var user= await axios("{{setting('admin.url')}}api/find/persona/"+detalle.data[index].destinatario_externo)
					var lista=""
					lista+= user.data.display
					$('#destinatario_arbol_'+detalle.data[index].id+'').html(lista)
				}
				else{
					var user= await axios("{{setting('admin.url')}}api/find/user/"+detalle.data[index].destinatario_interno)
					var lista=""
					lista+= user.data.name
					$('#destinatario_arbol_'+detalle.data[index].id+'').html(lista)
				}
			}
		}
		//Cargar Destinatarios
		async function destinatario_simple(){
			var user = await axios.get("{{ setting('admin.url') }}api/users");
			$('#destinatario_id_derivacion').find('option').remove().end();
			$('#destinatario_id_derivacion').append($('<option>', {
				value: 0,
				text: 'Elige un Destinatario'
			}));
			for (let index = 0; index < user.data.length; index++) {
				$('#destinatario_id_derivacion').append($('<option>', {
					value: user.data[index].id,
					text: user.data[index].name
				}));
			}
		}
		async function derivar(id) {
			var midata = JSON.stringify({ documento_id: id, estado_id: 2 })
			var derivar = await axios("{{setting('admin.url')}}api/derivar/"+midata)
			var documento= await axios("{{setting('admin.url')}}api/find/documento/"+id)
			//Guardar Primer Detalle Documento
			var mensaje= documento.data.message
			var user_id = '{{ Auth::user()->id }}'
			var destinatario_id=$('#destinatario_id_derivacion').val()
			var destinatario_derivacion='{{$midata->destinatario_id}}'
			var data_detalle={
				documento_id: id,
				user_id: user_id,
				mensaje: mensaje,
				destinatario_interno: destinatario_derivacion,
				archivo:documento.data.archivo,
				pdf:documento.data.pdf
			}
			await axios.post("{{setting('admin.url')}}api/registrar/first/detalle", data_detalle)
			//---------------------------------
			//Mensaje por Wpp al Primer al destinatario principal 
			var mensaje=''
			if (documento.data.remitente_interno) {
				var remitente= documento.data.remitente_interno.name
			}
			else if(documento.data.remitente_externo){
				var remitente= documento.data.remitente_externo.display
			}
			var msj=htmlToText(documento.data.message)
			var link="{{setting('admin.url')}}admin/documentos \n"
			mensaje+='Hola *'+documento.data.destinatario.name+'*, tiene nueva correspondencia.\n'
			mensaje+='*ID*: '+id+' \n'
			mensaje+='*Mensaje*: '+msj+'\n'
			mensaje+='*Categoria*: '+documento.data.categoria.name+'\n'
			mensaje+='*Enviado por*: '+remitente+'\n'
			mensaje+='Ingresa al Sistema para revisarlo: \n'
			mensaje+=''+link+''
			mensaje+='Recuerda que si te olvidaste tus credenciales puedes enviar la palabra: *Login* para restablecerlas.\n'
			var data={
				message: mensaje,
				phone: documento.data.destinatario.phone
			}
			var wpp= await axios.post("{{setting('admin.chatbot_url')}}chat", data)
			//Mensaje por Wpp a los destinatarios COPIAS
			for (let index = 0; index < documento.data.copias.length; index++) {
				var destinatario_copia= await axios("{{setting('admin.url')}}api/find/user/"+documento.data.copias[index].user_id)
				
				var mensaje=''
				mensaje+='Hola *'+destinatario_copia.data.name+'*, tiene nueva correspondencia (Copia).\n'
				mensaje+='*ID*: '+id+' \n'
				mensaje+='*Mensaje*: '+msj+'\n'
				mensaje+='*Categoria*: '+documento.data.categoria.name+'\n'
				mensaje+='*Enviado por*: '+remitente+'\n'
				mensaje+='Ingresa al Sistema para revisarlo: \n'
				mensaje+=''+link+''
				mensaje+='Recuerda que si te olvidaste tus credenciales puedes enviar la palabra: *Login* para restablecerlas.\n'
				var data={
					message: mensaje,
					phone: destinatario_copia.data.phone
				}
				var wpp= await axios.post("{{setting('admin.chatbot_url')}}chat", data)
			}
			location.reload()
		}
		async function deshabilitar_botones(){
			$('#button_respuesta').css('display','none')
			$('#button_derivacion').css('display','none')
			$('#button_rechazo').css('display','none')
		}
	</script>
@stop
