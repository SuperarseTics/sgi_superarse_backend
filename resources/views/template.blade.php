<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>SGA</title>
        <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="{{url('/')}}/css/bootstrap.min.css" type="text/css" rel="stylesheet" media="all">
        <link href="{{url('/')}}/css/font-awesome.min.css" type="text/css" rel="stylesheet" media="all">
        <link href="{{url('/')}}/css/jquery.dataTables.css" type="text/css" rel="stylesheet" media="all">
        <link href="{{url('/')}}/css/bootstrap-select.css" type="text/css" rel="stylesheet" media="all">
        <link href="{{url('/')}}/css/sweetalert.css" type="text/css" rel="stylesheet" media="all">
        <link href="{{url('/')}}/css/style.css?id={{rand()}}" type="text/css" rel="stylesheet" media="all">
        <script src="{{url('/')}}/js/jquery.min.js"></script>
        <script src="{{url('/')}}/js/bootstrap.min.js"></script>
        <script src="{{url('/')}}/js/jquery.dataTables.js"></script>
        <script src="{{url('/')}}/js/bootstrap-select.js"></script>
        <script src="{{url('/')}}/js/sweetalert.min.js"></script>
        <script src="{{url('/')}}/js/Chart.min.js"></script>
        <script src="{{url('/')}}/js/funciones.js?id={{rand()}}"></script>
    </head>
    <body>
        <div id="div-loader" class="oculto"></div>
        <input type="hidden" id="path" value="{{url('/')}}/">
        <section id='section-header'>
            <div class="container">
                <div class="row">
                    <div class="col-md-9 text-left">
                        <a href="{{url('/')}}/dash">
                            <img src="{{url('/')}}/imagenes/logo.png" width="180">
                        </a>
                    </div>
                    <div class="col-md-3 text-right">
                        <p>Bienvenido(a): {{$_SESSION['usuarioCalidad']}}</p>
                        <a href="{{url('/')}}/cerrar-sesion">Cerrar Sesión</a>
                    </div>
                </div>
            </div>
        </section>
        <section id='section-menu'>
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        @include('menu')
                    </div>
                </div>
            </div>
        </section>

        <section id='section-body'>
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        @if (session('success'))
                        <div class="mensaje-success">
                            {{ session('success') }}
                        </div>
                        @endif
                        @if (session('error'))
                        <div class="mensaje-danger">
                            {{ session('error') }}
                        </div>
                        @endif

                    </div>
                    <div class="col-md-12">
                        <ol class="breadcrumb">
                            <li><a href="{{url('/')}}/dash">Inicio</a></li>
                            <?php
                            foreach ($breadcume as $br) {
                                if ($br['url'] == "") {
                                    ?>
                                    <li class="active">{{$br['nombre']}}</li>
                                <?php } else { ?>
                                    <li><a href="{{$br['url']}}">{{$br['nombre']}}</a></li>
                                    <?php
                                }
                            }
                            ?>

                        </ol>
                    </div>

                    <div class="col-md-12 form-group">
                        <div class="panel panel-default">
                            <div class="panel-heading">{{$modulo}}</div>
                            <div class="panel-body">
                                <?php if ($permiso == 0) { ?>
                                    @include('sinPermiso')
                                <?php } else { ?>
                                    @section('contenido')

                                    @show
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>


        @section('script')

        @show
    </body>
</html>
