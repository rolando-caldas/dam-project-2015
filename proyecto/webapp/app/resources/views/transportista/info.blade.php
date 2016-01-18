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
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{$envio->fecha_creacion}}</td>
                <td>{{$envio->destinatario}}</td>
                <td>{{$envio->direccion}}</td>
            </tr>
        </tbody>
    </table>
</div>
<div class="panel panel-info">
    <div class="panel-heading">Actividad del envío</div>
    <div class="panel-body">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Observaciones</th>
                    <th>Recepción</th>
                </tr>
            </thead>
        <tbody>
            @forelse ($entregas AS $entrega)
            <tr>
                <td>{{$entrega->fecha_entrega}}</td>
                <td>{{$entrega->observaciones}}</td>
                <td>@if (!empty($entrega->firma)) <img src="{{$entrega->firma}}" alt="" title=""> @else N/A @endif</td>
            </tr>
            @empty
            <tr>
                <td colspan="3">Sin actividad</td>
            </tr>
            @endforelse
        </tbody>
        </table>
    </div>
</div>
@endsection

@section ('footer')
<a href="/cliente/add" class="btn btn-default fa fa-user-plus">Nuevo cliente</a>                    
@endsection