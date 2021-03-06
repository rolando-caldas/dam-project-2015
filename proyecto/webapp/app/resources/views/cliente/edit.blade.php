@extends ('layout')

@section ('title') Ficha cliente @endsection

@section ('panel') Información sobre {{$cliente->cif}} @endsection

@section ('content')

<!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist">
    <li role="presentation"><a href="/cliente/view/{{$cliente->id}}" aria-controls="home" role="tab" class="fa fa-info-circle">Info</a></li>
    <li role="presentation" class="active"><a href="/cliente/edit/{{$cliente->id}}" aria-controls="profile" role="tab" class="fa fa-pencil">Editar</a></li>
    <li role="presentation"><a href="/cliente/envio/{{$cliente->id}}/add" aria-controls="messages" role="tab" class="fa fa-gift">Nuevo Envío</a></li>
    <li role="presentation"><a href="/cliente/envio/{{$cliente->id}}" aria-controls="settings" role="tab" class="fa fa-truck">Envíos</a></li>
</ul>

<form class="form-horizontal" action="" method="post" id="clienteForm">
    <div class="form-group">
        <label for="cif" class="col-sm-2 control-label">CIF</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="cif" name="cif" placeholder="CIF" value="{{$cliente->cif}}" required>
        </div>
    </div>
    <div class="form-group">
        <label for="denominacion_social" class="col-sm-2 control-label">D.Social</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="denominacion_social" name="denominacion_social" placeholder="Denominación social" value="{{$cliente->denominacion_social}}" required>
        </div>
    </div>
    <div class="form-group">
        <label for="telefono" class="col-sm-2 control-label">Teléfono</label>
        <div class="col-sm-10">
            <input type="number" class="form-control" id="telefono" name="telefono" placeholder="Teléfono de contacto" value="{{$cliente->telefono}}" required>
        </div>
    </div>
    <div class="form-group">
        <label for="direccion" class="col-sm-2 control-label">Dirección</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="direccion" name="direccion" placeholder="Dirección postal" value="{{$cliente->direccion}}" required>
        </div>
    </div>
    <input type="submit" value="Enviar" class="hidden">
</form>        


@endsection

@section ('footer')
<button class="btn btn-default fa fa-floppy-o" type="button" onclick="document.querySelector('#clienteForm input[type=submit]').click();">Guardar</button>
@endsection