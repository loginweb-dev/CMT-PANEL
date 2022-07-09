@extends('voyager::master')

@section('css')
@stop

@php
	$midata = App\Documento::where('id', $id)->first();
	$copia = App\RelUserDoc::where('documento_id', $midata->id)->get();
	$derivadores = App\RelDerivDoc::where('documento_id', $midata->id)->get();
	$remitente_interno= $midata->remitente_interno ? $midata->remitente_interno->id : null ;
	$remitente_externo= $midata->remitente_externo ? $midata->remitente_externo->id : null ;

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
			@switch($midata->estado_id)
				@case(1)
					@if($midata->editor_id== Auth::user()->id)
						<a href="#" onclick="derivar('{{ $midata->id }}')" class="btn btn-dark">Derivar</a>
					@endif
					@break
				@case(2)
					{{-- <a href="#" onclick="derivar_a_terceros('{{$midata->id}}')"data-toggle="modal" data-target="#derivar_a_terceros" class="btn btn-dark">Derivar a Otros</a> --}}
					<br>
						@if($midata->destinatario_id== Auth::user()->id)
							<div class="col-sm-6 form-group">
								{{-- <div class="col-sm-12 form-group">
									Mensaje Recibido: <p>{{ $midata->message }}</p>
									<textarea class="form-control" name="mensaje_respuesta"></textarea>
								</div>

								<div class="col-sm-12 form-group">
									<label for="">Image</label>
									<input type="file" name="" id="images_respuesta" class="form-control">
								</div>
								<div class="col-sm-12 form-group">
									<label for="">PDF</label>
									<input type="file" name="" id="pdf_respuesta" class="form-control">
								</div> --}}
								<div class="col-sm-12 form-group">
									<a href="#" onclick="#" data-toggle="modal" data-target="#arbol_detalle" class="btn btn-primary">Árbol Detalles</a>
								</div>
							</div>
							<div class="col-sm-6 form-group">
								{{-- <div class="col-sm-12 form-group">
									<label for="usuario_derivar">Usuarios</label>
									<select class="form-control" name="usuario_derivar" id="usuario_derivar"></select>
								</div>
								<div class="col-sm-12 form-group">
									<a href="#" onclick="derivar_simple('{{$midata->id}}')" class="btn btn-success">Derivar</a>
								</div>
								<div class="col-sm-12 form-group">
									<a href="#" onclick="responder('{{ $midata->id }}')" class="btn btn-primary">Responder</a>
								</div>

								<div class="col-sm-12 form-group">
									<a href="#" onclick="derivar('{{ $midata->id }}')" class="btn btn-danger">Rechazar</a>
								</div> --}}
								<div class="col-sm-12 form-group">
									<a href="#" onclick="#" data-toggle="modal" data-target="#AccionesDestinatario" class="btn btn-dark">Acciones</a>
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
					<table class="table table-responsive">
						
							
						<thead>
							<td><h5>Mensaje</h5></td>
						</thead>						
						<tbody>
							<tr>
								<td>
									<textarea class="form-control" cols="70" rows="10" readonly>{{$midata->message}}</textarea>
								</td>
							</tr>
						</tbody>
					</table>
					<table class="table table-responsive">		
						<thead>
							<td class="col-sm-6"><h5>PDFs</h5></td>
							<td class="col-sm-6"><h5>Images</h5></td>
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
			<div class="col-sm-6">
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
        <div class="modal-dialog">
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
									<form action="{{route("respuesta_documento")}}" method="POST" enctype="multipart/form-data">
										{{ csrf_field() }}
										<div class="col-sm-12 form-group">
											{{-- Mensaje Recibido: <p>{{ $midata->message }}</p> --}}
											<label for="mensaje_respuesta">Escribe un Mensaje</label>
											<textarea class="form-control" name="mensaje_respuesta"></textarea>
										</div>
										<input type="text" name="user_id" value="{{Auth::user()->id}}" hidden>
										<input type="text" name="documento_id" value="{{$midata->id}}" hidden>
										<input type="text" name="destinatario_interno" value="{{$remitente_interno}}" hidden>
										<input type="text" name="destinatario_externo" value="{{$remitente_externo}}" hidden>


										<div class="col-sm-12 form-group">
											<label for="">Image</label>
											<input type="file" name="images_respuesta[]" id="images_respuesta" class="form-control" accept="image/gif, image/jpeg, image/png, image/jpg" multiple>
										</div>
										<div class="col-sm-12 form-group">
											<label for="">PDF</label>
											<input type="file" name="pdf_respuesta[]" id="pdf_respuesta" class="form-control" accept="application/pdf,application/vnd.ms-excel" multiple>
										</div>
										<div class="col-sm-12 form-group">
											<button type="submit" class="btn btn-primary" > Responder <i class="voyager-paper-plane"></i> </button>
											{{-- <a href="#" onclick="responder('{{ $midata->id }}')" class="btn btn-primary">Responder</a> --}}
										</div>
									</form>
									
                                   
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="derivar">

                                <div class="row">
                                    <div class="col-sm-12 form-group">
										{{-- Mensaje Recibido: <p>{{ $midata->message }}</p> --}}
										<label for="mensaje_respuesta">Escribe un Mensaje</label>
										<textarea class="form-control" name="mensaje_respuesta"></textarea>
									</div>
									<div class="col-sm-12 form-group">
										<label for="usuario_derivar">Usuarios</label>
										<select class="form-control" name="usuario_derivar" id="usuario_derivar"></select>
									</div>
									<div class="col-sm-12 form-group">
										<a href="#" onclick="derivar_simple('{{$midata->id}}')" class="btn btn-success">Derivar <i class="voyager-forward"></i></a>
									</div>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="rechazar">
                                <div class="row">
									<div class="col-sm-12 form-group">
										{{-- Mensaje Recibido: <p>{{ $midata->message }}</p> --}}
										<label for="mensaje_respuesta">Escribe un Mensaje</label>
										<textarea class="form-control" name="mensaje_respuesta"></textarea>
									</div>
									<div class="col-sm-12 form-group">
										<a href="#" onclick="rechazar('{{ $midata->id }}')" class="btn btn-danger">Rechazar <i class="voyager-x"></i></a>
									</div>
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
				<h4>Árbol de Detalles del Documento </h4>
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
										<td>Mensaje</td>
										<td>Imagen</td>
										<td>PDF</td>
										<td>Destinatario</td>
										{{-- <td>Destinatario Interno</td> --}}
										<td>Fecha</td>
									</tr>
								</thead>
									
								<tbody>
									@foreach ($detalle as $item)
										@php
											$destinatario_arbol="";
										@endphp
										@if ($item->destinatario_interno)
											@php
												$data_destinatario_arbol= TCG\Voyager\Models\User::find($item->destinatario_interno);
												$destinatario_arbol=$data_destinatario_arbol->name;
											@endphp
										@else
											@php
												$data_destinatario_arbol= App\Persona::find($item->destinatario_externo);
												// $destinatario_arbol=$data_destinatario_arbol->display;
											@endphp
										@endif
										
										<tr>
											{{-- <td>{{ $item->id }}</td>
											<td>{{$item->documento_id}}</td>
											<td>{{$item->user_id}}</td> --}}
											<td>{{$item->mensaje}}</td>
											<td>
												<div id="images_arbol"></div>
											</td>
											<td>
												<div id="pdfs_arbol"></div>
											</td>
											<td>{{$destinatario_arbol }}</td>
											{{-- <td>{{$item->destinatario_externo}}</td> --}}
											<td>{{$item->created_at}}</td>
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


@section('javascript')
	<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
	<script>

        $('document').ready(function () {
			destinatario_simple();
			mostrar_imgs_documento()
			mostrar_pdfs_documento()
			mostrar_imgs_arbol()
			mostrar_pdfs_arbol()
			//array_pdf()
			//array_imagenes()
            //division();
        });
		async function mostrar_imgs_documento(){
			var id='{{$midata->id}}'
			var images= await array_imagenes(id)
			var lista=""
			for (let index = 0; index < images.length; index++) {
				//lista+="<tr><td>"+images[index]+"</td><tr>"
				// lista+="<tr><td><a href='{{ setting('admin.url').'storage/' }}"+images[index]+"' class='link-primary'>"+images[index]+"</a></td></tr>"
				lista+="<tr><td><a href='{{ setting('admin.url').'storage/' }}"+images[index]+"' class='link-primary'><img class='img-responsive' src='{{ setting('admin.url').'storage/' }}"+images[index]+"' ></a></td></tr>"

				//lista+="<tr><td><img class='img-responsive' src='{{ setting('admin.url').'storage/' }}"+images[index]+"' alt=''></td></tr>"
				// $('#images_body').html("<tr><td>"+images[index]+"</td><tr>")
			}
			$('#images_body').html(lista)
		}
		async function mostrar_pdfs_documento(){
			var id='{{$midata->id}}'
			var pdfs= await array_pdfs(id)
			var lista=""
			for (let index = 0; index < pdfs.length; index++) {
				//lista+="<tr><td>"+pdfs[index]+"</td><tr>"
				// lista+="<tr><td><a href='{{ setting('admin.url').'storage/' }}"+pdfs[index]+"' class='link-primary'>"+pdfs[index]+"</a></td></tr>"
				lista+="<tr><td><iframe class='embed-responsive-item' src='https://docs.google.com/viewer?url=https://panel.cmt.gob.bo/storage/documentos//July2022//7g9y6fQo8nENKGxEBUeJ.pdf&embedded=true'  height='200' style='border: none;'></iframe></td></tr>"
			}
			$('#pdf_body').html(lista)
		}

		async function mostrar_imgs_arbol(){
			var id='{{$midata->id}}'
			var detalle= await axios("{{setting('admin.url')}}api/find/documento/detalle/"+id)
			
			var images= []
			var separador=","
			var arrayDeCadenas = detalle.data[1].image.split(separador);
			// console.log(pdf)
			// console.log(images)
			//console.log(arrayDeCadenas[0])
			var separador='"'
			for (let index = 0; index < arrayDeCadenas.length; index++) {
				var array2= arrayDeCadenas[index].split(separador)
				images.push(array2[1])
			}
			//console.log(images)
			var lista=""
			for (let index = 0; index < images.length; index++) {
				lista+="<tr><td><a href='{{ setting('admin.url').'storage/' }}"+images[index]+"' class='link-primary'>Imagen "+(index+1)+"</a></td></tr>"
			}
			$('#images_arbol').html(lista)
		}
		async function mostrar_pdfs_arbol(){
			var id='{{$midata->id}}'
			var detalle= await axios("{{setting('admin.url')}}api/find/documento/detalle/"+id)

			var pdf= []
			var separador=","
			var arrayDeCadenas = detalle.data[1].pdf.split(separador);
			// console.log(pdf)
			// console.log(images)
			//console.log(arrayDeCadenas[0])
			var separador='"'
			for (let index = 0; index < arrayDeCadenas.length; index++) {
				var array2= arrayDeCadenas[index].split(separador)
				pdf.push(array2[1])
			}
			//console.log(pdf)
			var lista=""
			for (let index = 0; index < pdf.length; index++) {
				lista+="<tr><td><a href='{{ setting('admin.url').'storage/' }}"+pdf[index]+"' class='link-primary'>PDF "+(index+1)+"</a></td></tr>"
			}
			$('#pdfs_arbol').html(lista)
		}

		async function array_imagenes(id){
			var documento= await axios("{{setting('admin.url')}}api/find/documento/"+id)
			var images= []
			var separador=","
			var arrayDeCadenas = documento.data.archivo.split(separador);
			// console.log(pdf)
			// console.log(images)
			//console.log(arrayDeCadenas[0])
			var separador='"'
			for (let index = 0; index < arrayDeCadenas.length; index++) {
				var array2= arrayDeCadenas[index].split(separador)
				images.push(array2[1])
			}
			//console.log(images)
			
			// console.log(documento.data.archivo)
			return images;
		}
		async function array_pdfs(id){
			var documento= await axios("{{setting('admin.url')}}api/find/documento/"+id)
			var pdf= []
			var separador=","
			var arrayDeCadenas = documento.data.pdf.split(separador);
			var separador=':'
			for (let index = 0; index < arrayDeCadenas.length; index++) {
				if (index%2==0) {
					var array2= arrayDeCadenas[index].split(separador)
					var separador='"'
					var array3= array2[1].split(separador)
					pdf.push(array3[1])
				}
			}
			
			
			return pdf;
		}

		//Cargar Destinatarios
		async function destinatario_simple(){
			var user = await axios.get("{{ setting('admin.url') }}api/users");
			$('#usuario_derivar').find('option').remove().end();
			$('#usuario_derivar').append($('<option>', {
				value: 0,
				text: 'Elige un Destinatario'
			}));
			for (let index = 0; index < user.data.length; index++) {
				$('#usuario_derivar').append($('<option>', {
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
			var destinatario_id=$('#usuario_derivar').val()

			var data_detalle={
				documento_id: id,
				user_id: user_id,
				mensaje: mensaje,
				destinatario: destinatario_id
			}
			await axios.post("{{setting('admin.url')}}api/registrar/first/detalle", data_detalle)
			//---------------------------------
			// console.log(derivar.data)
			//Mensaje por Wpp al Primer al destinatario principal 
			var mensaje=''
			if (documento.data.remitente_interno) {
				var remitente= documento.data.remitente_interno.name
			}
			else if(documento.data.remitente_externo){
				var remitente= documento.data.remitente_externo.display
			}
			var link="{{setting('admin.url')}}admin/documentos \n"
			mensaje+='Hola *'+documento.data.destinatario.name+'*, tiene nueva correspondencia.\n'
			mensaje+='*ID*: '+id+' \n'
			mensaje+='*Mensaje*: '+documento.data.message+'\n'
			mensaje+='*Categoria*: '+documento.data.categoria.name+'\n'
			mensaje+='*Enviado por*: '+remitente+'\n'
			mensaje+='Ingresa al Sistema para revisarlo: \n'
			mensaje+=''+link+''
			mensaje+='Recuerda que si te olvidaste tus credenciales puedes enviar la palabra: *Login* para restablecerlas.\n'
			// console.log(mensaje)
			var data={
				message: mensaje,
				phone: documento.data.destinatario.phone
			}
			// console.log(data)
			var wpp= await axios.post("{{setting('admin.chatbot_url')}}chat", data)
			//Mensaje por Wpp a los destinatarios COPIAS
			for (let index = 0; index < documento.data.copias.length; index++) {
				var destinatario_copia= await axios("{{setting('admin.url')}}api/find/user/"+documento.data.copias[index].user_id)
				
				var mensaje=''
				mensaje+='Hola *'+destinatario_copia.data.name+'*, tiene nueva correspondencia (Copia).\n'
				mensaje+='*ID*: '+id+' \n'
				mensaje+='*Mensaje*: '+documento.data.message+'\n'
				mensaje+='*Categoria*: '+documento.data.categoria.name+'\n'
				mensaje+='*Enviado por*: '+remitente+'\n'
				mensaje+='Ingresa al Sistema para revisarlo: \n'
				mensaje+=''+link+''
				mensaje+='Recuerda que si te olvidaste tus credenciales puedes enviar la palabra: *Login* para restablecerlas.\n'
				// console.log(mensaje)
				var data={
					message: mensaje,
					phone: destinatario_copia.data.phone
				}
				// console.log(data)
				var wpp= await axios.post("{{setting('admin.chatbot_url')}}chat", data)

			}
			location.reload()

		}

		async function responder(id){
			var mensaje= $("textarea[name='mensaje_respuesta']").val();
			// var images=1
			// var pdf=1
			var user_id = '{{ Auth::user()->id }}'

			var data={
				documento_id: id,
				user_id: user_id,
				mensaje: mensaje
			}

			var respuesta=await axios.post("{{setting('admin.url')}}api/responder", data)
			if (respuesta.data) {
				location.href='/admin/documentos'
				toastr.succes("Se respondió exitosamente")
			}
		}

		async function derivar_simple(id){
			var mensaje= $("textarea[name='mensaje_respuesta']").val();
			var user_id = '{{ Auth::user()->id }}'
			var destinatario_id=$('#usuario_derivar').val()

			var data={
				documento_id: id,
				user_id: user_id,
				mensaje: mensaje,
				destinatario: destinatario_id
			}
			var data_deriv={
				documento_id: id,
				user_id: user_id
			}
			await axios.post("{{setting('admin.url')}}api/save/rel/deriv", data_deriv)

			var respuesta= await axios.post("{{setting('admin.url')}}api/derivar2", data)

			//Mensaje por Wpp al nuevo derivado
			var documento= await axios("{{setting('admin.url')}}api/find/documento/"+id)
			var mensaje=''
			if (documento.data.remitente_interno) {
				var remitente= documento.data.remitente_interno.name
			}
			else if(documento.data.remitente_externo){
				var remitente= documento.data.remitente_externo.display
			}
			var link="{{setting('admin.url')}}admin/documentos \n"
			mensaje+='Hola *'+documento.data.destinatario.name+'*, tiene nueva correspondencia.\n'
			mensaje+='*ID*: '+id+' \n'
			mensaje+='*Mensaje*: '+documento.data.message+'\n'
			mensaje+='*Categoria*: '+documento.data.categoria.name+'\n'
			mensaje+='*Enviado por*: '+remitente+'\n'
			mensaje+='Ingresa al Sistema para revisarlo: \n'
			mensaje+=''+link+''
			mensaje+='Recuerda que si te olvidaste tus credenciales puedes enviar la palabra: *Login* para restablecerlas.\n'
			// console.log(mensaje)
			var data_mensaje={
				message: mensaje,
				phone: documento.data.destinatario.phone
			}
			// console.log(data)
			var wpp= await axios.post("{{setting('admin.chatbot_url')}}chat", data_mensaje)
			//-------------------------------------------

			if (respuesta.data) {
				location.href='/admin/documentos'
				toastr.succes("Se derivó exitosamente")
			}
		}

		async function rechazar(id){
			var mensaje= $("textarea[name='mensaje_respuesta']").val();
			var user_id = '{{ Auth::user()->id }}'

			var data={
				documento_id: id,
				user_id: user_id,
				mensaje: mensaje
			}

			var respuesta=await axios.post("{{setting('admin.url')}}api/rechazar", data)
			if (respuesta.data) {
				location.href='/admin/documentos'
				toastr.succes("Se rechazó exitosamente")
			}
		}

		// async function derivar_a_terceros(id){
		// 	$('#derivaciones_otros tbody').empty();

		// 	$("#derivaciones_otros").append("<tr><td>"+id+"</td><td>"+'Mensaje'+"</td><td>"+'Seleccionar Destinatario'+"</td><td>"+'Fecha'+"</td><td>"+'Agregar mas Destinatario'+"</td></tr>");
		// }

        // function dividirCadena(cadenaADividir,separador){
        //     var arrayDeCadenas = cadenaADividir.split(separador);
        //     return arrayDeCadenas;
        // }

        function division(){
            // console.log($('#user_remitente').val());
            // console.log($('#user_remitente').text());

            // var cadenaADividir=["documentos\/April2022\/8bVgIeV3UmrayLBVm56G.png","documentos\/April2022\/Ic4bBSfgXwydxShb9Klx.png","documentos\/April2022\/VmIYJYkK2TdPXbMtV3dN.png"];
            // var separador='"';
            // var arrayDeCadenas = cadenaADividir.split(separador);
            // console.log(arrayDeCadenas);

            // const authHeader = ["documentos\/April2022\/8bVgIeV3UmrayLBVm56G.png","documentos\/April2022\/Ic4bBSfgXwydxShb9Klx.png","documentos\/April2022\/VmIYJYkK2TdPXbMtV3dN.png"]
            // const split = authHeader.split(',') // (1) [ 'bearer', 'token' ]
            // const token = split[1] // (2) token

            const token= ["documentos\/April2022\/8bVgIeV3UmrayLBVm56G.png","documentos\/April2022\/Ic4bBSfgXwydxShb9Klx.png","documentos\/April2022\/VmIYJYkK2TdPXbMtV3dN.png"]
            //const token =vector;
            console.log(token[1]);
        }

	</script>
@stop
