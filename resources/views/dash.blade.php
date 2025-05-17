@extends('template')

@section('contenido')


<input type="hidden" id="ids" value="{{json_encode($ids)}}">
<input type="hidden" id="nombreCriterios" value="{{json_encode($nombreCriterios)}}">
<input type="hidden" id="valoresCriterios" value="{{json_encode($valoresCriterios)}}">
<input type="hidden" id="colores" value="{{json_encode($colores)}}">
<input type="hidden" id="bordes" value="{{json_encode($bordes)}}">


<div class="row">
    <?php
    if ($_SESSION['rolCalidad'] != "Evaluador") {
        foreach ($criterios as $cri) {
            ?>

            <div class="col-md-6 col-sm-6 col-xs-6 form-group">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-10 col-sm-10 col-xs-10">
                                {{$cri->nombre}}        
                            </div>
                            <div class="col-md-2 col-sm-2 col-xs-2">
                                {{$cri->peso}}%
                            </div>
                        </div>

                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <canvas id="criterio_{{$cri->id}}"></canvas>        
                            </div>
                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <table class="table table-striped table-bordered tabla-indicadores-dash">
                                    <thead>
                                        <tr>
                                            <th>Indicador</th>
                                            <th>Valor</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $total = 0;
                                        foreach ($cri->indicadores as $ind) {
                                            $total = $total + $ind->valor;
                                            ?>
                                            <tr>
                                                <td>{{$ind->nombre}}</td>
                                                <td class="text-right">{{$ind->valor}}%</td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                    <tfoot>
                                        <tr class="text-success">
                                            <th class="text-right">Total Desarrollado</th>
                                            <th class="text-right">{{$total}}%</th>
                                        </tr>
                                        <tr class="text-danger">
                                            <th class="text-right">Total Faltante</th>
                                            <th class="text-right">{{$cri->peso-$total}}%</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>


                    </div>
                    <div class="panel-footer">


                    </div>
                </div>
            </div>
            <?php
        }
    } else {

        foreach ($criterios as $cri) {
            if (in_array($cri->id, $_SESSION['criterios'])) {
                ?>

                <div class="col-md-6 col-sm-6 col-xs-6 form-group">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-md-10 col-sm-10 col-xs-10">
                                    {{$cri->nombre}}        
                                </div>
                                <div class="col-md-2 col-sm-2 col-xs-2">
                                    {{$cri->peso}}%
                                </div>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    <canvas id="criterio_{{$cri->id}}"></canvas>        
                                </div>
                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    <table class="table table-striped table-bordered tabla-indicadores-dash">
                                        <thead>
                                            <tr>
                                                <th>Indicador</th>
                                                <th>Valor</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $total = 0;
                                            foreach ($cri->indicadores as $ind) {
                                                $total = $total + $ind->valor;
                                                ?>
                                                <tr>
                                                    <td>{{$ind->nombre}}</td>
                                                    <td class="text-right">{{$ind->valor}}%</td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                        <tfoot>
                                            <tr class="text-success">
                                                <th class="text-right">Total Desarrollado</th>
                                                <th class="text-right">{{$total}}%</th>
                                            </tr>
                                            <tr class="text-danger">
                                                <th class="text-right">Total Faltante</th>
                                                <th class="text-right">{{$cri->peso-$total}}%</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>


                        </div>
                        <div class="panel-footer">
                            <a href="{{url('/')}}/evaluacion/{{$cri->id}}" class="btn btn-primary" style="width: 100%;">Evaluar</a>
                        </div>
                    </div>
                </div>
                <?php
            }
        }
    }
    ?>
</div>


<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12 form-group">
        <div class="panel panel-primary">
            <div class="panel-heading">
                Valores por Indicadores
            </div>
            <div class="panel-body">

                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Criterio</th>
                            <th>SubCriterio</th>
                            <th>Indicador</th>
                            <th>Peso Indicador</th>
                            <th>Valor Indicador</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $totalPeso = 0;
                        $totalValor = 0;
                        foreach ($criterios as $cri) {

                            foreach ($cri->indicadores as $ind) {
                                $totalPeso = $totalPeso + $ind->peso;
                                $totalValor = $totalValor + $ind->valor;
                                ?>
                                <tr>
                                    <td>{{$cri->nombre}}</td>
                                    <td>{{$ind->subcriterio->nombre}}</td>
                                    <td>{{$ind->nombre}}</td>
                                    <td class="text-right">{{$ind->peso}}%</td>
                                    <td class="text-right">{{$ind->valor}}%</td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="3" class="text-right">Total</th>
                            <th class="text-right">{{$totalPeso}}%</th>
                            <th class="text-right">{{$totalValor}}%</th>
                        </tr>
                    </tfoot>
                </table>


            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12 form-group">
        <div class="panel panel-primary">
            <div class="panel-heading">Valores Por Criterios</div>

            <div class="panel-body">
                <div class="row">
                    <div class="col-md-5 col-sm-12 col-xs-12">
                        <canvas id="pieChart"></canvas>
                    </div>
                    <div class="col-md-7 col-sm-12 col-xs-12">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Criterio</th>
                                    <th>Valor</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $total = 0;
                                foreach ($criterios as $cri) {
                                    $total = $total + $cri->valor;
                                    ?>
                                    <tr>
                                        <td>{{$cri->nombre}}</td>
                                        <td class="text-right">{{$cri->valor}}%</td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th class="text-right">Total Realizado</th>
                                    <th class="text-right">{{$total}}%</th>
                                </tr>
                                <tr>
                                    <th class="text-right">Total Faltante</th>
                                    <th class="text-right">{{100-$total}}%</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@stop


@section('script')

<script>
    $(document).ready(function () {
        var ids = JSON.parse($("#ids").val());

        for (var i = 0; i < ids.length; i++) {

            var desarrollado = ids[i]['valor'] * 1;
            var faltante = ids[i]['peso'] - desarrollado;
            var id = ids[i]['id'] * 1;

            var doughnutPieData = {
                datasets: [{
                        data: [desarrollado, faltante],
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.5)',
                            'rgba(54, 162, 235, 0.5)',
                            'rgba(255, 206, 86, 0.5)',
                            'rgba(75, 192, 192, 0.5)',
                        ],
                        borderColor: [
                            'rgba(255,99,132,1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                        ],
                    }],

                // These labels appear in the legend and in the tooltips when hovering different arcs
                labels: [
                    'Desarrollado',
                    'Faltante',
                ]
            };
            var doughnutPieOptions = {
                responsive: true,
                animation: {
                    animateScale: true,
                    animateRotate: true
                }
            };


            if ($("#criterio_" + id).length) {
                var doughnutChartCanvas = $("#criterio_" + id).get(0).getContext("2d");
                var doughnutChart = new Chart(doughnutChartCanvas, {
                    type: 'doughnut',
                    data: doughnutPieData,
                    options: doughnutPieOptions
                });
            }
        }


        var doughnutPieData = {
            datasets: [{
                    data: JSON.parse($("#valoresCriterios").val()),
                    backgroundColor: JSON.parse($("#colores").val()),
                    borderColor: JSON.parse($("#bordes").val()),
                }],

            // These labels appear in the legend and in the tooltips when hovering different arcs
            labels: JSON.parse($("#nombreCriterios").val())
        };
        var doughnutPieOptions = {
            responsive: true,
            animation: {
                animateScale: true,
                animateRotate: true
            }
        };


        if ($("#pieChart").length) {
            var pieChartCanvas = $("#pieChart").get(0).getContext("2d");
            var pieChart = new Chart(pieChartCanvas, {
                type: 'pie',
                data: doughnutPieData,
                options: doughnutPieOptions
            });
        }

    });

</script>

@stop