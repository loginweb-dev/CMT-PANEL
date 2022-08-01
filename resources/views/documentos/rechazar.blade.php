@extends('voyager::master')

@section('css')
@stop
@section('page_header')
@stop
@section('content')
    <div id="voyager-loader">
        <?php $admin_loader_img = Voyager::setting('admin.loader', ''); ?>
        @if($admin_loader_img == '')
            <img src="{{ voyager_asset('images/logo-icon.png') }}" alt="Voyager Loader">
        @else
            <img src="{{ Voyager::image($admin_loader_img) }}" alt="Voyager Loader">
        @endif
    </div>
@stop
@section('javascript')
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        $('document').ready(function () {
            rechazar('{{$doc_detalle->documento_id}}')
        });
		function htmlToText(html) {
			var temp = document.createElement('div');
			temp.innerHTML = html;
			return temp.textContent; // Or return temp.innerText if you need to return only visible text. It's slower.
		}

        async function rechazar(id){
			var documento= await axios("{{setting('admin.url')}}api/find/documento/"+id)
			var doc_detalle_id='{{$doc_detalle->id}}'
            var detalle= await axios("{{setting('admin.url')}}api/find/detalle/"+doc_detalle_id)
			var mensaje=''
			if (documento.data.remitente_interno) {
				var remitente= documento.data.remitente_interno.name
				var phone= documento.data.remitente_interno.phone
			}
			else if(documento.data.remitente_externo){
				var remitente= documento.data.remitente_externo.display
				var phone= documento.data.remitente_externo.phone
			}
			var msj_rechazo=htmlToText(detalle.data.mensaje)
			var link="{{setting('admin.url')}}admin/documentos \n"
			var mensaje=''
			mensaje+='Hola *'+remitente+'*, tiene nueva correspondencia (Rechazo).\n'
			mensaje+='*ID*: '+id+' \n'
			mensaje+='*Mensaje*: '+msj_rechazo+'\n'
			mensaje+='*Categoria*: '+documento.data.categoria.name+'\n'
			mensaje+='*Rechazado por*: '+documento.data.destinatario.name+'\n'
			mensaje+='Ingresa al Sistema para revisarlo: \n'
			mensaje+=''+link+''
			mensaje+='Recuerda que si te olvidaste tus credenciales puedes enviar la palabra: *Login* para restablecerlas.\n'
			// console.log(mensaje)
			var data={
				message: mensaje,
				phone: phone
			}
			// console.log(data)
			var wpp= await axios.post("{{setting('admin.chatbot_url')}}chat", data)
            location.href='/admin/documentos'	

		}
    </script>
@stop