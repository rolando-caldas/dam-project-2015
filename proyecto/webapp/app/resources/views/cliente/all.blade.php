@extends ('layout')

@section ('title') Clientes @endsection
@section ('panel') Listado de clientes @endsection

@section ('content')
<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>CIF</th>
                <th>Nombre</th>
                <th>Teléfono</th>
                <th>Envios</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($clientes as $user)
            <tr>
                <td>{{$user->cif}}</td>
                <td>{{$user->denominacion_social}}</td>
                <td>{{$user->telefono}}</td>
                <td>{{count($user->envio_cliente)}}</td>
                <td>
                    <div class="btn-group pull-right">
                        <a href="/cliente/edit/{{$user->id}}" class="btn btn-default fa fa-pencil">Editar</a>
                        <a href="/cliente/view/{{$user->id}}" class="btn btn-default fa fa-search">Ver</a>
                        <a href="/cliente/envio/{{$user->id}}" class="btn btn-default fa fa-truck">Envios</a>                    
                        <a href="/cliente/envio/{{$user->id}}/add" class="btn btn-default fa fa-gift">Nuevo envio</a>                    
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

@section ('footer')
    <a href="/cliente/add" class="btn btn-default fa fa-user-plus">Nuevo cliente</a>                    
@endsection