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
            derivar_simple('{{$doc_detalle->documento_id}}')
        });
		function htmlToText(html) {
			var temp = document.createElement('div');
			temp.innerHTML = html;
			return temp.textContent; // Or return temp.innerText if you need to return only visible text. It's slower.
		}

        async function derivar_simple(id){
			//Mensaje por Wpp al nuevo derivado
			var documento= await axios("{{setting('admin.url')}}api/find/documento/"+id)
            var doc_detalle_id='{{$doc_detalle->id}}'
            //var detalle= await axios("{{setting('admin.url')}}api/find/detalle/"+doc_detalle_id)
			var doc_detalle_id='{{$doc_detalle->id}}'
            var detalle= await axios("{{setting('admin.url')}}api/find/detalle/"+doc_detalle_id)
			var msj_remitente= htmlToText(documento.data.message)
			var msj_derivador= htmlToText(detalle.data.mensaje)
			var mensaje=''
			if (documento.data.remitente_interno) {
				var remitente= documento.data.remitente_interno.name
			}
			else if(documento.data.remitente_externo){
				var remitente= documento.data.remitente_externo.display
			}
			var user_id = '{{ Auth::user()->id }}'
			var derivador= await axios("{{setting('admin.url')}}api/find/user/"+user_id )
			var id_dest='{{$doc_detalle->destinatario_interno}}'
			var destinatario= await axios("{{setting('admin.url')}}api/find/user/"+id_dest)
			var link="{{setting('admin.url')}}admin/documentos \n"
			var mensaje=''
			mensaje+='Hola *'+destinatario.data.name+'*, tiene nueva correspondencia (Derivación).\n'
			mensaje+='*ID*: '+id+' \n'
			mensaje+='*Mensaje Remitente*: '+msj_remitente+'\n'
			mensaje+='*Mensaje Derivador*: '+msj_derivador+' \n'
			mensaje+='*Categoria*: '+documento.data.categoria.name+'\n'
			mensaje+='*Enviado por*: '+remitente+'\n'
			mensaje+='*Derivado por*: '+derivador.data.name+' \n'
			mensaje+='Ingresa al Sistema para revisarlo: \n'
			mensaje+=''+link+''
			mensaje+='Recuerda que si te olvidaste tus credenciales puedes enviar la palabra: *Login* para restablecerlas.\n'
			// console.log(mensaje)
			var data_mensaje={
				message: mensaje,
				phone: destinatario.data.phone
			}
			// console.log(data)
			var wpp= await axios.post("{{setting('admin.chatbot_url')}}chat", data_mensaje)
            location.href='/admin/documentos'	

		}
    </script>
@stop