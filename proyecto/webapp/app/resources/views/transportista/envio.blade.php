@extends ('layout')

@section ('title') Envíos Transportista @endsection
@section ('panel') Envios del transportista {{$transportista->nif}} @endsection

@section ('content')
<!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist">
    <li role="presentation"><a href="/transportista/view/{{$transportista->id}}" aria-controls="home" role="tab"  class="fa fa-info-circle">Info</a></li>
    <li role="presentation"><a href="/transportista/edit/{{$transportista->id}}" aria-controls="profile" role="tab" class="fa fa-pencil">Editar</a></li>
    <li role="presentation" class="active"><a href="/transportista/envio/{{$transportista->id}}" aria-controls="settings" role="tab" class="fa fa-truck">Envíos</a></li>
</ul>

<!-- Tab panes -->
<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Destinatario</th>
                <th>Dirección</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($envios as $envio)
            <tr>
                <td>{{$envio->fecha_creacion}}</td>
                <td>{{$envio->destinatario}}</td>
                <td>{{$envio->direccion}}</td>
                <td>
                    <div class="btn-group pull-right">
                        <a href="/transportista/envio/{{$transportista->id}}/info/{{$envio->id}}" class="btn btn-default fa fa-search">Ver</a>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

@section ('footer')
<a href="/transportista/add" class="btn btn-default fa fa-user-plus">Nuevo transportista</a>                    
@endsection