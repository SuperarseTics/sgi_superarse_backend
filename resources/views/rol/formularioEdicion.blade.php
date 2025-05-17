@extends('template')

@section('contenido')
<form method="POST" action="{{url('/')}}/rol/actualizar" id='formulario'>
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="row">
        <div class="col-md-2 col-sm-12 col-xs-12 form-group">
            <label>Nombre</label>
            <input type="text" name="nombre" class="form-control input-sm" value="{{$Rol->nombre}}" placeholder="Nombre" required="required">
        </div>
        <div class="col-md-2 col-sm-12 col-xs-12 form-group">
            <label>&nbsp;</label>
            <div>
                <input type="hidden" name="idRol" value="{{$Rol->id}}">
                <button type="submit" class="btn btn-primary">Actualizar</button>
                <a href="{{url('/')}}/rol" class="btn btn-danger">Cancelar</a>
            </div>
        </div>
    </div>
    <div class="row">
        <?php foreach ($modulos as $mod) { ?>
            <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                <div class="panel panel-default">
                    <div class="panel-heading">{{$mod->nombre}}</div>
                    <div class="panel-body">
                        <?php
                        foreach (\Config::get('parametros.permisosModulo') as $key => $value) {
                            if (isset($Rol->permisosModulo[$mod->id])) {
                                $idPermiso=$Rol->permisosModulo[$mod->id];
                            } else {
                                $idPermiso = 0;
                            }
                            ?>
                            <input type="radio" name="modulo[{{$mod->id}}]" value="{{$key}}" <?php if ($key == $idPermiso) { ?>checked="checked"<?php } ?>> {{$value}}<br/>
                        <?php } ?>
                    </div>
                </div>

            </div>
        <?php } ?>
    </div>
</form>

@stop