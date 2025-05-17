@extends('template')

@section('contenido')
<?php if ($permiso == 2) { ?>
    <form method="POST" action="{{url('/')}}/usuario/ingresar">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="row">

            <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                <label>Nombre:</label>
                <input type="text" id="nombre" name="nombre" class="form-control" placeholder="NOMBRE" value="{{$Usuario->nombre}}" required="required">
            </div>
            <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                <label>Usuario:</label>
                <input type="text" id="usuario" name="usuario" class="form-control" placeholder="COD" value="{{$Usuario->usuario}}" required="required">
            </div>
            <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                <label>Password:</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="COD" value="{{$Usuario->password}}" required="required">
            </div>
            <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                <label>Rol:</label>
                <select name="rol" id="rol" class="form-control" required="required">
                    <option value="">Escoja una Opción</option>
                    <?php foreach ($roles as $rol) { ?>
                        <option value="{{$rol->id}}" <?php if ($rol->id == $Usuario->rol_id) { ?>selected="selected"<?php } ?>>{{$rol->nombre}}</option>
                    <?php } ?>
                </select>  
            </div>
            <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                <label>Estado:</label>
                <div>
                    <input type="radio" name="estado" value="1" <?php if ($Usuario->estado == 1) { ?>checked="checked"<?php } ?>> Activo
                    <input type="radio" name="estado" value="0" <?php if ($Usuario->estado == 0) { ?>checked="checked"<?php } ?>> Inactivo
                </div>
            </div>
            <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                <label>&nbsp;</label>
                <div>
                    <input type='hidden' name="idUsuario" value="{{$Usuario->id}}">
                    <button type="submit"  class="btn btn-primary"><?php if ($Usuario->id == 0) { ?>Ingresar<?php } else { ?>Actualizar<?php } ?></button>
                    <?php if ($Usuario->id != 0) { ?>
                        <a href="{{url('/')}}/usuario" class="btn btn-danger">Cancelar</a>
                    <?php } ?>        </div>
            </div>
        </div>
    </form>
<?php } ?>
<div class="row">
    <div class="col-md-12 form-group">
        <legend><small>Lista de Usuarios</small></legend>
        <table class="table table-striped dataTable">
            <thead>
                <tr>
                    <?php if ($permiso == 2) { ?>
                        <th></th>
                    <?php } ?>
                    <th>USUARIO</th>
                    <th>NOMBRE</th>
                    <th>ROL</th>
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
                                <a href="{{url('/')}}/usuario/editar/{{$list->id}}" class="btn btn-info"><i class="fa fa-pencil"></i></a>
                            </td>
                        <?php } ?>
                        <td>{{$list->usuario}}</td>
                        <td>{{$list->nombre}}</td>
                        <td>{{$list->rol->nombre}}</td>
                        <td>{{$estado}}</td>
                    </tr>       
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

@stop
