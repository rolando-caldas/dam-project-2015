@extends ('layout')

@section ('javascript')
    <script src="/js/jquery.qrcode-0.12.0.min.js"></script>        
    <script src="/js/envio.jquery.js"></script>
@endsection

@section ('title') Ficha envío @endsection

@section ('panel') Información sobre #{{$envio->id}} @endsection

@section ('content')

<!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist">
    <li role="presentation"><a href="/envio/view/{{$envio->id}}" aria-controls="home" role="tab" class="fa fa-info-circle">Info</a></li>
    <li role="presentation" class="active"><a href="/envio/qr/{{$envio->id}}" aria-controls="settings" role="tab" class="fa fa-qrcode">Etiqueta</a></li>
    <li role="presentation"><a href="/envio/edit/{{$envio->id}}" aria-controls="profile" role="tab" class="fa fa-pencil">Editar</a></li>
    <li role="presentation"><a href="/cliente/view/{{$envio->cliente}}" aria-controls="messages" role="tab" class="fa fa-user" target="_blank">Cliente</a></li>
    <li role="presentation"><a href="/transportista/view/{{$envio->transportista}}" aria-controls="settings" role="tab" class="fa fa-truck" target="_blank">Transportista</a></li>
</ul>

<div class="text-center">
    <table>
        <tr>
            <td id="qr"></td>
            <td>
                {{$envio->destinatario}}
                <br />
                {{$envio->direccion}}
            </td>
        </tr>
    </table>
    <div class="hidden" id="qrInfo"><?php print str_replace("\\", "", $qrInfo); ?></div>
</div>

@endsection