@extends('template')

@section('contenido')

<style>
    .evidencia-box {
        padding: 15px;
        margin-bottom: 20px;
        border: 1px solid #ddd;
        border-radius: 5px;
        background-color: #f9f9f9;
    }

    .evidencia-title {
        margin: 0;
        font-size: 24px;
        font-weight: bold;
        color: #333;
    }

    .evidencia-table th, .evidencia-table td {
        vertical-align: middle;
    }

    .periodo-box {
        padding: 5px;
        margin-bottom: 20px;
        border: 1px solid #222222;
        border-radius: 5px;
        background-color: #919191;
    }

    .periodo-title {
        margin: 0;
        font-size: 24px;
        font-weight: bold;
        color: #333;
    }

    .file-drop-area {
        position: relative;
        display: flex;
        align-items: center;
        width: 400px;
        max-width: 100%;
        padding: 25px;
        background-color: #fff;
        border-radius: 4px;
        border: 1.5px solid #c9c9ce;
        transition: .3s;
    }

    .file-drop-area.is-active {
        background-color: #80AAB7;
    }

    .fake-btn {
        flex-shrink: 0;
        background-color: #2A4149;
        border-radius: 3px;
        padding: 8px 15px;
        margin-right: 10px;
        font-size: 12px;
        text-transform: uppercase;
        color: white;
    }

    .file-msg {
        width: 60%;
        color: black;
        font-size: 16px;
        font-weight: 300;
        line-height: 1.4;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .item-delete {
        display: none;
        position: absolute;
        right: 30px;
        width: 18px;
        height: 18px;
        cursor: pointer;
    }

    .item-delete:before {
        content: "";
        position: absolute;
        left: 0;
        transition: .3s;
        top: 0;
        z-index: 1;
        width: 100%;
        height: 100%;
        background-size: cover;
        background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg fill='%23000000' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 438.5 438.5'%3e%3cpath d='M417.7 75.7A8.9 8.9 0 00411 73H323l-20-47.7c-2.8-7-8-13-15.4-18S272.5 0 264.9 0h-91.3C166 0 158.5 2.5 151 7.4c-7.4 5-12.5 11-15.4 18l-20 47.7H27.4a9 9 0 00-6.6 2.6 9 9 0 00-2.5 6.5v18.3c0 2.7.8 4.8 2.5 6.6a8.9 8.9 0 006.6 2.5h27.4v271.8c0 15.8 4.5 29.3 13.4 40.4a40.2 40.2 0 0032.3 16.7H338c12.6 0 23.4-5.7 32.3-17.2a64.8 64.8 0 0013.4-41V109.6h27.4c2.7 0 4.9-.8 6.6-2.5a8.9 8.9 0 002.6-6.6V82.2a9 9 0 00-2.6-6.5zm-248.4-36a8 8 0 014.9-3.2h90.5a8 8 0 014.8 3.2L283.2 73H155.3l14-33.4zm177.9 340.6a32.4 32.4 0 01-6.2 19.3c-1.4 1.6-2.4 2.4-3 2.4H100.5c-.6 0-1.6-.8-3-2.4a32.5 32.5 0 01-6.1-19.3V109.6h255.8v270.7z'/%3e%3cpath d='M137 347.2h18.3c2.7 0 4.9-.9 6.6-2.6a9 9 0 002.5-6.6V173.6a9 9 0 00-2.5-6.6 8.9 8.9 0 00-6.6-2.6H137c-2.6 0-4.8.9-6.5 2.6a8.9 8.9 0 00-2.6 6.6V338c0 2.7.9 4.9 2.6 6.6a8.9 8.9 0 006.5 2.6zM210.1 347.2h18.3a8.9 8.9 0 009.1-9.1V173.5c0-2.7-.8-4.9-2.5-6.6a8.9 8.9 0 00-6.6-2.6h-18.3a8.9 8.9 0 00-9.1 9.1V338a8.9 8.9 0 009.1 9.1zM283.2 347.2h18.3c2.7 0 4.8-.9 6.6-2.6a8.9 8.9 0 002.5-6.6V173.6c0-2.7-.8-4.9-2.5-6.6a8.9 8.9 0 00-6.6-2.6h-18.3a9 9 0 00-6.6 2.6 8.9 8.9 0 00-2.5 6.6V338a9 9 0 002.5 6.6 9 9 0 006.6 2.6z'/%3e%3c/svg%3e");
    }

    .item-delete:after {
        content: "";
        position: absolute;
        opacity: 0;
        left: 50%;
        top: 50%;
        width: 100%;
        height: 100%;
        transform: translate(-50%, -50%) scale(0);
        background-color: #2A4149;
        border-radius: 50%;
        transition: .3s;
    }

    .item-delete:hover:after {
        transform: translate(-50%, -50%) scale(2.2);
        opacity: 1;
    }

    .item-delete:hover:before {
        background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg fill='%23FFFFFF' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 438.5 438.5'%3e%3cpath d='M417.7 75.7A8.9 8.9 0 00411 73H323l-20-47.7c-2.8-7-8-13-15.4-18S272.5 0 264.9 0h-91.3C166 0 158.5 2.5 151 7.4c-7.4 5-12.5 11-15.4 18l-20 47.7H27.4a9 9 0 00-6.6 2.6 9 9 0 00-2.5 6.5v18.3c0 2.7.8 4.8 2.5 6.6a8.9 8.9 0 006.6 2.5h27.4v271.8c0 15.8 4.5 29.3 13.4 40.4a40.2 40.2 0 0032.3 16.7H338c12.6 0 23.4-5.7 32.3-17.2a64.8 64.8 0 0013.4-41V109.6h27.4c2.7 0 4.9-.8 6.6-2.5a8.9 8.9 0 002.6-6.6V82.2a9 9 0 00-2.6-6.5zm-248.4-36a8 8 0 014.9-3.2h90.5a8 8 0 014.8 3.2L283.2 73H155.3l14-33.4zm177.9 340.6a32.4 32.4 0 01-6.2 19.3c-1.4 1.6-2.4 2.4-3 2.4H100.5c-.6 0-1.6-.8-3-2.4a32.5 32.5 0 01-6.1-19.3V109.6h255.8v270.7z'/%3e%3cpath d='M137 347.2h18.3c2.7 0 4.9-.9 6.6-2.6a9 9 0 002.5-6.6V173.6a9 9 0 00-2.5-6.6 8.9 8.9 0 00-6.6-2.6H137c-2.6 0-4.8.9-6.5 2.6a8.9 8.9 0 00-2.6 6.6V338c0 2.7.9 4.9 2.6 6.6a8.9 8.9 0 006.5 2.6zM210.1 347.2h18.3a8.9 8.9 0 009.1-9.1V173.5c0-2.7-.8-4.9-2.5-6.6a8.9 8.9 0 00-6.6-2.6h-18.3a8.9 8.9 0 00-9.1 9.1V338a8.9 8.9 0 009.1 9.1zM283.2 347.2h18.3c2.7 0 4.8-.9 6.6-2.6a8.9 8.9 0 002.5-6.6V173.6c0-2.7-.8-4.9-2.5-6.6a8.9 8.9 0 00-6.6-2.6h-18.3a9 9 0 00-6.6 2.6 8.9 8.9 0 00-2.5 6.6V338a9 9 0 002.5 6.6 9 9 0 006.6 2.6z'/%3e%3c/svg%3e");
    }

    .file-input {
        position: absolute;
        left: 0;
        top: 0;
        height: 100%;
        width: 100%;
        cursor: pointer;
        opacity: 0;
    }

    .file-input:focus {
        outline: none;
    }
</style>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12 form-group">
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <td><strong>Criterio:</strong><br>{{$Indicador->subcriterio->criterio->nombre}}</td>
                    <td><strong>SubCriterio:</strong><br>{{$Indicador->subcriterio->nombre}}</td>
                    <td><strong>Indicador:</strong><br>{{$Indicador->nombre}}</td>
                    <td><strong>Tipo Indicador:</strong><br>{{$Indicador->tipo_indicador}}</td>
                </tr>
                <tr>
                    <td><strong>Responsable Ejecución:</strong><br>{{$Indicador->responsableEjecucion->nombre}}</td>
                    <td><strong>Cargo Responsable Ejecución:</strong><br>{{$Indicador->cargoResponsableEjecucion->nombre}}</td>
                    <td><strong>Responsable Evaluación:</strong><br>{{$Indicador->responsableEvaluacion->nombre}}</td>
                    <td><strong>Cargo Responsable Ejecución:</strong><br>{{$Indicador->cargoResponsableEvaluacion->nombre}}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12 form-group">
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation"><a href="{{url('/')}}/indicador" class="btn btn-danger"><i class="fa fa-arrow-left"></i> Regresar</a></li>
            <li role="presentation" class="active"><a href="{{url('/')}}/indicador/gestor-documental/{{$Indicador->id}}">Gestor Documental</a></li>
            <li role="presentation"><a href="{{url('/')}}/indicador/evaluar/{{$Indicador->id}}">Calcular Indicadores</a></li>

        </ul>

    </div>
</div>

<?php if ($permiso == 2) { ?>
    <form method="POST" action="{{url('/')}}/indicador/gestor-documental/ingresar" enctype="multipart/form-data" id="formulario-gestor-documental">
        @csrf
        @method('POST')
        <input name="idCriterio" type="hidden" value="{{ $Indicador->criterio_id }}"/>
        <input name="idSubCriterio" type="hidden" value="{{ $Indicador->subcriterio_id }}" />
        <input name="idIndicador" type="hidden" value="{{ $Indicador->id }}" />
        <div class="row">
            <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                <label>Nombre del documento:</label>
                {{-- <input type="text" id="nombre" name="nombre" class="form-control" placeholder="NOMBRE" required="required" value="{{$Gestor->nombre}}" onkeyup="javascript:this.value = this.value.toUpperCase();"> --}}
                <input type="text" id="nombre" name="nombre" class="form-control" placeholder="NOMBRE" required="required" onkeyup="javascript:this.value = this.value.toUpperCase();">
            </div>
            <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                <label>Fecha de ingreso:</label>
                {{-- <input type="date" id="date_document" name="date_document" class="form-control" required="required" value="{{$Gestor->fecha_documento}}"> --}}
                <input type="date" id="date_document" name="date_document" class="form-control" required="required">
            </div>
            <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                <label>Periodo académico:</label>
                <select id="academic_period" name="academic_period" class="form-control input-sm selectpicker" data-live-search="true" required="required">
                    <option value="">Escoja una Opción</option>
                    <?php foreach ($periodosAcademicos as $periodo) { ?>
                        <option value="{{$periodo['id']}}">{{$periodo['name']}}</option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                <label>Tipo Documento:</label>
                <select name="tipoDocumento" class="form-control input-sm selectpicker" data-live-search="true" required="required">
                    <option value="">Escoja una Opción</option>
                    <?php foreach ($tipoDocumentos as $list) { ?>
                        <option value="{{$list->id}}">{{$list->nombre}}</option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                <label>Etapa Ciclo Deming:</label>
                <select name="etapaCiclo" class="form-control input-sm selectpicker" data-live-search="true" required="required">
                    <option value="">Escoja una Opción</option>
                    <?php foreach ($etapaCiclo as $list) { ?>
                        <option value="{{$list->id}}">{{$list->nombre}}</option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                <label>Versión:</label>
                {{-- <input type="text"  name="version" class="form-control" placeholder="VERSION" required="required" value="{{$Gestor->version}}" onkeyup="javascript:this.value = this.value.toUpperCase();"> --}}
                <input type="text"  name="version" class="form-control" placeholder="VERSION" required="required" onkeyup="javascript:this.value = this.value.toUpperCase();">
            </div>
            <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                <label>Resolución OCS/Acta:</label>
                {{-- <input type="text"  name="resolucion" class="form-control" placeholder="RESOLUCION OCS" required="required" value="{{$Gestor->resolucion_ocs}}" onkeyup="javascript:this.value = this.value.toUpperCase();"> --}}
                <input type="text"  name="resolucion" class="form-control" placeholder="RESOLUCION OCS" required="required" onkeyup="javascript:this.value = this.value.toUpperCase();">
            </div>
            <div class="col-md-1 col-sm-6 col-xs-6 form-group">
                <label>Evidencia #:</label>
                <select name="evidencia" id="evidencia" class="form-control" required>
                    @for ($i = 1; $i <= 15; $i++)
                        <option value="{{ $i }}">{{ $i }}</option>
                    @endfor
                </select>
            </div>
        </div>

        <div class="row">
            <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                <label>Documento Externo:</label>
                <div>
                    <input type="radio" name="urlExterno" class="documentoExterno" id="externo1" value="1" checked> <label for="externo1">SI</label>
                    <input type="radio" name="urlExterno" class="documentoExterno" id="externo0" value="0" checked> <label for="externo0">NO</label>
                </div>
            </div>
            <div class="col-md-6 col-sm-12 col-xs-12 form-group oculto" id="divPathExterno">
                <label>Path Externo:</label>
                <input type="text" name="pathExterno" id="pathExterno" class="form-control" placeholder="https://www.google.com">
            </div>
            <div class="col-md-4 col-sm-12 col-xs-12 form-group" id="divDocumento">
                <label>Documento: (Formato PDF máximo 20MB)</label>
                <div class="file-drop-area">
                    <span class="fake-btn">Cargar</span>
                    <span class="file-msg">o arrastrar archivo</span>
                    <input class="file-input" name="documento" id="documento" type="file" required="required">
                    <div class="item-delete"></div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                <button type="submit" class="btn btn-primary">Ingresar</button>
            </div>
        </div>
    </form>
<?php } ?>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12 form-group">
        <legend>Lista de Documentos</legend>
        @foreach ($lista as $evidencia => $periodGroups)
            <div class="container mb-4">
                <div class="row">
                    <div class="col-12 evidencia-box text-center">
                        <h3 class="evidencia-title">{{ is_numeric($evidencia) ? 'Evidencia # ' . $evidencia : 'Sin evidencia' }}</h3>
                         <form action="{{ route('excel.download') }}" method="POST" class="d-inline">
                            @csrf <!-- Token CSRF para seguridad -->
                            <input type="hidden" name="evidenciaZIP" value="{{ $evidencia }}">
                            <input type="hidden" name="indicadorZIP" value="{{ $Indicador->id }}">
                            <button type="submit" class="btn btn-success">
                                <i class="fa fa-download"></i> Descargar ZIP
                            </button>
                        </form>
                    </div>
                </div>
                @foreach ($periodGroups as $periodo => $documents)
                    <div class="container mb-2">
                        <div class="row">
                            <div class="col-12 periodo-box text-center">
                                <h4 class="periodo-title">{{ $periodo }}</h4>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table evidencia-table">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th><center>NOMBRE DOCUMENTO</center></th>
                                        <th><center>FECHA DOCUMENTO</center></th>
                                        <th><center>TIPO DOCUMENTO</center></th>
                                        <th><center>VERSION</center></th>
                                        <th><center>CICLO DEMING</center></th>
                                        <th><center>RESOLUCION OCS/ACTA</center></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($documents as $document)
                                        @php
                                            $url = $document['url_externa'] == 0 ? url('/') . "/documentos/" . $document['path'] : $document['path'];
                                        @endphp
                                        <tr>
                                            <td>
                                                <form action="{{ route('indicator.document.delete', $document['id']) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de que quieres eliminar este documento?');">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                            <td>
                                                <a href="{{ route('indicator.document.show', ['indicatorId' => $Indicador->id, 'documentId' => $document['id']]) }}" class="btn btn-primary">
                                                    <i class="fa fa-pencil"></i>
                                                </a>
                                            </td>
                                            <td>
                                                <a href="{{ $document['url_externa'] == 0 ? url('/documentos/'.$document['path']) : $document['path'] }}" class="btn btn-info" target="_blank"><i class="fa fa-eye"></i></a>
                                            </td>
                                            <td><center>{{ $document['nombre'] }}</center></td>
                                            <td><center>{{ $document['fecha_documento'] }}</center></td>
                                            <td><center>{{ $document['tipo_documento'] }}</center></td>
                                            <td><center>{{ $document['version'] }}</center></td>
                                            <td><center>{{ $document['ciclo'] }}</center></td>
                                            <td><center>{{ $document['resolucion_ocs'] }}</center></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
</div>

@stop

@section('script')

<script>
    $(document).ready(function () {
        $(".documentoExterno").change(function () {
            var estado = $(this).val();
            if (estado == 1) {
                $("#divPathExterno").removeClass("oculto");
                $("#divDocumento").addClass("oculto");
                $("#documento").removeAttr('required');
                $("#pathExterno").attr('required', "required");
                $("#urlExterna").val(1);

            } else {
                $("#divDocumento").removeClass("oculto");
                $("#divPathExterno").addClass("oculto");
                $("#pathExterno").removeAttr('required');
                $("#documento").attr('required', "required");
                $("#urlExterna").val(0);
            }
        });

        const $fileInput = $('.file-input');
        const $droparea = $('.file-drop-area');
        const $delete = $('.item-delete');

        $fileInput.on('dragenter focus click', function () {
            $droparea.addClass('is-active');
        });

        $fileInput.on('dragleave blur drop', function () {
            $droparea.removeClass('is-active');
        });

        $fileInput.on('change', function () {
            let filesCount = $(this)[0].files.length;
            let $textContainer = $(this).prev();
            let file = $(this)[0].files[0];
            let fileName = file ? file.name : '';
            let fileSize = file ? file.size : 0;

            if (filesCount === 1) {
                let fileExtension = fileName.split('.').pop().toLowerCase();
                if (fileExtension !== 'pdf') {
                    alert('Solo se permiten archivos con extensión PDF.');
                    $(this).val(null);
                    $textContainer.text('o arrastrar archivo');
                    $('.item-delete').css('display', 'none');
                } else if (fileSize > 20 * 1024 * 1024) {
                    alert('El archivo no debe superar los 20 MB.');
                    $(this).val(null);
                    $textContainer.text('o arrastrar archivo');
                    $('.item-delete').css('display', 'none');
                } else {
                    $textContainer.text(fileName);
                    $('.item-delete').css('display', 'inline-block');
                }
            } else if (filesCount === 0) {
                $textContainer.text('o arrastrar archivo');
                $('.item-delete').css('display', 'none');
            } else {
                $textContainer.text(filesCount + ' archivos seleccionados');
                $('.item-delete').css('display', 'inline-block');
            }

            $delete.on('click', function () {
                $('.file-input').val(null);
                $('.file-msg').text('o arrastrar archivo');
                $('.item-delete').css('display', 'none');
            });
        });
    });
</script>

@stop
