<form method="POST" action="{{url('/')}}/evaluacion/ingresar-autoevaluacion">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="idIndicador" value="{{$Indicador->id}}">
    <input type="hidden" name="idCriterio" value="{{$idCriterio}}">
    <input type="hidden" name="idSubcriterio" value="{{$idSubcriterio}}">
    <div class="row">
        <div class="col-md-2 col-sm-12 col-xs-12 form-group">
            <label>Fecha AutoEvaluación</label>
            <input type="date" name="fechaAutoevaluacion" class="form-control" required="required" value="{{$Indicador->fecha_autoevaluacion}}">
        </div>
        <div class="col-md-2 col-sm-12 col-xs-12 form-group">
            <label>Fecha Cumplimiento</label>
            <input type="date" name="fechaCumplimiento" class="form-control" required="required" value="{{$Indicador->fecha_cumplimiento}}">
        </div>

        <?php if ($Indicador->id != 0) { ?>
            <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                <label>&nbsp;</label>
                <div>
                    <button type="submit" class="btn btn-primary">Actualizar</button>
                </div>
            </div>
        <?php } ?>
    </div>
</form>