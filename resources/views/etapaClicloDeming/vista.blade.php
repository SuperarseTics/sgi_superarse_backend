@extends('template')

@section('contenido')
<?php if ($permiso == 2) { ?>
    <form method="POST" action="{{url('/')}}/etapa/ingresar">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="row">
            <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                <label>Nombre:</label>
                <input type="text" id="nombre" name="nombre" class="form-control" placeholder="NOMBRE" required="required" value="{{$Etapa->nombre}}" onkeyup="javascript:this.value = this.value.toUpperCase();">
            </div>
            <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                <label>Estado:</label>
                <div>
                    <input type="radio" name="estado" id="estado1" value="1" <?php if ($Etapa->estado == 1) { ?>checked="checked"<?php } ?>> <label for="estado1">Activo</label>
                    <input type="radio" name="estado" id="estado0" value="0" <?php if ($Etapa->estado == 0) { ?>checked="checked"<?php } ?>> <label for="estado0">Inactivo</label>
                </div>
            </div>
            <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                <label>&nbsp;</label>
                <div>
                    <input type='hidden' name="idEtapa" value="{{$Etapa->id}}">
                    <button type="submit" class="btn btn-primary"><?php if ($Etapa->id == 0) { ?>Ingresar<?php } else { ?>Actualizar<?php } ?></button>
                    <?php if ($Etapa->id != 0) { ?>
                        <a href="{{url('/')}}/etapa" class="btn btn-danger">Cancelar</a>
                    <?php } ?>    
                </div>
            </div>
        </div>
    </form>
<?php } ?>
<div class="row">
    <div class="col-md-12 form-group">
        <legend><small>Lista de Etapas del Cliclo Deming</small></legend>
        <table class="table table-striped dataTable">
            <thead>
                <tr>
                    <?php if ($permiso == 2) { ?>
                        <th></th>
                    <?php } ?>
                    <th>NOMBRE</th>
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
                                <a href="{{url('/')}}/etapa/editar/{{$list->id}}" class="btn btn-info btn-sm">Editar</a>
                            </td>
                        <?php } ?>
                        <td>{{$list->nombre}}</td>
                        <td>{{$estado}}</td>
                    </tr>       
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

@stop

