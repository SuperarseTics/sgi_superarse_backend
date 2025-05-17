@extends('template')

@section('contenido')

<form method="GET">
    <div class="row">
        <div class="col-md-2 col-sm-12 col-xs-12 form-group">
            <label>Criterio</label>
            <select name="criterio" id="criterio" class="form-control">
                <option value="-1">Todos</option>
                <?php foreach ($criterios as $cri) { ?>
                    <option value="{{$cri->id}}" <?php if ($cri->id == $idCriterio) { ?>selected="selected"<?php } ?>>{{$cri->nombre}}</option>
                <?php } ?>
            </select>
        </div>
        <div class="col-md-3 col-sm-12 col-xs-12 form-group">
            <label>Sub Criterio</label>
            <div id="div-subcriterio">
                <select name="subcriterio" id="subcriterio" class="form-control">
                    <option value="-1">Todos</option>
                    <?php foreach ($subcriterios as $cri) { ?>
                        <option value="{{$cri->id}}" <?php if ($cri->id == $idSubCriterio) { ?>selected="selected"<?php } ?>>{{$cri->nombre}}</option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="col-md-3 col-sm-12 col-xs-12 form-group">
            <label>Indicador</label>
            <div id="div-indicador">
                <select name="indicador" id="indicador" class="form-control">
                    <option value="-1">Todos</option>
                    <?php foreach ($indicadores as $cri) { ?>
                        <option value="{{$cri->id}}" <?php if ($cri->id == $idIndicador) { ?>selected="selected"<?php } ?>>{{$cri->nombre}}</option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="col-md-2 col-sm-12 col-xs-12 form-group">
            <label>Tipo Documento</label>
            <select name="tipoDocumento" class="form-control">
                <option value="-1">Todos</option>
                <?php foreach ($tipoDocumentos as $cri) { ?>
                    <option value="{{$cri->id}}" <?php if ($cri->id == $idTipoDocumento) { ?>selected="selected"<?php } ?>>{{$cri->nombre}}</option>
                <?php } ?>
            </select>

        </div>
        <div class="col-md-2 col-sm-12 col-xs-12 form-group">
            <label>Etapa Ciclo Deming</label>
            <select name="etapaCiclo"  class="form-control">
                <option value="-1">Todos</option>
                <?php foreach ($etapaCiclo as $cri) { ?>
                    <option value="{{$cri->id}}" <?php if ($cri->id == $idEtapa) { ?>selected="selected"<?php } ?>>{{$cri->nombre}}</option>
                <?php } ?>
            </select>
        </div>

    </div>
    <div class="row">
        <div class="col-md-2 col-sm-12 col-xs-12 form-group">
            <label>Fecha Desde</label>
            <input type="date" name="desde" class="form-control" required="required" value="{{$desde}}">
        </div>
        <div class="col-md-2 col-sm-12 col-xs-12 form-group">
            <label>Fecha Hasta</label>
            <input type="date" name="hasta" class="form-control" required="required" value="{{$hasta}}">
        </div>


        <div class="col-md-2 col-sm-12 col-xs-12 form-group">
            <label>&nbsp;</label>
            <div>
                <button type="submit" class="btn btn-primary">Buscar</button>
            </div>
        </div>
    </div>
</form>


<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12 form-group">
        <legend>Lista de Documentos</legend>
        <table class="table table-striped dataTable" >
            <thead>
                <tr>
                    <th></th>
                    <th>Criterio</th>
                    <th>SubCriterio</th>
                    <th>Indicador</th>
                    <th>Nombre Documento</th>
                    <th>Tipo Documento</th>
                    <th>Versi��n</th>
                    <th>Fecha</th>
                    <th>Etapa Ciclo Deming</th>
                    <th>Resoluci��n OCS</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($documentos as $doc) {
                    if ($doc->url_externa == 1) {
                        $path = $doc->path;
                    } else {
                        $path = url('/') . "/indicador/gestor-documental/" . $doc->id;
                    }
                    ?>
                    <tr>
                        <td><a href="{{$path}}" target="_blank" class="btn btn-primary btn-sm">Visualizar</a></td>
                        <td>{{$doc->criterio->nombre}}</td>
                        <td>{{$doc->subcriterio->nombre}}</td>
                        <td>{{$doc->indicador->nombre}}</td>
                        <td>{{$doc->nombre}}</td>
                        <td>{{$doc->tipoDocumento->nombre}}</td>
                        <td>{{$doc->version}}</td>
                        <td>{{$doc->fecha}}</td>
                        <td>{{$doc->ciclo->nombre}}</td>
                        <td>{{$doc->resolucion_ocs}}</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

@stop

@section('script')
<script>
    $(document).ready(function () {
        $("#criterio").change(function () {
            $("#div-loader").show();
            $.ajax({
                type: 'GET',
                dataType: 'text',
                url: "https://sgi.superarse.edu.ec/criterio/get-subcriterio?modulo=buscador",
                data: {
                    idCriterio: $("#criterio").val()
                },
                success: function (datos) {
                    $("#div-subcriterio").html(datos);
                    $("#div-loader").hide();
                    $("#subcriterio").change(function () {
                        $("#div-loader").show();
                        $.ajax({
                            type: 'GET',
                            dataType: 'text',
                            url: "https://sgi.superarse.edu.ec/subcriterio/get-indicador?modulo=buscador",
                            data: {
                                idSubCriterio: $("#subcriterio").val()
                            },
                            success: function (datos) {
                                $("#div-indicador").html(datos);
                                $("#div-loader").hide();
                            }
                        });
                    });
                }
            });
        });

        $("#subcriterio").change(function () {
            $("#div-loader").show();
            $.ajax({
                type: 'GET',
                dataType: 'text',
                url: "https://sgi.superarse.edu.ec/subcriterio/get-indicador?modulo=buscador",
                data: {
                    idSubCriterio: $("#subcriterio").val()
                },
                success: function (datos) {
                    $("#div-indicador").html(datos);
                    $("#div-loader").hide();
                }
            });
        });
    });

</script>

@stop
