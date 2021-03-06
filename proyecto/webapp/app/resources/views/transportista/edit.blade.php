@extends ('layout')

@section ('title') Ficha transportista @endsection

@section ('panel') Transportista {{$transportista->nif}} @endsection

@section ('content')

<!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist">
    <li role="presentation"><a href="/transportista/view/{{$transportista->id}}" aria-controls="home" role="tab"  class="fa fa-info-circle">Info</a></li>
    <li role="presentation" class="active"><a href="/transportista/edit/{{$transportista->id}}" aria-controls="profile" role="tab" class="fa fa-pencil">Editar</a></li>
    <li role="presentation"><a href="/transportista/envio/{{$transportista->id}}" aria-controls="settings" role="tab" class="fa fa-truck">Envíos</a></li>
</ul>

<!-- Tab panes -->
<div class="tab-content">
    <div role="tabpanel" class="tab-pane active">
        <form class="form-horizontal" id="transportistaForm" action="" method="post">
            <input type="hidden" name="id" value="{{$transportista->id}}" />
            <div class="form-group">
                <label for="cif" class="col-sm-2 control-label">NIF</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="nif" name="nif" placeholder="NIF" value="{{$transportista->nif}}" >
                </div>
            </div>
            <div class="form-group">
                <label for="apellidos" class="col-sm-2 control-label">Apellidos</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="apellidos" name="apellidos" placeholder="Apellidos" value="{{$transportista->apellidos}}" >
                </div>
            </div>
            <div class="form-group">
                <label for="nombre" class="col-sm-2 control-label">Nombre</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre" value="{{$transportista->nombre}}" >
                </div>
            </div>
            <div class="form-group">
                <label for="telefono" class="col-sm-2 control-label">Teléfono</label>
                <div class="col-sm-10">
                    <input type="number" class="form-control" id="telefono" name="telefono" placeholder="Teléfono de contacto" value="{{$transportista->telefono}}" >
                </div>
            </div>
            <input type="submit" value="Guardar" class="hidden">
        </form>
    </div>
</div>


@endsection

@section ('footer')
<button class="btn btn-default fa fa-floppy-o" type="button" onclick="document.querySelector('#transportistaForm input[type=submit]').click();">Guardar</button>
@endsection