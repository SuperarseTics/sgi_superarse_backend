<form method="POST" action="{{url('/')}}/evaluacion/ingresar-acciones-preventivas">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="idIndicador" value="{{$Indicador->id}}">
    <input type="hidden" name="idCriterio" value="{{$idCriterio}}">
    <input type="hidden" name="idSubcriterio" value="{{$idSubcriterio}}">
    <input type="hidden" name="idAcciones" value="{{$Acciones->id}}">
    <div class="row">
        <div class="col-md-4 col-sm-12 col-xs-12 form-group">
            <label>Nombre</label>
            <input type="text" name="nombre" class="form-control" required="required" value="{{$Acciones->nombre}}">
        </div>
        <div class="col-md-2 col-sm-12 col-xs-12 form-group">
            <label>Estado</label>
            <div>
                <input type="radio" name="estado" value="1" <?php if ($Acciones->estado == 1) { ?>checked="checked"<?php } ?> id="estado1"> <label for="estado1">Abierto</label>
                <input type="radio" name="estado" value="0" <?php if ($Acciones->estado == 0) { ?>checked="checked"<?php } ?>  id="estado0"> <label for="estado0">Cerrado</label>
            </div>
        </div>
        <?php if ($Indicador->id != 0) { ?>
            <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                <label>&nbsp;</label>
                <div>
                    <button type="submit" class="btn btn-primary"><?php if ($Acciones->id == 0) { ?>Ingresar<?php } else { ?>Actualizar<?php } ?></button>
                </div>
            </div>
        <?php } ?>
    </div>
    <div class="row">

        <div class="col-md-12 col-sm-12 col-xs-12 form-group">
            <label>Descripción</label>
            <textarea name="descripcion" class="form-control" rows="5">{{$Acciones->descripcion}}</textarea>
        </div>


    </div>
</form>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12 form-group">
        <legend>Lista de Acciones Preventivas</legend>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th></th>
                    <th>Fecha</th>
                    <th>Estado</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($lista as $list) {
                    $estado = "Abierto";
                    if ($list->estado == 0) {
                        $estado = "Cerrado";
                    }
                    ?>
                    <tr>
                        <td>
                            <a href="{{url('/')}}/evaluacion/acciones-preventivas/editar/{{$idCriterio}}?sub={{$idSubcriterio}}&indicador={{$Indicador->id}}&tab=acciones-preventivas&idAccion={{$list->id}}" class="btn btn-primary btn-sm">Editar</a>
                        </td>
                        <td>{{$list->created_at}}</td>
                        <td>{{$estado}}</td>
                        <td>{{$list->nombre}}</td>
                        <td>{{$list->descripcion}}</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>