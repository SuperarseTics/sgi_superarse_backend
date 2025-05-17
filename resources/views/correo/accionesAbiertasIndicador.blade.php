<html>
    <head>
        <style>
            body{
                font-size: 14px;

            }

        </style>

    </head>
    <body>
        <h1 style="font-size: 18px;">Estimado(a): {{$nombre}}</h1>
        <p>El Indicador <strong>{{$Indicador->nombre}}</strong> presenta las siguientes acciones abiertas:</p>
        <table width="640px" border="1">
            <thead>
                <tr>
                    <th colspan="3" style="text-align: center;">Acciones Correctivas</th>
                </tr>
                <tr>
                    <th>Indicador</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($accionesCorrectivas as $ac) { ?>
                    <tr>
                        <td>{{$ac->indicador->nombre}}</td>
                        <td>{{$ac->nombre}}</td>
                        <td>{{$ac->descripcion}}</td>
                    </tr>
                <?php } ?>
            </tbody>

        </table>

        <img src="https://www.superarse.edu.ec/imagenes/logo.png" width="200px"/>
        <p style="margin-top: -30px;">Av. General Rumiñahui 1111 e Isla Pinta ( A una cuadra del San Luis Shopping)</p>
    </body>
</html>