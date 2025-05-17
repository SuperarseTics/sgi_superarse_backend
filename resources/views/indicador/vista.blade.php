@extends('template')

@section('contenido')
<?php if ($permiso == 2) { ?>
    <form method="POST" action="{{url('/')}}/indicador/ingresar" id="formularioIndicador">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" id="validador" value="0">
        <div class="row">
            <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                <label>Nombre</label>
                <input type="text" name="nombre" class="form-control" required="required" value="{{$Indicador->nombre}}" onkeyup="javascript:this.value = this.value.toUpperCase();">
            </div>
            <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                <label>Criterio:</label>
                <select name="criterio" id="criterio" class="form-control" required="required">
                    <option value="">Escoja una Opción</option>
                    <?php foreach ($criterios as $cri) { ?>
                        <option valorMaximo="{{$cri->peso - $cri->peso_utilizado}}" value="{{$cri->id}}" <?php if ($cri->id == $Indicador->criterio_id) { ?>selected="selected"<?php } ?>>{{$cri->nombre}}</option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                <label>Sub Criterio:</label>
                <div id="div-subcriterio">
                    <select name="subcriterio" id="subcriterio" class="form-control" required="required">
                        <option value="">Escoja una Opción</option>
                        @if ($edit)
                            @foreach ($subcriterios as $subcri)
                                <option value="{{ $subcri->id }}" @if ($subcri->id == $Indicador->subcriterio_id) selected="selected" @endif>
                                    {{ $subcri->nombre }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
            <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                <label>Tipo Indicador:</label>
                <select name="tipoIndicador" id="tipoIndicador"  class="form-control" required="required">
                    <option value="">Escoja una Opción</option>
                    <?php foreach ($tipoIndicador as $key => $value) { ?>
                        <option value="{{$value}}" <?php if ($value == $Indicador->tipo_indicador) { ?>selected="selected"<?php } ?>>{{$value}}</option>
                    <?php } ?>
                </select>
            </div>

            <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                <label>Estado:</label>
                <div>
                    <input type="radio" name="estado" id="estado1" value="1" <?php if ($Indicador->estado == 1) { ?>checked="checked"<?php } ?>> <label for="estado1">Activo</label>
                    <input type="radio" name="estado" id="estado0" value="0" <?php if ($Indicador->estado == 0) { ?>checked="checked"<?php } ?>> <label for="estado0">Inactivo</label>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                <label>Responsable Ejecución:</label>
                <select name="responsableEjecucion"  class="form-control selectpicker" data-live-search="true" required="required">
                    <option value="">Escoja una Opción</option>
                    <?php foreach ($responsableEjecucion as $cri) { ?>
                        <option value="{{$cri->id}}" <?php if ($cri->id == $Indicador->responsable_ejecucion) { ?>selected="selected"<?php } ?>>{{$cri->nombre}}</option>
                    <?php } ?>
                </select>
            </div>

            <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                <label>Cargo Responsable Ejecución:</label>
                <select name="cargoResponsableEjecucion"  class="form-control" required="required">
                    <option value="">Escoja una Opción</option>
                    <?php foreach ($cargos as $cri) { ?>
                        <option value="{{$cri->id}}" <?php if ($cri->id == $Indicador->cargo_responsable_ejecucion) { ?>selected="selected"<?php } ?>>{{$cri->nombre}}</option>
                    <?php } ?>
                </select>
            </div>

            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                <label>Responsable Evaluación:</label>
                <select name="responsableEvaluacion"  class="form-control selectpicker" data-live-search="true" required="required">
                    <option value="">Escoja una Opción</option>
                    <?php foreach ($responsableEvaluacion as $cri) { ?>
                        <option value="{{$cri->id}}" <?php if ($cri->id == $Indicador->responsable_evaluacion) { ?>selected="selected"<?php } ?>>{{$cri->nombre}}</option>
                    <?php } ?>
                </select>
            </div>

            <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                <label>Cargo Responsable Evaluación:</label>
                <select name="cargoResponsableEvaluacion"  class="form-control" required="required">
                    <option value="">Escoja una Opción</option>
                    <?php foreach ($cargos as $cri) { ?>
                        <option value="{{$cri->id}}" <?php if ($cri->id == $Indicador->cargo_responsable_evaluacion) { ?>selected="selected"<?php } ?>>{{$cri->nombre}}</option>
                    <?php } ?>
                </select>
            </div>

        </div>

        <div class="row">
            <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                <label>Peso:</label>
                <input typ="text" name="peso" id="peso" class="form-control" required="required" value="{{$Indicador->peso}}">
            </div>

            <div class="col-md-8 col-sm-12 col-xs-12 form-group">
                <label>Fórmula: (Las variables debe colocarlas con el signo $ antes del nombre)</label>
                <input typ="text" name="formula" class="form-control" id="formula" value="{{$Indicador->formula}}" placeholder="Ej: ($a+$b)/$c">
            </div>

            <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                <label>Valor Estandar:</label>
                <input typ="text" name="valorEstandar" id="valorEstandar" class="form-control"  value="{{$Indicador->valor_estandar}}" placeholder="100">
            </div>

        </div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                <label>Estandar</label>
                <textarea name="descripcion" class="form-control" required="required" rows="5" onkeyup="javascript:this.value = this.value.toUpperCase();">{{$Indicador->descripcion}}</textarea>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                <input type='hidden' name="idIndicador" value="{{$Indicador->id}}">
                <button type="submit" class="btn btn-primary"><?php if ($Indicador->id == 0) { ?>Ingresar<?php } else { ?>Actualizar<?php } ?></button>
                <?php if ($Indicador->id != 0) { ?>
                    <a href="{{url('/')}}/indicador" class="btn btn-danger">Cancelar</a>
                <?php } ?>

            </div>
        </div>

    </form>
<?php } ?>

<div class="row">
    <div class="col-md-12 form-group">
        <legend><small>Lista de Indicadores</small></legend>
        <div class="table-responsive">
            <table class="table table-striped dataTable">
                <thead>
                    <tr>
                        <?php if ($permiso == 2) { ?>
                            <th></th>
                        <?php } ?>
                        <th></th>
                        <th>NOMBRE</th>
                        <th>CRITERIO</th>
                        <th>SUBCRITERIO</th>
                        <th>TIPO INDICADOR</th>
                        <th>PESO</th>
                        <th>VALOR ESTANDAR</th>
                        <th>RESPONSABLE EJECUCION</th>
                        <th>CARGO RESPONSABLE EJECUCION</th>
                        <th>RESPONSABLE EVALUACION</th>
                        <th>CARGO RESPONSABLE EVALUACION</th>
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
                                    <a href="{{url('/')}}/indicador/editar/{{$list->id}}" class="btn btn-info">Editar</a>
                                </td>
                            <?php } ?>

                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Acciones <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu">

                                        <li><a href="{{url('/')}}/indicador/gestor-documental/{{$list->id}}">Gestor Documental</a></li>
                                        <li><a href="{{url('/')}}/indicador/evaluar/{{$list->id}}" >Evaluar</a></li>

                                    </ul>
                                </div>
                            </td>

                            <td>{{$list->nombre}}</td>
                            <td>{{$list->criterio->nombre}}</td>
                            <td>{{$list->subCriterio->nombre}}</td>
                            <td>{{$list->tipo_indicador}}</td>
                            <td>{{$list->peso}}%</td>
                            <td>{{$list->valor_estandar}}</td>
                            <td>{{$list->responsableEjecucion->nombre}}</td>
                            <td>{{$list->cargoResponsableEjecucion->nombre}}</td>
                            <td>{{$list->responsableEvaluacion->nombre}}</td>
                            <td>{{$list->cargoResponsableEvaluacion->nombre}}</td>
                            <td>{{$estado}}</td>
                        </tr>
                    <?php } ?>

                </tbody>
            </table>
        </div>
    </div>
</div>


@stop


@section('script')
<script>

    $(document).ready(function () {
        var edit = {{ $edit ? 'true' : 'false' }};

        $("#criterio").change(function () {
            if (!edit) {
                $("#div-loader").show();
                $.ajax({
                    type: 'GET',
                    dataType: 'html',
                    url: "https://sgi.superarse.edu.ec/criterio/subcriterions",
                    data: {
                        criterion: $("#criterio").val()
                    },
                    success: function (response) {
                        $("#subcriterio").html(response);
                        $("#div-loader").hide();
                    }
                });
            }
        });

        $("#tipoIndicador").change(function () {
            var valor = $("#tipoIndicador").val();
            if (valor == "Cuantitativo") {
                $("#formula").attr("required", "required");
                $("#valorEstandar").attr("required", "required");
            } else {
                $("#formula").removeAttr("required");
                $("#valorEstandar").removeAttr("required");
            }
        });

        $("#formularioIndicador").submit(function (e) {
            if ($("#validador").val() == 0) {
                e.preventDefault();
                // var valorMaximo = $("#criterio option:selected").attr('valorMaximo') * 1;
                var peso = $("#peso").val() * 1;
                // if (peso <= valorMaximo) {
                var maxValue = 6;
                if (peso <= maxValue) {
                    $("#validador").val(1);
                    $("#formularioIndicador").submit();
                } else {
                    $("#peso").addClass("input-error");
                    swal({
                        title: "Error",
                        text: "El peso de este indicador no puede superar " + maxValue,
                        type: "warning"
                    });


                }
            }



        });


    });

</script>

@stop
