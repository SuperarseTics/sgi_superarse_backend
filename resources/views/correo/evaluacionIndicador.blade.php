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
        <p>Se ha hecho la evaluación del Indicador <strong>{{$Indicador->nombre}}</strong> con un valor de {{$Indicador->valor}}%</p>
        <ul>
            <li>{{$Indicador->subcriterio->criterio->nombre}} {{$Indicador->subcriterio->criterio->valor}}%</li>
            <ul>
                <li>{{$Indicador->subcriterio->nombre}} {{$Indicador->subcriterio->valor}}%</li>
                <ul>
                    <li>{{$Indicador->nombre}} {{$Indicador->valor}}%</li>
                </ul>
            </ul>

        </ul>
        <p>Presentando los siguientes resultados</p>
        <?php foreach ($resultados as $res) { ?>
            <div>
                <p><strong>Fecha: </strong>{{$res->created_at}}<br>
                    {{$res->resultado}}
                </p>
            </div>
        <?php } ?>
        <img src="https://www.superarse.edu.ec/imagenes/logo.png" width="200px"/>
        <p style="margin-top: -30px;">Av. General Rumiñahui 1111 e Isla Pinta ( A una cuadra del San Luis Shopping)</p>
    </body>
</html>