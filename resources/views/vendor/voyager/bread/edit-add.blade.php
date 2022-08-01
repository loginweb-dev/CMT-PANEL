@php
    $edit = !is_null($dataTypeContent->getKey());
    $add  = is_null($dataTypeContent->getKey());
@endphp

@extends('voyager::master')

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop
@section('page_title', __('voyager::generic.'.($edit ? 'edit' : 'add')).' '.$dataType->getTranslatedAttribute('display_name_singular'))

@switch( $dataType->getTranslatedAttribute('slug') )
    @case('documentos')
        @section('page_header')
            <h1 class="page-title">
                <i class="{{ $dataType->icon }}"></i>
                {{ __('voyager::generic.'.($edit ? 'edit' : 'add')).' '.$dataType->getTranslatedAttribute('display_name_singular') }}
            </h1>
            @include('voyager::multilingual.language-selector')
            <a class="btn btn-sm btn-dark" href="/admin/personas/create" role="button">Nuevo Remitente Externo</a>
            {{-- <a name="" id="" class="btn btn-sm btn-success" href="#" onclick="save_document()" role="button">Guardar</a> --}}
        @stop

        @break
    @case('2')

        @break
    @default

        @section('page_header')
            <h1 class="page-title">
                <i class="{{ $dataType->icon }}"></i>
                {{ __('voyager::generic.'.($edit ? 'edit' : 'add')).' '.$dataType->getTranslatedAttribute('display_name_singular') }}
            </h1>
            @include('voyager::multilingual.language-selector')
        @stop
@endswitch
@section('content')

    @switch($dataType->getTranslatedAttribute('slug'))
        @case('documentos')
            <div class="page-content edit-add container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-bordered">
                            <form role="form"
                                    class="form-edit-add"
                                    action="{{ $edit ? route('voyager.'.$dataType->slug.'.update', $dataTypeContent->getKey()) : route('voyager.'.$dataType->slug.'.store') }}"
                                    method="POST" enctype="multipart/form-data" id="miform">
                                @if($edit)
                                    {{ method_field("PUT") }}
                                @endif
                                {{ csrf_field() }}
                                <div class="panel-body">
                                    @if (count($errors) > 0)
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                    @php
                                        $dataTypeRows = $dataType->{($edit ? 'editRows' : 'addRows' )};
                                    @endphp
                                    <div class="form-group col-md-8">
                                        @foreach($dataTypeRows as $row)
                                            <!-- GET THE DISPLAY OPTIONS -->
                                            @php
                                                $display_options = $row->details->display ?? NULL;
                                                if ($dataTypeContent->{$row->field.'_'.($edit ? 'edit' : 'add')}) {
                                                    $dataTypeContent->{$row->field} = $dataTypeContent->{$row->field.'_'.($edit ? 'edit' : 'add')};
                                                }
                                            @endphp
                                            @if (isset($row->details->legend) && isset($row->details->legend->text))
                                                <legend class="text-{{ $row->details->legend->align ?? 'center' }}" style="background-color: {{ $row->details->legend->bgcolor ?? '#f0f0f0' }};padding: 5px;">{{ $row->details->legend->text }}</legend>
                                            @endif

                                            <div class="form-group @if($row->type == 'hidden') hidden @endif col-md-{{ $display_options->width ?? 12 }} {{ $errors->has($row->field) ? 'has-error' : '' }}" @if(isset($display_options->id)){{ "id=$display_options->id" }}@endif>
                                                {{ $row->slugify }}
                                                <label class="control-label" for="name">{{ $row->getTranslatedAttribute('display_name') }}</label>
                                                @if(isset($row->details->mitoolstip))
                                                    <i class="voyager-info-circled" data-toggle="tooltip" rel="tooltip" title="{{ $row->details->mitoolstip }}"></i>
                                                @endif
                                                @include('voyager::multilingual.input-hidden-bread-edit-add')
                                                @if (isset($row->details->view))
                                                    @include($row->details->view, ['row' => $row, 'dataType' => $dataType, 'dataTypeContent' => $dataTypeContent, 'content' => $dataTypeContent->{$row->field}, 'action' => ($edit ? 'edit' : 'add'), 'view' => ($edit ? 'edit' : 'add'), 'options' => $row->details])
                                                @elseif ($row->type == 'relationship')
                                                    @include('voyager::formfields.relationship', ['options' => $row->details])
                                                @else
                                                    {!! app('voyager')->formField($row, $dataType, $dataTypeContent) !!}
                                                @endif

                                                @foreach (app('voyager')->afterFormFields($row, $dataType, $dataTypeContent) as $after)
                                                    {!! $after->handle($row, $dataType, $dataTypeContent) !!}
                                                @endforeach
                                                @if ($errors->has($row->field))
                                                    @foreach ($errors->get($row->field) as $error)
                                                        <span class="help-block">{{ $error }}</span>
                                                    @endforeach
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                    <!-- Seccion Jonathan Selects -->
                                    <div class="form-group col-md-4">
                                        <label for="">Remitente</label>
                                        <select class="form-control js-example-basic-single" name="user_remitente" id="user_remitente" ></select>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="">Destinatario</label>
                                        <select class="form-control js-example-basic-single" name="user_destinatario" id="user_destinatario"></select>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="">Categoría</label>
                                        <select class="form-control js-example-basic-single" name="document_categoria" id="document_categoria"></select>
                                    </div>

                                    {{-- <div class="form-group col-md-4 text-center">
                                        {!! QrCode::generate('QR DE NUEVO REGISTRO!'); !!}
                                    </div> --}}
                                    <div class="form-group col-md-4 text-center">
                                        <button type="submit" class="btn btn-primary save">{{ __('voyager::generic.save') }}</button>
                                    </div>
                                </div><!-- panel-body -->

                                {{-- <div class="panel-footer">
                                    @section('submit-buttons')
                                        <button type="submit" class="btn btn-primary save">{{ __('voyager::generic.save') }}</button>
                                    @stop
                                    @yield('submit-buttons')
                                </div> --}}
                            </form>

                            <iframe id="form_target" name="form_target" style="display:none"></iframe>
                            <form id="my_form" action="{{ route('voyager.upload') }}" target="form_target" method="post"
                                    enctype="multipart/form-data" style="width:0;height:0;overflow:hidden">
                                <input name="image" id="upload_file" type="file"
                                        onchange="$('#my_form').submit();this.value='';">
                                <input type="hidden" name="type_slug" id="type_slug" value="{{ $dataType->slug }}">
                                {{ csrf_field() }}
                            </form>

                        </div>
                    </div>
                </div>
            </div>

            @break
        @case('convocatorias')
            <div class="page-content edit-add container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-bordered">
                            <div>
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs" role="tablist">
                                  <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Formulario Individual</a></li>
                                  <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Formulario Multiple</a></li>
                                </ul>
                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <div role="tabpanel" class="tab-pane active" id="home">
                                        <!-- form start -->
                                        <form role="form"
                                            class="form-edit-add"
                                            action="{{ $edit ? route('voyager.'.$dataType->slug.'.update', $dataTypeContent->getKey()) : route('voyager.'.$dataType->slug.'.store') }}"
                                            method="POST" enctype="multipart/form-data">
                                        <!-- PUT Method if we are editing -->
                                        @if($edit)
                                            {{ method_field("PUT") }}
                                        @endif

                                        <!-- CSRF TOKEN -->
                                        {{ csrf_field() }}
                                        <div class="panel-body">
                                            @if (count($errors) > 0)
                                                <div class="alert alert-danger">
                                                    <ul>
                                                        @foreach ($errors->all() as $error)
                                                            <li>{{ $error }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif
                                            <!-- Adding / Editing -->
                                            @php
                                                $dataTypeRows = $dataType->{($edit ? 'editRows' : 'addRows' )};
                                            @endphp
                                            @foreach($dataTypeRows as $row)
                                                <!-- GET THE DISPLAY OPTIONS -->
                                                @php
                                                    // $mitoolstip = $row->details->mitoolstip ?? NULL;
                                                    $display_options = $row->details->display ?? NULL;
                                                    if ($dataTypeContent->{$row->field.'_'.($edit ? 'edit' : 'add')}) {
                                                        $dataTypeContent->{$row->field} = $dataTypeContent->{$row->field.'_'.($edit ? 'edit' : 'add')};
                                                    }
                                                @endphp
                                                @if(isset($row->details->legend) && isset($row->details->legend->text))
                                                    <legend class="text-{{ $row->details->legend->align ?? 'center' }}" style="background-color: {{ $row->details->legend->bgcolor ?? '#f0f0f0' }};padding: 5px;">{{ $row->details->legend->text }}</legend>
                                                @endif
                                                <div class="form-group @if($row->type == 'hidden') hidden @endif col-md-{{ $display_options->width ?? 12 }} {{ $errors->has($row->field) ? 'has-error' : '' }}" @if(isset($display_options->id)){{ "id=$display_options->id" }}@endif>
                                                    {{ $row->slugify }}
                                                    <label class="control-label" for="name">{{ $row->getTranslatedAttribute('display_name') }}</label>
                                                    @if(isset($row->details->mitoolstip))
                                                    <i class="voyager-info-circled" data-toggle="tooltip" rel="tooltip" title="{{ $row->details->mitoolstip }}"></i>
                                                    @endif
                                                    @include('voyager::multilingual.input-hidden-bread-edit-add')
                                                    @if (isset($row->details->view))
                                                        @include($row->details->view, ['row' => $row, 'dataType' => $dataType, 'dataTypeContent' => $dataTypeContent, 'content' => $dataTypeContent->{$row->field}, 'action' => ($edit ? 'edit' : 'add'), 'view' => ($edit ? 'edit' : 'add'), 'options' => $row->details])
                                                    @elseif ($row->type == 'relationship')
                                                        @include('voyager::formfields.relationship', ['options' => $row->details])
                                                    @else
                                                        {!! app('voyager')->formField($row, $dataType, $dataTypeContent) !!}
                                                    @endif

                                                    @foreach (app('voyager')->afterFormFields($row, $dataType, $dataTypeContent) as $after)
                                                        {!! $after->handle($row, $dataType, $dataTypeContent) !!}
                                                    @endforeach
                                                    @if ($errors->has($row->field))
                                                        @foreach ($errors->get($row->field) as $error)
                                                            <span class="help-block">{{ $error }}</span>
                                                        @endforeach
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div><!-- panel-body -->
                                        <div class="panel-footer">
                                            @section('submit-buttons')
                                                <button type="submit" class="btn btn-primary save">{{ __('voyager::generic.save') }}</button>
                                            @stop
                                            @yield('submit-buttons')
                                        </div>
                                    </form>

                                    <iframe id="form_target" name="form_target" style="display:none"></iframe>
                                    <form id="my_form" action="{{ route('voyager.upload') }}" target="form_target" method="post"
                                            enctype="multipart/form-data" style="width:0;height:0;overflow:hidden">
                                        <input name="image" id="upload_file" type="file"
                                                onchange="$('#my_form').submit();this.value='';">
                                        <input type="hidden" name="type_slug" id="type_slug" value="{{ $dataType->slug }}">
                                        {{ csrf_field() }}
                                    </form>

                                  </div>
                                  <div role="tabpanel" class="tab-pane fade" id="profile">
                                      <div class="panel-body">
                                          <form action="{{ route('multiple_convocatorias') }}" method="post" enctype="multipart/form-data">
                                            {{ csrf_field() }}
                                            <div class="form-group">
                                                <label for="">Categoria</label>
                                                @php
                                                    $categorias = App\CatConvocatoria::all();
                                                @endphp
                                                <select name="categoria_id"  class="form-control">
                                                    @foreach ($categorias as $item)
                                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label for="">Gestion</label>
                                                <input type="text" name="gestion" value="2022" class="form-control" >
                                            </div>

                                            <div class="form-group">
                                                <label for="">Archivos</label>
                                                <input type="file" name="miconvocatorias[]" class="form-control" multiple>
                                            </div>

                                            <div class="form-group" hidden>
                                                <label for="">Editor</label>
                                                <input type="text" name="editor_id" value="{{ Auth::user()->id }}" class="form-control" >
                                            </div>
                                            <button type="submit" class="btn btn-primary btn-block mt-4">
                                                Subir Archivos
                                            </button>
                                          </form>
                                    </div>
                                  </div>
                                </div>
                              </div>
                        </div>
                    </div>
                </div>
            </div>
            @break
        @case('gacetas')

            <div class="page-content edit-add container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-bordered">
                            <div>
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs" role="tablist">
                                  <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Formulario Individual</a></li>
                                  <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Formulario Multiple</a></li>
                                </ul>
                                <!-- Tab panes -->
                                <div class="tab-content">
                                  <div role="tabpanel" class="tab-pane active" id="home">
                                        <!-- form start -->
                                        <form role="form"
                                            class="form-edit-add"
                                            action="{{ $edit ? route('voyager.'.$dataType->slug.'.update', $dataTypeContent->getKey()) : route('voyager.'.$dataType->slug.'.store') }}"
                                            method="POST" enctype="multipart/form-data">
                                        <!-- PUT Method if we are editing -->
                                        @if($edit)
                                            {{ method_field("PUT") }}
                                        @endif

                                        <!-- CSRF TOKEN -->
                                        {{ csrf_field() }}

                                        <div class="panel-body">

                                            @if (count($errors) > 0)
                                                <div class="alert alert-danger">
                                                    <ul>
                                                        @foreach ($errors->all() as $error)
                                                            <li>{{ $error }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif

                                            <!-- Adding / Editing -->
                                            @php
                                                $dataTypeRows = $dataType->{($edit ? 'editRows' : 'addRows' )};
                                            @endphp

                                            @foreach($dataTypeRows as $row)
                                                <!-- GET THE DISPLAY OPTIONS -->
                                                @php
                                                    $display_options = $row->details->display ?? NULL;
                                                    if ($dataTypeContent->{$row->field.'_'.($edit ? 'edit' : 'add')}) {
                                                        $dataTypeContent->{$row->field} = $dataTypeContent->{$row->field.'_'.($edit ? 'edit' : 'add')};
                                                    }
                                                @endphp
                                                @if (isset($row->details->legend) && isset($row->details->legend->text))
                                                    <legend class="text-{{ $row->details->legend->align ?? 'center' }}" style="background-color: {{ $row->details->legend->bgcolor ?? '#f0f0f0' }};padding: 5px;">{{ $row->details->legend->text }}</legend>
                                                @endif

                                                <div class="form-group @if($row->type == 'hidden') hidden @endif col-md-{{ $display_options->width ?? 12 }} {{ $errors->has($row->field) ? 'has-error' : '' }}" @if(isset($display_options->id)){{ "id=$display_options->id" }}@endif>
                                                    {{ $row->slugify }}
                                                    <label class="control-label" for="name">{{ $row->getTranslatedAttribute('display_name') }}</label>
                                                    @if(isset($row->details->mitoolstip))
                                                    <i class="voyager-info-circled" data-toggle="tooltip" rel="tooltip" title="{{ $row->details->mitoolstip }}"></i>
                                                    @endif
                                                    @include('voyager::multilingual.input-hidden-bread-edit-add')
                                                    @if (isset($row->details->view))
                                                        @include($row->details->view, ['row' => $row, 'dataType' => $dataType, 'dataTypeContent' => $dataTypeContent, 'content' => $dataTypeContent->{$row->field}, 'action' => ($edit ? 'edit' : 'add'), 'view' => ($edit ? 'edit' : 'add'), 'options' => $row->details])
                                                    @elseif ($row->type == 'relationship')
                                                        @include('voyager::formfields.relationship', ['options' => $row->details])
                                                    @else
                                                        {!! app('voyager')->formField($row, $dataType, $dataTypeContent) !!}
                                                    @endif

                                                    @foreach (app('voyager')->afterFormFields($row, $dataType, $dataTypeContent) as $after)
                                                        {!! $after->handle($row, $dataType, $dataTypeContent) !!}
                                                    @endforeach
                                                    @if ($errors->has($row->field))
                                                        @foreach ($errors->get($row->field) as $error)
                                                            <span class="help-block">{{ $error }}</span>
                                                        @endforeach
                                                    @endif
                                                </div>
                                            @endforeach

                                        </div><!-- panel-body -->
                                        <div class="panel-footer">
                                            @section('submit-buttons')
                                                <button type="submit" class="btn btn-primary save">{{ __('voyager::generic.save') }}</button>
                                            @stop
                                            @yield('submit-buttons')
                                        </div>
                                    </form>

                                    <iframe id="form_target" name="form_target" style="display:none"></iframe>
                                    <form id="my_form" action="{{ route('voyager.upload') }}" target="form_target" method="post"
                                            enctype="multipart/form-data" style="width:0;height:0;overflow:hidden">
                                        <input name="image" id="upload_file" type="file"
                                                onchange="$('#my_form').submit();this.value='';">
                                        <input type="hidden" name="type_slug" id="type_slug" value="{{ $dataType->slug }}">
                                        {{ csrf_field() }}
                                    </form>

                                  </div>
                                <div role="tabpanel" class="tab-pane fade" id="profile">
                                    <div class="panel-body">
                                        <form action="{{ route('multiple_gacetas') }}" method="post" enctype="multipart/form-data">
                                          {{ csrf_field() }}
                                          <div class="form-group">
                                              <label for="">Categoria</label>
                                              @php
                                                  $categorias = App\CatGaceta::all();
                                              @endphp
                                              <select name="categoria_id"  class="form-control">
                                                  @foreach ($categorias as $item)
                                                      <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                  @endforeach
                                              </select>
                                          </div>

                                          <div class="form-group">
                                              <label for="">Gestion</label>
                                              <input type="text" name="gestion" value="2022" class="form-control" >
                                          </div>

                                          <div class="form-group">
                                              <label for="">Archivos</label>
                                              <input type="file" name="migacetas[]" class="form-control" multiple>
                                          </div>

                                          <div class="form-group" hidden>
                                              <label for="">Editor</label>
                                              <input type="text" name="editor_id" value="{{ Auth::user()->id }}" class="form-control" >
                                          </div>
                                          <button type="submit" class="btn btn-primary btn-block mt-4">
                                              Subir Archivos
                                          </button>
                                        </form>
                                  </div>
                                </div>
                                </div>
                              </div>
                        </div>
                    </div>
                </div>
            </div>
            @break
        @case('teletrabajos')
            <div class="page-content edit-add container-fluid">
                <div class="row">
                    <div class="col-md-12">

                        <div class="panel panel-bordered">
                            <!-- form start -->
                            <form role="form"
                                    class="form-edit-add"
                                    action="{{ $edit ? route('voyager.'.$dataType->slug.'.update', $dataTypeContent->getKey()) : route('voyager.'.$dataType->slug.'.store') }}"
                                    method="POST" enctype="multipart/form-data">
                                <!-- PUT Method if we are editing -->
                                @if($edit)
                                    {{ method_field("PUT") }}
                                @endif

                                <!-- CSRF TOKEN -->
                                {{ csrf_field() }}

                                <div class="panel-body">

                                    @if (count($errors) > 0)
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    <!-- Adding / Editing -->
                                    @php
                                        $dataTypeRows = $dataType->{($edit ? 'editRows' : 'addRows' )};
                                    @endphp

                                    @foreach($dataTypeRows as $row)
                                        <!-- GET THE DISPLAY OPTIONS -->
                                        @php
                                            $display_options = $row->details->display ?? NULL;
                                            if ($dataTypeContent->{$row->field.'_'.($edit ? 'edit' : 'add')}) {
                                                $dataTypeContent->{$row->field} = $dataTypeContent->{$row->field.'_'.($edit ? 'edit' : 'add')};
                                            }
                                        @endphp
                                        @if (isset($row->details->legend) && isset($row->details->legend->text))
                                            <legend class="text-{{ $row->details->legend->align ?? 'center' }}" style="background-color: {{ $row->details->legend->bgcolor ?? '#f0f0f0' }};padding: 5px;">{{ $row->details->legend->text }}</legend>
                                        @endif

                                        <div class="form-group @if($row->type == 'hidden') hidden @endif col-md-{{ $display_options->width ?? 12 }} {{ $errors->has($row->field) ? 'has-error' : '' }}" @if(isset($display_options->id)){{ "id=$display_options->id" }}@endif>
                                            {{ $row->slugify }}
                                            <label class="control-label" for="name">{{ $row->getTranslatedAttribute('display_name') }}</label>
                                            @if(isset($row->details->mitoolstip))
                                            <i class="voyager-info-circled" data-toggle="tooltip" rel="tooltip" title="{{ $row->details->mitoolstip }}"></i>
                                            @endif
                                            @include('voyager::multilingual.input-hidden-bread-edit-add')
                                            @if (isset($row->details->view))
                                                @include($row->details->view, ['row' => $row, 'dataType' => $dataType, 'dataTypeContent' => $dataTypeContent, 'content' => $dataTypeContent->{$row->field}, 'action' => ($edit ? 'edit' : 'add'), 'view' => ($edit ? 'edit' : 'add'), 'options' => $row->details])
                                            @elseif ($row->type == 'relationship')
                                                @include('voyager::formfields.relationship', ['options' => $row->details])
                                            @else
                                                {!! app('voyager')->formField($row, $dataType, $dataTypeContent) !!}
                                            @endif

                                            @foreach (app('voyager')->afterFormFields($row, $dataType, $dataTypeContent) as $after)
                                                {!! $after->handle($row, $dataType, $dataTypeContent) !!}
                                            @endforeach
                                            @if ($errors->has($row->field))
                                                @foreach ($errors->get($row->field) as $error)
                                                    <span class="help-block">{{ $error }}</span>
                                                @endforeach
                                            @endif
                                        </div>
                                    @endforeach

                                </div><!-- panel-body -->

                                <div class="panel-footer">
                                    @section('submit-buttons')
                                        <button type="submit" class="btn btn-primary save">{{ __('voyager::generic.save') }}</button>
                                    @stop
                                    @yield('submit-buttons')
                                </div>
                            </form>

                            <iframe id="form_target" name="form_target" style="display:none"></iframe>
                            <form id="my_form" action="{{ route('voyager.upload') }}" target="form_target" method="post"
                                    enctype="multipart/form-data" style="width:0;height:0;overflow:hidden">
                                <input name="image" id="upload_file" type="file"
                                        onchange="$('#my_form').submit();this.value='';">
                                <input type="hidden" name="type_slug" id="type_slug" value="{{ $dataType->slug }}">
                                {{ csrf_field() }}
                            </form>

                        </div>
                    </div>
                </div>
            </div>
            @break
        @default
            <div class="page-content edit-add container-fluid">
                <div class="row">
                    <div class="col-md-12">

                        <div class="panel panel-bordered">
                            <!-- form start -->
                            <form role="form"
                                    class="form-edit-add"
                                    action="{{ $edit ? route('voyager.'.$dataType->slug.'.update', $dataTypeContent->getKey()) : route('voyager.'.$dataType->slug.'.store') }}"
                                    method="POST" enctype="multipart/form-data">
                                <!-- PUT Method if we are editing -->
                                @if($edit)
                                    {{ method_field("PUT") }}
                                @endif

                                <!-- CSRF TOKEN -->
                                {{ csrf_field() }}

                                <div class="panel-body">

                                    @if (count($errors) > 0)
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    <!-- Adding / Editing -->
                                    @php
                                        $dataTypeRows = $dataType->{($edit ? 'editRows' : 'addRows' )};
                                    @endphp

                                    @foreach($dataTypeRows as $row)
                                        <!-- GET THE DISPLAY OPTIONS -->
                                        @php
                                            $display_options = $row->details->display ?? NULL;
                                            if ($dataTypeContent->{$row->field.'_'.($edit ? 'edit' : 'add')}) {
                                                $dataTypeContent->{$row->field} = $dataTypeContent->{$row->field.'_'.($edit ? 'edit' : 'add')};
                                            }
                                        @endphp
                                        @if (isset($row->details->legend) && isset($row->details->legend->text))
                                            <legend class="text-{{ $row->details->legend->align ?? 'center' }}" style="background-color: {{ $row->details->legend->bgcolor ?? '#f0f0f0' }};padding: 5px;">{{ $row->details->legend->text }}</legend>
                                        @endif

                                        <div class="form-group @if($row->type == 'hidden') hidden @endif col-md-{{ $display_options->width ?? 12 }} {{ $errors->has($row->field) ? 'has-error' : '' }}" @if(isset($display_options->id)){{ "id=$display_options->id" }}@endif>
                                            {{ $row->slugify }}
                                            <label class="control-label" for="name">{{ $row->getTranslatedAttribute('display_name') }}</label>
                                            @include('voyager::multilingual.input-hidden-bread-edit-add')
                                            @if (isset($row->details->view))
                                                @include($row->details->view, ['row' => $row, 'dataType' => $dataType, 'dataTypeContent' => $dataTypeContent, 'content' => $dataTypeContent->{$row->field}, 'action' => ($edit ? 'edit' : 'add'), 'view' => ($edit ? 'edit' : 'add'), 'options' => $row->details])
                                            @elseif ($row->type == 'relationship')
                                                @include('voyager::formfields.relationship', ['options' => $row->details])
                                            @else
                                                {!! app('voyager')->formField($row, $dataType, $dataTypeContent) !!}
                                            @endif

                                            @foreach (app('voyager')->afterFormFields($row, $dataType, $dataTypeContent) as $after)
                                                {!! $after->handle($row, $dataType, $dataTypeContent) !!}
                                            @endforeach
                                            @if ($errors->has($row->field))
                                                @foreach ($errors->get($row->field) as $error)
                                                    <span class="help-block">{{ $error }}</span>
                                                @endforeach
                                            @endif
                                        </div>
                                    @endforeach

                                </div><!-- panel-body -->

                                <div class="panel-footer">
                                    @section('submit-buttons')
                                        <button type="submit" class="btn btn-primary save">{{ __('voyager::generic.save') }}</button>
                                    @stop
                                    @yield('submit-buttons')
                                </div>
                            </form>

                            <iframe id="form_target" name="form_target" style="display:none"></iframe>
                            <form id="my_form" action="{{ route('voyager.upload') }}" target="form_target" method="post"
                                    enctype="multipart/form-data" style="width:0;height:0;overflow:hidden">
                                <input name="image" id="upload_file" type="file"
                                        onchange="$('#my_form').submit();this.value='';">
                                <input type="hidden" name="type_slug" id="type_slug" value="{{ $dataType->slug }}">
                                {{ csrf_field() }}
                            </form>

                        </div>
                    </div>
                </div>
            </div>
    @endswitch

    <div class="modal fade modal-danger" id="confirm_delete_modal">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"
                            aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><i class="voyager-warning"></i> {{ __('voyager::generic.are_you_sure') }}</h4>
                </div>

                <div class="modal-body">
                    <h4>{{ __('voyager::generic.are_you_sure_delete') }} '<span class="confirm_delete_name"></span>'</h4>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>
                    <button type="button" class="btn btn-danger" id="confirm_delete">{{ __('voyager::generic.delete_confirm') }}</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Delete File Modal -->

    <div class="modal fade modal-primary" id="modal_remitente">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"
                            aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><i class="voyager-warning"></i> Remitentes </h4>
                </div>

                <div class="modal-body">

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>
                    {{-- <button type="button" class="btn btn-danger" id="confirm_delete">{{ __('voyager::generic.delete_confirm') }}</button> --}}
                </div>
            </div>
        </div>
    </div>

@stop

<!-- -------------------CARGADO DE JS----------------------- -->
<!-- -------------------CARGADO DE JS----------------------- -->

@switch($dataType->getTranslatedAttribute('slug'))

    @case('documentos')
        @section('javascript')
            <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
            <script>
                var params = {};
                var $file;
                function deleteHandler(tag, isMulti) {
                    return function() {
                        $file = $(this).siblings(tag);
                        params = {
                            slug:   '{{ $dataType->slug }}',
                            filename:  $file.data('file-name'),
                            id:     $file.data('id'),
                            field:  $file.parent().data('field-name'),
                            multi: isMulti,
                            _token: '{{ csrf_token() }}'
                        }
                        $('.confirm_delete_name').text(params.filename);
                        $('#confirm_delete_modal').modal('show');
                    };
                }
                $('document').ready(function () {
                    $('.js-example-basic-single').select2();
                    $('input[name="editor_id"]').val('{{ Auth::user()->id }}');
                    // $('#user_remitente').val("{{ Auth::user()->id }}");
                    remitente_interno();
                    doc_categoria();
                    destinatario();

                    $('.toggleswitch').bootstrapToggle();
                    //Init datepicker for date fields if data-datepicker attribute defined
                    //or if browser does not handle date inputs
                    $('.form-group input[type=date]').each(function (idx, elt) {
                        if (elt.hasAttribute('data-datepicker')) {
                            elt.type = 'text';
                            $(elt).datetimepicker($(elt).data('datepicker'));
                        } else if (elt.type != 'date') {
                            elt.type = 'text';
                            $(elt).datetimepicker({
                                format: 'L',
                                extraFormats: [ 'YYYY-MM-DD' ]
                            }).datetimepicker($(elt).data('datepicker'));
                        }
                    });
                    @if ($isModelTranslatable)
                        $('.side-body').multilingual({"editing": true});
                    @endif
                    $('.side-body input[data-slug-origin]').each(function(i, el) {
                        $(el).slugify();
                    });
                    $('.form-group').on('click', '.remove-multi-image', deleteHandler('img', true));
                    $('.form-group').on('click', '.remove-single-image', deleteHandler('img', false));
                    $('.form-group').on('click', '.remove-multi-file', deleteHandler('a', true));
                    $('.form-group').on('click', '.remove-single-file', deleteHandler('a', false));

                    $('#confirm_delete').on('click', function(){
                        $.post('{{ route('voyager.'.$dataType->slug.'.media.remove') }}', params, function (response) {
                            if ( response
                                && response.data
                                && response.data.status
                                && response.data.status == 200 ) {

                                toastr.success(response.data.message);
                                $file.parent().fadeOut(300, function() { $(this).remove(); })
                            } else {
                                toastr.error("Error removing file.");
                            }
                        });

                        $('#confirm_delete_modal').modal('hide');
                    });
                    $('[data-toggle="tooltip"]').tooltip();


                });

                //Cargar Remitentes por defecto (Internos)
                async function remitente_interno(){
                    var user = await axios.get("{{ setting('admin.url') }}api/users");
                    $('#user_remitente').find('option').remove().end();
                    $('#user_remitente').append($('<option>', {
                        value: 0,
                        text: 'Elige un Remitente'
                    }));
                    for (let index = 0; index < user.data.length; index++) {
                        $('#user_remitente').append($('<option>', {
                            value: user.data[index].id,
                            text: user.data[index].name
                        }));
                    }
                    $('#user_remitente').val("{{ Auth::user()->id }}");
                    var remitente_id_interno= $('#user_remitente').val();
                    var remitente_id_externo= '';
                    $("input[name='remitente_id_interno']").val(remitente_id_interno);
                }

                //Cargar Remitentes Externos
                async function remitente_externo(){
                    var user = await axios.get("{{ setting('admin.url') }}api/personas");
                    $('#user_remitente').find('option').remove().end();
                    $('#user_remitente').append($('<option>', {
                        value: 0,
                        text: 'Elige un Remitente'
                    }));
                    for (let index = 0; index < user.data.length; index++) {
                        $('#user_remitente').append($('<option>', {
                            value: user.data[index].id,
                            text: user.data[index].display
                        }));
                    }
                }

                //Cargar Remitente Según el Tipo de Persona (Interno/Externo)
                $("select[name='tipo']").on('change', function() {
                    agregar_remitente(this.value);
                    toastr.info('Cargando nueva lista: '+this.value)
                });

                async function agregar_remitente(tipo){
                    if(tipo=="Interno"){
                        remitente_interno();
                    }
                    if(tipo=="Externo"){
                        //console.log('entro a externo')
                        remitente_externo();
                    }
                }

                $('#user_remitente').on('change', function() {
                    //$('input[name="remitente_id"]').val(this.value);
                    if($("select[name='tipo']").val()=='Interno'){
                        var remitente_id_interno= $('#user_remitente').val();
                        var remitente_id_externo= '';
                    }
                    if($("select[name='tipo']").val()=='Externo'){
                        var remitente_id_interno= '';
                        var remitente_id_externo= $('#user_remitente').val();
                    }
                    $("input[name='remitente_id_interno']").val(remitente_id_interno);
                    $("input[name='remitente_id_externo']").val(remitente_id_externo);


                    toastr.info('Cambio de Remitente')
                });

                //Funcion Categorias para documento
                async function doc_categoria(){
                    var categoria = await axios.get("{{ setting('admin.url') }}api/categorias");
                    $('#document_categoria').find('option').remove().end();
                    $('#document_categoria').append($('<option>', {
                        value: 0,
                        text: 'Elige una Categoría'
                    }));
                    for (let index = 0; index < categoria.data.length; index++) {
                        $('#document_categoria').append($('<option>', {
                            value: categoria.data[index].id,
                            text: categoria.data[index].name
                        }));
                    }
                }

                $('#document_categoria').on('change', function() {
                    $('input[name="categoria_id"]').val(this.value);
                    toastr.info('Cambio de Categoria')
                });

                //Funcion Destinatarios para documento
                async function destinatario(){
                    var destinatario = await axios.get("{{ setting('admin.url') }}api/users");
                    $('#user_destinatario').find('option').remove().end();
                    $('#user_destinatario').append($('<option>', {
                        value: 0,
                        text: 'Elige un Destinatario'
                    }));
                    for (let index = 0; index < destinatario.data.length; index++) {
                        $('#user_destinatario').append($('<option>', {
                            value: destinatario.data[index].id,
                            text: destinatario.data[index].name
                        }));
                    }
                }

                $('#user_destinatario').on('change', function() {
                    $('input[name="destinatario_id"]').val(this.value);
                    toastr.info('Cambio de Destinatario')
                });

                async function save_document(){
                    var estado_id=$('input[name="estado_id"]').val();
                    var categoria_id=$('input[name="categoria_id"]').val();
                    var archivo=$('input[name="archivo[]"]').val();
                    var pdf=$('input[name="pdf[]"]').val();
                    var tipo =$("select[name='tipo']").val();
                    var editor_id=$('input[name="editor_id"]').val();
                    var copias=$("select[name='documento_belongstomany_user_relationship[]']").val();
                    var remitente_id_interno= $('input[name="remitente_id_interno"]').val();
                    var remitente_id_externo= $('input[name="remitente_id_externo"]').val();
                    var midata = JSON.stringify({'estado_id':estado_id, 'categoria_id':categoria_id, 'tipo':tipo, 'editor_id':editor_id, 'copias':copias, archivo: archivo, 'remitente_id_interno':remitente_id_interno, 'remitente_id_externo':remitente_id_externo});
                    var midata2 = {
                        'estado_id': estado_id,
                        'categoria_id': categoria_id,
                        'tipo': tipo,
                        'editor_id': editor_id,
                        'copias': copias,
                        'archivo': archivo,
                        'pdf': pdf,
                        'remitente_id_interno': remitente_id_interno,
                        'remitente_id_externo': remitente_id_externo
                    }
                    console.log(midata2)
                    var files = $("input[name='archivo[]']")[0].files;
                    for (var i = 0; i < files.length; i++)
                    {
                        console.log(files[i].name);
                    }
                    var pdfs = $("input[name='pdf[]']")[0].files;
                    for (var i = 0; i < pdfs.length; i++)
                    {
                        console.log(pdfs[i].name);
                    }
                    var misave = await axios.post("{{setting('admin.url')}}api/documento/save", midata2)
                    console.log(misave.data)

                }
            </script>
        @stop
    @break
    @case('convocatorias')
        @section('javascript')
            <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
            <script>
                var params = {};
                var $file;
                function deleteHandler(tag, isMulti) {
                    return function() {
                        $file = $(this).siblings(tag);
                        params = {
                            slug:   '{{ $dataType->slug }}',
                            filename:  $file.data('file-name'),
                            id:     $file.data('id'),
                            field:  $file.parent().data('field-name'),
                            multi: isMulti,
                            _token: '{{ csrf_token() }}'
                        }
                        $('.confirm_delete_name').text(params.filename);
                        $('#confirm_delete_modal').modal('show');
                    };
                }
                $('document').ready(function () {
                    $('.js-example-basic-single').select2();
                    $('input[name="editor_id"]').val('{{ Auth::user()->id }}');

                    $('.toggleswitch').bootstrapToggle();
                    //Init datepicker for date fields if data-datepicker attribute defined
                    //or if browser does not handle date inputs
                    $('.form-group input[type=date]').each(function (idx, elt) {
                        if (elt.hasAttribute('data-datepicker')) {
                            elt.type = 'text';
                            $(elt).datetimepicker($(elt).data('datepicker'));
                        } else if (elt.type != 'date') {
                            elt.type = 'text';
                            $(elt).datetimepicker({
                                format: 'L',
                                extraFormats: [ 'YYYY-MM-DD' ]
                            }).datetimepicker($(elt).data('datepicker'));
                        }
                    });
                    @if ($isModelTranslatable)
                        $('.side-body').multilingual({"editing": true});
                    @endif
                    $('.side-body input[data-slug-origin]').each(function(i, el) {
                        $(el).slugify();
                    });
                    $('.form-group').on('click', '.remove-multi-image', deleteHandler('img', true));
                    $('.form-group').on('click', '.remove-single-image', deleteHandler('img', false));
                    $('.form-group').on('click', '.remove-multi-file', deleteHandler('a', true));
                    $('.form-group').on('click', '.remove-single-file', deleteHandler('a', false));

                    $('#confirm_delete').on('click', function(){
                        $.post('{{ route('voyager.'.$dataType->slug.'.media.remove') }}', params, function (response) {
                            if ( response
                                && response.data
                                && response.data.status
                                && response.data.status == 200 ) {

                                toastr.success(response.data.message);
                                $file.parent().fadeOut(300, function() { $(this).remove(); })
                            } else {
                                toastr.error("Error removing file.");
                            }
                        });

                        $('#confirm_delete_modal').modal('hide');
                    });
                    $('[data-toggle="tooltip"]').tooltip();

                });
            </script>
        @stop
    @break
    @default
        @section('javascript')
            <script>
                var params = {};
                var $file;
                function deleteHandler(tag, isMulti) {
                    return function() {
                        $file = $(this).siblings(tag);

                        params = {
                            slug:   '{{ $dataType->slug }}',
                            filename:  $file.data('file-name'),
                            id:     $file.data('id'),
                            field:  $file.parent().data('field-name'),
                            multi: isMulti,
                            _token: '{{ csrf_token() }}'
                        }

                        $('.confirm_delete_name').text(params.filename);
                        $('#confirm_delete_modal').modal('show');
                    };
                }
                $('document').ready(function () {
                    $('.toggleswitch').bootstrapToggle();
                    //Init datepicker for date fields if data-datepicker attribute defined
                    //or if browser does not handle date inputs
                    $('.form-group input[type=date]').each(function (idx, elt) {
                        if (elt.hasAttribute('data-datepicker')) {
                            elt.type = 'text';
                            $(elt).datetimepicker($(elt).data('datepicker'));
                        } else if (elt.type != 'date') {
                            elt.type = 'text';
                            $(elt).datetimepicker({
                                format: 'L',
                                extraFormats: [ 'YYYY-MM-DD' ]
                            }).datetimepicker($(elt).data('datepicker'));
                        }
                    });
                    @if ($isModelTranslatable)
                        $('.side-body').multilingual({"editing": true});
                    @endif
                    $('.side-body input[data-slug-origin]').each(function(i, el) {
                        $(el).slugify();
                    });
                    $('.form-group').on('click', '.remove-multi-image', deleteHandler('img', true));
                    $('.form-group').on('click', '.remove-single-image', deleteHandler('img', false));
                    $('.form-group').on('click', '.remove-multi-file', deleteHandler('a', true));
                    $('.form-group').on('click', '.remove-single-file', deleteHandler('a', false));

                    $('#confirm_delete').on('click', function(){
                        $.post('{{ route('voyager.'.$dataType->slug.'.media.remove') }}', params, function (response) {
                            if ( response
                                && response.data
                                && response.data.status
                                && response.data.status == 200 ) {

                                toastr.success(response.data.message);
                                $file.parent().fadeOut(300, function() { $(this).remove(); })
                            } else {
                                toastr.error("Error removing file.");
                            }
                        });

                        $('#confirm_delete_modal').modal('hide');
                    });
                    $('[data-toggle="tooltip"]').tooltip();
                });
            </script>
        @stop
@endswitch

