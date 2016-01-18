@extends ('layout')

@section ('title') Clientes @endsection
@section ('panel') Nuevo envio del cliente {{$cliente->cif}} @endsection

@section ('content')

<!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist">
    <li role="presentation"><a href="/cliente/view/{{$cliente->id}}" aria-controls="home" role="tab" class="fa fa-info-circle">Info</a></li>
    <li role="presentation"><a href="/cliente/edit/{{$cliente->id}}" aria-controls="profile" role="tab" class="fa fa-pencil">Editar</a></li>
    <li role="presentation" class="active"><a href="/cliente/envio/{{$cliente->id}}/add" aria-controls="messages" role="tab" class="fa fa-gift">Nuevo Envío</a></li>
    <li role="presentation"><a href="/cliente/envio/{{$cliente->id}}" aria-controls="settings" role="tab" class="fa fa-truck">Envíos</a></li>
</ul>


<form class="form-horizontal" action="" method="post" id="envioForm">
    <div class="form-group">
        <label for="destinatario" class="col-sm-2 control-label">Destinatario</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="destinatario" name="destinatario" placeholder="Destinatario" required>
        </div>
    </div>
    <div class="form-group">
        <label for="direccion" class="col-sm-2 control-label">Dirección</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="direccion" name="direccion" placeholder="Dirección postal" required>
        </div>
    </div>
    <div class="form-group">
        <label for="transportista" class="col-sm-2 control-label">Transportista</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="transportista" name="transportista" list="transportistas" placeholder="Transportista" required>
            <datalist id="transportistas">
                @foreach ($transportistas as $transportista)
                <option value="{{$transportista->id}}: {{$transportista->nif}}: {{$transportista->apellidos}}, {{$transportista->nombre}}" />
                @endforeach
            </datalist>
        </div>
    </div>
    <input type="submit" value="Enviar" class="hidden">
</form>

@endsection

@section ('footer')
<button class="btn btn-default fa fa-floppy-o" type="button" onclick="document.querySelector('#envioForm input[type=submit]').click();">Crear envío</button>
@endsection