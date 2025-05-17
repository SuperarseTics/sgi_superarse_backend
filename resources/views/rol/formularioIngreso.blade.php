@extends('template')

@section('contenido')
<form method="POST" action="{{url('/')}}/rol/ingresar">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="row">
        <div class="col-md-2 col-sm-12 col-xs-12 form-group">
            <label>Nombre</label>
            <input type="text" name="nombre" class="form-control" placeholder="Nombre" required="required">
        </div>
        <div class="col-md-2 col-sm-12 col-xs-12 form-group">
            <label>&nbsp;</label>
            <div>
                <button type="submit" class="btn btn-primary">Ingresar</button>
            </div>
        </div>
    </div>
    <div class="row">
        <?php foreach ($modulos as $mod) { ?>
            <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                <div class="panel panel-default">
                    <div class="panel-heading">{{$mod->nombre}}</div>
                    <div class="panel-body">
                        <?php foreach (\Config::get('parametros.permisosModulo') as $key => $value) { ?>
                            <input type="radio" name="modulo[{{$mod->id}}]" value="{{$key}}" <?php if ($key == 0) { ?>checked="checked"<?php } ?>> {{$value}}<br/>
                        <?php } ?>
                    </div>
                </div>

            </div>
        <?php } ?>
    </div>
</form>

@stop