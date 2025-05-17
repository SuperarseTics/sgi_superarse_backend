@extends('template')

@section('contenido')

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12 form-group">
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <td><strong>Criterio:</strong><br>{{$Indicador->subcriterio->criterio->nombre}}</td>
                    <td><strong>SubCriterio:</strong><br>{{$Indicador->subcriterio->nombre}}</td>
                    <td><strong>Indicador:</strong><br>{{$Indicador->nombre}}</td>
                    <td><strong>Tipo Indicador:</strong><br>{{$Indicador->tipo_indicador}}</td>
                </tr>
                <tr>
                    <td><strong>Responsable Ejecución:</strong><br>{{$Indicador->responsableEjecucion->nombre}}</td>
                    <td><strong>Cargo Responsable Ejecución:</strong><br>{{$Indicador->cargoResponsableEjecucion->nombre}}</td>
                    <td><strong>Responsable Evaluación:</strong><br>{{$Indicador->responsableEvaluacion->nombre}}</td>
                    <td><strong>Cargo Responsable Ejecución:</strong><br>{{$Indicador->cargoResponsableEvaluacion->nombre}}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12 form-group">
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation"><a href="{{url('/')}}/indicador" class="btn btn-danger"><i class="fa fa-arrow-left"></i> Regresar</a></li>
            <li role="presentation"><a href="{{url('/')}}/indicador/gestor-documental/{{$Indicador->id}}">Gestor Documental</a></li>
            <li role="presentation" class="active"><a href="{{url('/')}}/indicador/evaluar/{{$Indicador->id}}">Calcular Indicadores</a></li>

        </ul>

    </div>
</div>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12 form-group">
        <?php echo $contenido; ?>
    </div>
</div>

@stop
