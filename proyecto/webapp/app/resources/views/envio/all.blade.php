@extends ('layout')

@section ('title') Envios @endsection
@section ('panel') Listado de envios @endsection

@section ('content')
<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Fecha</th>
                <th>Destinatario</th>
                <th>Dirección</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($envios as $user)
            <tr>
                <td>{{$user->id}}</td>
                <td>{{$user->fecha_creacion}}</td>
                <td>{{$user->destinatario}}</td>
                <td>{{$user->direccion}}</td>
                <td>
                    <div class="btn-group pull-right">
                        <a href="/envio/edit/{{$user->id}}" class="btn btn-default fa fa-pencil">Editar</a>
                        <a href="/envio/view/{{$user->id}}" class="btn btn-default fa fa-search">Ver</a>
                        <a href="/cliente/view/{{$user->cliente}}" class="btn btn-default fa fa-user" target="_blank">Cliente</a>                    
                        <a href="/transportista/view/{{$user->transportista}}" class="btn btn-default fa fa-truck" target="_blank">Transportista</a>                    
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
@section ('footer')
    <a href="/envio/add" class="btn btn-default fa fa-truck">Nuevo envío</a>                    
@endsection