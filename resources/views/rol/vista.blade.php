@extends('template')

@section('contenido')
<div class="row">
    <?php if ($permiso == 2) { ?>
        <div class="col-md-12 form-group">
            <a href="{{url('/')}}/rol/nuevo" class="btn btn-primary">Nuevo Rol</a>
        </div>
    <?php } ?>
    <div class="col-md-12 form-group">

        <legend>Lista de Roles</legend>
        <table class="table table-striped">
            <thead>
                <tr>
                    <?php if ($permiso == 2) { ?>
                        <th></th>
                    <?php } ?>
                    <th>Nombre</th>
                    <th>Permisos</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($lista as $list) { ?>
                    <tr>
                        <?php if ($permiso == 2) { ?>
                            <td><a href="{{url('/')}}/rol/editar/{{$list->id}}" class="btn btn-info"><i class="fa fa-pencil"></i></a></td>
                                <?php } ?>
                        <td>{{$list->nombre}}</td>
                        <td>
                            <?php foreach ($list->permisosModulo as $per) { ?>
                                <strong>{{strtoupper($per['modulo'])}}: </strong>
                                {{$per['permiso']}},
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>

            </tbody>
        </table>
    </div>
</div>

@stop

