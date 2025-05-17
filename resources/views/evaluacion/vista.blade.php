@extends('template')

@section('contenido')

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12 form-group">
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <td><strong>Criterio:</strong><br>{{$Criterio->nombre}}</td>
                    <td><strong>Valor:</strong><h3 class="text-danger">{{$Criterio->valor}}%</h3></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12 form-group">
        <div class="form-group">
            <ul class="nav nav-tabs" role="tablist">
                <?php foreach ($subcriterios as $sub) { ?>
                    <li <?php if ($sub->id == $idSubcriterio) { ?>class="active"<?php } ?>><a href="{{url('/')}}/evaluacion/{{$Criterio->id}}?sub={{$sub->id}}">{{$sub->nombre}}</a></li>
                <?php } ?>
            </ul>
        </div>
        <div class="form-group">

        </div>

        <div class="tab-content">
            <div class="form-group margin-left">
                <ul class="nav nav-tabs width-200" role="tablist">
                    <?php foreach ($indicadores as $sub) { ?>
                        <li  class="text-center <?php if ($sub->id == $idIndicador) { ?>active<?php } ?>"><a href="{{url('/')}}/evaluacion/{{$Criterio->id}}?sub={{$sub->subcriterio_id}}&indicador={{$sub->id}}">{{$sub->nombre}}</a></li>
                    <?php } ?>
                </ul>
            </div>



<?php if(isset($Indicador->subCriterio->criterio->nombre)){?>
            <div class="margin-left form-group">
                
				<table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td><strong>Criterio:</strong><br>{{$Indicador->subCriterio->criterio->nombre}}</td>
                            <td><strong>SubCriterio:</strong><br>{{$Indicador->subCriterio->nombre}}</td>
                            <td><strong>Indicador:</strong><br>{{$Indicador->nombre}}</td>
                            <td><strong>Tipo Indicador:</strong><br>{{$Indicador->tipo_indicador}}</td>
                            <td><strong>Valor Estandar:</strong>{{$Indicador->valor_estandar}}</td>
                        </tr>
                        <tr>
                            <td><strong>Responsable Ejecución:</strong><br>{{$Indicador->responsableEjecucion->nombre}}</td>
                            <td><strong>Cargo Responsable Ejecución:</strong><br>{{$Indicador->cargoResponsableEjecucion->nombre}}</td>
                            <td><strong>Responsable Evaluación:</strong><br>{{$Indicador->responsableEvaluacion->nombre}}</td>
                            <td><strong>Cargo Responsable Ejecución:</strong><br>{{$Indicador->cargoResponsableEvaluacion->nombre}}</td>
                            <td><strong>Valor Ponderado:</strong><h3 class="text-danger">{{$Indicador->valor}}%</h3></td>
                        </tr>
                    </tbody>
                </table>

            </div>

            <div class="margin-left2">
                <div class="form-group">
                    <ul class="nav nav-tabs" role="tablist">
                        <li <?php if ($tab == "autoevaluacion") { ?>class="active"<?php } ?>><a href="{{url('/')}}/evaluacion/{{$Criterio->id}}?sub={{$idSubcriterio}}&indicador={{$idIndicador}}&tab=autoevaluacion">Autoevaluación</a></li>
                        <li <?php if ($tab == "documentos") { ?>class="active"<?php } ?>><a href="{{url('/')}}/evaluacion/{{$Criterio->id}}?sub={{$idSubcriterio}}&indicador={{$idIndicador}}&tab=documentos">Documentos</a></li>
                        <!-- <li <?php if ($tab == "evidencias") { ?>class="active"<?php } ?>><a href="{{url('/')}}/evidencias/{{$Criterio->id}}?sub={{$idSubcriterio}}&indicador={{$idIndicador}}&tab=evidencias">Evidencias</a></li> -->
                        <li <?php if ($tab == "resultados") { ?>class="active"<?php } ?>><a href="{{url('/')}}/evaluacion/{{$Criterio->id}}?sub={{$idSubcriterio}}&indicador={{$idIndicador}}&tab=resultados">Resultados</a></li>
                        <li <?php if ($tab == "acciones-correctivas") { ?>class="active"<?php } ?>><a href="{{url('/')}}/evaluacion/{{$Criterio->id}}?sub={{$idSubcriterio}}&indicador={{$idIndicador}}&tab=acciones-correctivas">Acciones Correctivas</a></li>
                        <li <?php if ($tab == "acciones-preventivas") { ?>class="active"<?php } ?>><a href="{{url('/')}}/evaluacion/{{$Criterio->id}}?sub={{$idSubcriterio}}&indicador={{$idIndicador}}&tab=acciones-preventivas">Acciones Preventivas</a></li>
                        <li <?php if ($tab == "evaluar") { ?>class="active"<?php } ?>><a href="{{url('/')}}/evaluacion/{{$Criterio->id}}?sub={{$idSubcriterio}}&indicador={{$idIndicador}}&tab=evaluar">Evaluación</a></li>
                        
                    </ul>
                </div>
                <div class="tab">
                    <?php echo $contenido; ?>
                </div>

            </div>
<?php }?>

        </div>

    </div>
</div>

@stop