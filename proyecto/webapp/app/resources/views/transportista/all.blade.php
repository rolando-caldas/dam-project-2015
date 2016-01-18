@extends ('layout')

@section ('title') Transportistas @endsection
@section ('panel') Listado de transportistas @endsection

@section ('content')
<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>NIF</th>
                <th>Apellidos</th>
                <th>Nombre</th>
                <th>Teléfono</th>
                <th>Envios</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transportistas as $transportista)
            <tr>
                <td>{{$transportista->nif}}</td>
                <td>{{$transportista->apellidos}}</td>
                <td>{{$transportista->nombre}}</td>
                <td>{{$transportista->telefono}}</td>
                <td>{{count($transportista->envio_transportista)}}</td>
                <td>
                    <div class="btn-group pull-right">
                        <a href="/transportista/edit/{{$transportista->id}}" class="btn btn-default fa fa-pencil">Editar</a>
                        <a href="/transportista/view/{{$transportista->id}}" class="btn btn-default fa fa-search">Ver</a>
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