@extends ('layout')

@section ('title') Ficha envío @endsection

@section ('panel') Información sobre #{{$envio->id}} @endsection

@section ('content')

<!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="/envio/view/{{$envio->id}}" aria-controls="home" role="tab" class="fa fa-info-circle">Info</a></li>
    <li role="presentation"><a href="/envio/qr/{{$envio->id}}" aria-controls="settings" role="tab" class="fa fa-qrcode">Etiqueta</a></li>
    <li role="presentation"><a href="/envio/edit/{{$envio->id}}" aria-controls="profile" role="tab" class="fa fa-pencil">Editar</a></li>
    <li role="presentation"><a href="/cliente/view/{{$envio->cliente}}" aria-controls="messages" role="tab" class="fa fa-user" target="_blank">Cliente</a></li>
    <li role="presentation"><a href="/transportista/view/{{$envio->transportista}}" aria-controls="settings" role="tab" class="fa fa-truck" target="_blank">Transportista</a></li>
</ul>

<!-- Tab panes -->
<form class="form-horizontal">
    <div class="form-group">
        <label for="destinatario" class="col-sm-2 control-label">Destinatario</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="destinatario" name="destinatario" placeholder="destinatario" value="{{$envio->destinatario}}" readonly="readonly">
        </div>
    </div>
    <div class="form-group">
        <label for="direccion" class="col-sm-2 control-label">Dirección</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="direccion" name="direccion" placeholder="Dirección" value="{{$envio->direccion}}" readonly="readonly">
        </div>
    </div>
    <div class="form-group">
        <label for="fecha_creacion" class="col-sm-2 control-label">Fecha</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="fecha_creacion" name="fecha_creacion" placeholder="Fecha" value="{{$envio->fecha_creacion}}" readonly="readonly">
        </div>
    </div>
</form>

@endsection