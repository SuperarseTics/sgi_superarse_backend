@extends('template')

@section('contenido')
<?php if ($permiso == 2) { ?>
    <form method="POST" action="{{url('/')}}/evaluador/ingresar">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="row">

            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                <label>Nombre</label>
                <input type="text" name="nombre" id="nombre" class="form-control" value="{{$Evaluador->nombre}}" required="required" >
            </div>


            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                <label>Correo</label>
                <input type="text" name="correo" id="correo"  class="form-control" value="{{$Evaluador->correo}}" required="required">
            </div>

            <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                <label>Usuario</label>
                <input type="text" name="usuario" id="usuario"   class="form-control" value="{{$Evaluador->usuario}}" required="required">
            </div>

            <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                <label>Password</label>
                <input type="password" name="password" id="password"   class="form-control" value="{{$Evaluador->password}}" required="required">
            </div>
            <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                <label>Estado:</label>
                <div>
                    <input type="radio" name="estado" value="1" <?php if ($Evaluador->estado == 1) { ?>checked="checked"<?php } ?>> Activo
                    <input type="radio" name="estado" value="0" <?php if ($Evaluador->estado == 0) { ?>checked="checked"<?php } ?>> Inactivo
                </div>
            </div>

            <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                <label>&nbsp;</label>
                <div>
                    <input type='hidden' name="idEvaluador" value="{{$Evaluador->id}}">
                    <button type="submit" class="btn btn-primary"><?php if ($Evaluador->id == 0) { ?>Ingresar<?php } else { ?>Actualizar<?php } ?></button>
                    <?php if ($Evaluador->id != 0) { ?>
                        <a href="{{url('/')}}/evaluador" class="btn btn-danger">Cancelar</a>
                    <?php } ?>        
                </div>
            </div>

        </div>
    </form>
<?php } ?>

<div class="row">
    <div class="col-md-12 form-group">
        <legend><small>Lista de Evaluadores</small></legend>
        <table class="table table-striped dataTable">
            <thead>
                <tr>
                    <?php if ($permiso == 2) { ?>
                        <th></th>
                    <?php } ?>

                    <th>USUARIO</th>
                    <th>NOMBRE</th>
                    <th>CORREO</th>
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
                                <a href="{{url('/')}}/evaluador/editar/{{$list->id}}" class="btn btn-info btn-sm">Editar</a>
                            </td>
                        <?php } ?>

                        <td>{{$list->usuario}}</td>
                        <td>{{$list->nombre}}</td>
                        <td>{{$list->correo}}</td>
                        <td>{{$estado}}</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>




@stop
