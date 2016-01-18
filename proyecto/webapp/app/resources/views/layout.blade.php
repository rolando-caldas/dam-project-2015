<!DOCTYPE html>
<html lang="es">
    <head>
        <title>@yield('title', 'TransApp')</title>

        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">
        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css" integrity="sha384-aUGj/X2zp5rLCbBxumKTCw2Z50WgIr1vs/PFN4praOTvYXWlVyh2UtNUU0KAUhAX" crossorigin="anonymous">

        <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
        <script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>        

        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js" integrity="sha512-K1qjQ+NcF2TYO/eI3M6v8EiNYZfA95pQumfvcVrTHtwQVDG+aHRqLi/ETn2uB+1JqwYqVG3LIvdm9lj6imS/pQ==" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

        @yield('javascript')        
        @yield('css')
    </head>
    <body>
        <div class="container">
            <header class="row">
                <h1>@yield('title', 'TransApp')</h1>
                <nav class="navbar navbar-default">
                    <div class="container-fluid">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                            <a class="navbar-brand" href="#">Brand</a>
                        </div>
                        <!-- Collect the nav links, forms, and other content for toggling -->
                        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                            <ul class="nav navbar-nav">                    
                                <li><a href="/cliente">Clientes</a></li>
                                <li><a href="/transportista">Transportistas</a></li>
                                <li><a href="/envio">Envíos</a></li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </header>
            <main class="row">
                <section>
                    @if (isset($success) && is_array($success))
                    @foreach ($success as $item)
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong>{{$item->key}}:</strong> {{$item->value}}
                    </div>
                    @endforeach
                    @endif

                    @if (isset($info) && is_array($info))
                    @foreach ($info as $item)
                    <div class="alert alert-info alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong>{{$item->key}}:</strong> {{$item->value}}
                    </div>
                    @endforeach
                    @endif

                    @if (isset($warning) && is_array($warning))
                    @foreach ($warning as $item)
                    <div class="alert alert-warning alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong>{{$item->key}}:</strong> {{$item->value}}
                    </div>
                    @endforeach
                    @endif

                    @if (isset($error) && is_array($error))
                    @foreach ($error as $item)
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong>{{$item->key}}:</strong> {{$item->value}}
                    </div>
                    @endforeach
                    @endif
                    
                    <div class="panel panel-primary">
                        <div class="panel-heading">@yield('panel', 'TransApp')</div>
                        <div class="panel-body">
                            @yield('content') 
                        </div>
                        <div class="panel-footer">
                            @yield('footer')
                        </div>
                    </div>                
                </section>
            </main>
            <footer class="row">
                Proyecto DAM 2015 - &copy; Rolando Caldas Sánchez
            </footer>
        </div>
    </body>
</html>