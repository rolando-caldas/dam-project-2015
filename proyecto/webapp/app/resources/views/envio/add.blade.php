@extends ('layout')

@section ('title') Nuevo envio @endsection

@section ('content')

<form class="form-horizontal" action="" method="post" id="clienteForm">
    <div class="form-group">
        <label for="denominacion_social" class="col-sm-2 control-label">Destinatario</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="destinatario" name="destinatario" placeholder="Destinatario" value="@if (isset($destinatario)){{$destinatario}}@endif" required>
        </div>
    </div>
    <div class="form-group">
        <label for="direccion" class="col-sm-2 control-label">Dirección</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="direccion" name="direccion" placeholder="Dirección postal" required>
        </div>
    </div>
    
    <div class="form-group">
        <label for="transportista" class="col-sm-2 control-label">Cliente</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="cliente" name="cliente" list="clientes" placeholder="Cliente" value="@if (isset($cliente)){{$cliente}}@endif" required>
            <datalist id="clientes">
                @foreach ($clientes as $cl)
                <option value="{{$cl->id}}: {{$cl->cif}}: {{$cl->denominacion_social}}" />
                @endforeach
            </datalist>
        </div>
    </div>    

    <div class="form-group">
        <label for="transportista" class="col-sm-2 control-label">Transportista</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="transportista" name="transportista" list="transportistas" placeholder="Transportista" value="@if (isset($transportista)){{$transportista}}@endif" required>
            <datalist id="transportistas">
                @foreach ($transportistas as $trans)
                <option value="{{$trans->id}}: {{$trans->nif}}: {{$trans->apellidos}}, {{$trans->nombre}}" />
                @endforeach
            </datalist>
        </div>
    </div>    
    <input type="submit" value="Enviar" class="hidden">
</form>

@endsection

@section ('footer')
<button class="btn btn-default fa fa-floppy-o" type="button" onclick="document.querySelector('#clienteForm input[type=submit]').click();">Crear cliente</button>
@endsection