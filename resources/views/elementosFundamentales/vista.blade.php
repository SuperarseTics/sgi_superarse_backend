@extends('template')

@section('contenido')
<?php if ($permiso == 2) { ?>
    <form method="POST" action="{{url('/')}}/elementos-fundamentales/ingresar">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="row">
            <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                <label>Nombre:</label>
                <input type="text" id="nombre" name="nombre" class="form-control" placeholder="NOMBRE" required="required" value="{{$ElementosFundamentales->nombre}}" onkeyup="javascript:this.value = this.value.toUpperCase();">
            </div>
            <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                <label>Calisificación:</label>
                <select name="clasificacion" class="form-control" required="required">
                    <option value="">Escoja una Opción</option>
                    <option value="ESCENCIAL" <?php if ($ElementosFundamentales->clasificacion == "ESCENCIAL") { ?>selected="selected"<?php } ?>>ESCENCIAL</option>
                    <option value="COMPLEMENTARIO" <?php if ($ElementosFundamentales->clasificacion == "COMPLEMENTARIO") { ?>selected="selected"<?php } ?>>COMPLEMENTARIO</option>
                </select>
            </div>
            <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                <label>Estado:</label>
                <div>
                    <input type="radio" name="estado" id="estado1" value="1" <?php if ($ElementosFundamentales->estado == 1) { ?>checked="checked"<?php } ?>> <label for="estado1">Activo</label>
                    <input type="radio" name="estado" id="estado0" value="0" <?php if ($ElementosFundamentales->estado == 0) { ?>checked="checked"<?php } ?>> <label for="estado0">Inactivo</label>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                <label>Descripción del elemento fundamental:</label>
                <textarea class="form-control" rows="5" required="required" name="descripcionElemento" placeholder="Descripción del Elemento Fundamental"></textarea>
            </div>

            <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                <label>Descripción de la Evidencia :</label>
                <textarea class="form-control" rows="5" required="required" name="descripcionEvidencia" placeholder="Descripción de la Evidencia"></textarea>
            </div>
        </div>

        <div class="row">
            <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                <input type='hidden' name="idCriterio" value="{{$ElementosFundamentales->id}}">
                <button type="submit" class="btn btn-primary"><?php if ($ElementosFundamentales->id == 0) { ?>Ingresar<?php } else { ?>Actualizar<?php } ?></button>
                <?php if ($ElementosFundamentales->id != 0) { ?>
                    <a href="{{url('/')}}/elementos-fundamentales" class="btn btn-danger">Cancelar</a>
                <?php } ?>    

            </div>
        </div>
    </form>
<?php } ?>
<div class="row">
    <div class="col-md-12 form-group">
        <legend><small>Lista de Elementos Fundamentales</small></legend>
        <table class="table table-striped dataTable">
            <thead>
                <tr>
                    <?php if ($permiso == 2) { ?>
                        <th></th>
                    <?php } ?>
                    <th>NOMBRE</th>
                    <th>DESCRIPCION ELEMENTO</th>
                    <th>DESCRIPCION EVIDENCIA</th>
                    <th>ESTADO</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($lista as $list) {
                    $estado = "Activo";
                    if ($list->estado == 0) {
                        $estado = "Inactivo";
                    }
                    ?>
                    <tr>
                        <?php if ($permiso == 2) { ?>
                            <td>
                                <a href="{{url('/')}}/elementos-fundamentales/editar/{{$list->id}}" class="btn btn-info btn-sm">Editar</a>
                            </td>
                        <?php } ?>
                        <td>{{$list->nombre}}</td>
                        <td>{{$list->descripcion_elemento}}</td>
                        <td>{{$list->descripcion_evidencia}}</td>
                        <td>{{$estado}}</td>
                    </tr>       
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

@stop

