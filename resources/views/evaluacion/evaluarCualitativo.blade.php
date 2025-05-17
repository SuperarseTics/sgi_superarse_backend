<form method="POST" action="{{url('/')}}/evaluacion/ingresar-evaluar">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="idIndicador" value="{{$Indicador->id}}">
    <input type="hidden" name="idCriterio" value="{{$Indicador->criterio_id}}">
    <input type="hidden" name="idSubcriterio" value="{{$Indicador->subcriterio_id}}">
    <div class="row">
        <div class="col-md-4 col-sm-4 col-xs-4 form-group">
            <label>Estandar</label>
            <textarea disabled class="form-control">{{ $Indicador->descripcion }}</textarea>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3 col-sm-12 col-xs-12 form-group">
            <label>Valoraci¨®n</label>
            <select name="valoracion" class="form-control" required="required">
                <option value="">Escoja una Opci¨®n</option>
                <?php foreach ($valoraciones as $val) { ?>
                    <option value="{{$val->id}}" <?php if ($val->id == $Indicador->formula) { ?>selected="selected"<?php } ?>>{{$val->nombre}} {{$val->porcentaje}}%</option>
                <?php } ?>
            </select>
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
