@extends ('layout')

@section ('title') Nuevo cliente @endsection

@section ('content')

<form class="form-horizontal" action="" method="post" id="clienteForm">
    <div class="form-group">
        <label for="cif" class="col-sm-2 control-label">CIF</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="cif" name="cif" placeholder="CIF" value="@if (isset($cif)){{$cif}}@endif" required>
        </div>
    </div>
    <div class="form-group">
        <label for="denominacion_social" class="col-sm-2 control-label">D.Social</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="denominacion_social" name="denominacion_social" value="@if (isset($denominacion_social)){{$denominacion_social}}@endif" placeholder="Denominación social" required>
        </div>
    </div>
    <div class="form-group">
        <label for="telefono" class="col-sm-2 control-label">Teléfono</label>
        <div class="col-sm-10">
            <input type="number" class="form-control" id="telefono" name="telefono" value="@if (isset($telefono)){{$telefono}}@endif" placeholder="Teléfono de contacto" required>
        </div>
    </div>
    <div class="form-group">
        <label for="direccion" class="col-sm-2 control-label">Dirección</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="direccion" name="direccion" value="@if (isset($direccion)){{$direccion}}@endif" placeholder="Dirección postal" required>
        </div>
    </div>
    <input type="submit" value="Enviar" class="hidden">
</form>

@endsection

@section ('footer')
<button class="btn btn-default fa fa-floppy-o" type="button" onclick="document.querySelector('#clienteForm input[type=submit]').click();">Crear cliente</button>
@endsection