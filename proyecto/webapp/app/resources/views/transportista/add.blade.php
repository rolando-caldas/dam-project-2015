@extends ('layout')

@section ('title') Nuevo transportista @endsection

@section ('h1') Nuevo transportista @endsection

@section ('content')

<form class="form-horizontal" action="" method="post" id="transportistaForm">
    <div class="form-group">
        <label for="nif" class="col-sm-2 control-label">NIF</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="nif" name="nif" placeholder="NIF" value="@if (isset($nif)){{$nif}}@endif" required>
        </div>
    </div>
    <div class="form-group">
        <label for="apellidos" class="col-sm-2 control-label">Apellidos</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="apellidos" name="apellidos" placeholder="Apellidos" value="@if (isset($apellidos)){{$apellidos}}@endif" required>
        </div>
    </div>
    <div class="form-group">
        <label for="nombre" class="col-sm-2 control-label">Nombre</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre" value="@if (isset($nombre)){{$nombre}}@endif" required>
        </div>
    </div>
    <div class="form-group">
        <label for="telefono" class="col-sm-2 control-label">Teléfono</label>
        <div class="col-sm-10">
            <input type="number" class="form-control" id="telefono" name="telefono" placeholder="Teléfono de contacto" value="@if (isset($telefono)){{$telefono}}@endif" required>
        </div>
    </div>
    <input type="submit" value="Enviar" class="hidden">
</form>

@endsection

@section ('footer')
<button class="btn btn-default fa fa-floppy-o" type="button" onclick="document.querySelector('#transportistaForm input[type=submit]').click();">Crear transportista</button>
@endsection