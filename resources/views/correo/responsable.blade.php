<html>
    <head>
        <style>
            body{
                font-size: 14px;
            }

        </style>

    </head>
    <body>
        <h1 style="font-size: 18px;">Estimado(a): {{$Profesor->nombre}}</h1>
        <p>A continuación le enviamos los datos para acceder al sistema SIG:</p>
        <p><strong>URL: </strong><a href="{{url('/')}}">{{url('/')}}</a></p>
        <p><strong>Usuario: </strong>{{$Profesor->usuario}}</p>
        <p><strong>Password: </strong>{{$password}}</p>

        <img src="https://www.superarse.edu.ec/imagenes/logo.png" width="200px"/>
        <p style="margin-top: -30px;">Av. General Rumiñahui 1111 e Isla Pinta ( A una cuadra del San Luis Shopping)</p>
    </body>
</html>