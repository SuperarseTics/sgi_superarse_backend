<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>SUPERARSE::SIG</title>

        <!-- Bootstrap Core CSS -->
        <link href="{{url('/')}}/css/bootstrap.min.css" rel="stylesheet">
        <link href="{{url('/')}}/css/style.css" rel="stylesheet">



        <!-- Custom Fonts -->
        <link href="{{url('/')}}/css/font-awesome.min.css" rel="stylesheet" type="text/css">

        <!-- Custom CSS -->
        <link href="{{url('/')}}/css/styles.css" rel="stylesheet" type="text/css" media="all">



    </head>
    <body>

        <div class="container">
            <div class="col-md-6 col-md-offset-3 col-sm-12 col-xs-12">
                <div class="text-center form-group">
                    <img src="{{url('/')}}/imagenes/logo.png" width="250px">
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        LOGIN
                    </div>
                    <div class="panel-body">
                        <form method="POST" action="{{url('/')}}/verificar-login">
                            <div class="form-group">
                                <label>Usuario</label>
                                <input type="text" name="usuario" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" name="password" class="form-control">
                            </div>
                            <div class="form-group">
                                <input type="radio" name="tipo" value="usuario" id="usuario" checked="checked"> <label for="usuario">Usuario</label>
                                <input type="radio" name="tipo" value="auditor" id="auditor"> <label for="auditor">Auditor</label>
                            </div>
                            <div class="form-group">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                <button type="submit" class="btn btn-primary">Ingresar</button>
                            </div>
                            <?php if (isset($_GET['mensaje'])) { ?>
                                <div class="alert alert-danger">{{base64_decode($_GET['mensaje'])}}</div>
                            <?php } ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </body>
</html>