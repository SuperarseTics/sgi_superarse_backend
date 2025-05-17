@extends('template')

@section('contenido')

<style>
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

@if ($permiso == 2)
    <form method="POST" action="{{ route('indicator.document.update', $document['id']) }}" enctype="multipart/form-data" id="formulario-gestor-documental">
        @csrf
        @method('POST')

        <div class="row">
            <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                <label>Nombre del documento:</label>
                <input class="form-control" type="text" name="documentName" value="{{ $document['nombre'] }}" onkeyup="javascript:this.value = this.value.toUpperCase();" required>
            </div>
            <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                <label>Fecha de ingreso:</label>
                <input class="form-control" type="date" name="documentDate" value="{{ $document['fecha_documento'] }}" required>
            </div>
            <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                <label>Periodo académico:</label>
                <select class="form-control input-sm selectpicker" name="academicPeriod" data-live-search="true" required>
                    <option value="">Escoja una Opción</option>
                    @foreach ($academicPeriods as $period)
                        <option value="{{$period['id']}}" {{ $document['periodo_academico_id'] == $period['id'] ? 'selected' : '' }}>{{ $period['name'] }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                <label>Tipo Documento:</label>
                <select class="form-control input-sm selectpicker" name="typeDocument" data-live-search="true" required>
                    <option value="">Escoja una Opción</option>
                    @foreach ($typeDocuments as $type)
                        <option value="{{ $type->id }}" {{ $document['tipo_documento_id'] == $type->id ? 'selected' : '' }}>{{ $type->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                <label>Etapa Ciclo Deming:</label>
                <select class="form-control input-sm selectpicker" name="cycleDeming" data-live-search="true" required>
                    <option value="">Escoja una Opción</option>
                    @foreach ($cycles as $cycle)
                        <option value="{{ $cycle->id }}" {{ $document['etapa_ciclo_deming_id'] == $cycle->id ? 'selected' : '' }}>{{ $cycle->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                <label>Versión:</label>
                <input class="form-control" type="text" name="version" value="{{ $document['version'] }}" onkeyup="javascript:this.value = this.value.toUpperCase();" required>
            </div>
            <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                <label>Resolución OCS/Acta:</label>
                <input class="form-control" type="text" name="resolution" value="{{ $document['resolucion_ocs'] }}" onkeyup="javascript:this.value = this.value.toUpperCase();" required>
            </div>
            <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                <label>Evidencia #:</label>
                <select class="form-control" name="evidency" required>
                    @for ($i = 1; $i <= 15; $i++)
                        <option value="{{ $i }}" {{ $document['evidencia'] == $i ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
                </select>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                <label>Documento Externo:</label>
                <div>
                    <input type="radio" id="radioYes" name="typeDocumentOrigin" value="1" {{ $document['url_externa'] == 1 ? 'checked' : '' }}>
                    <label>SI</label>
                    <input type="radio" id="radioNo" name="typeDocumentOrigin" value="0" {{ $document['url_externa'] == 0 ? 'checked' : '' }}>
                    <label>NO</label>
                </div>
            </div>
            <div class="col-md-3 col-sm-12 col-xs-12 form-group" id="pathContainer">
                <label>Path Externo:</label>
                <input class="form-control" type="text" id="path" name="path" value="{{ $document['path'] }}">
            </div>
            <div class="col-md-4 col-sm-12 col-xs-12 form-group" id="documentContainer">
                <label>Documento (Formato PDF máximo 20MB):</label>
                <div class="file-drop-area">
                    <span class="fake-btn">Cargar</span>
                    <span class="file-msg" id="file-name"></span>
                    <input class="file-input" id="document" name="document" type="file">
                    <div class="item-delete" id="delete"></div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                <button type="submit" class="btn btn-primary">Actualizar</button>
            </div>
        </div>
    </form>
@endif
@stop

@section('script')
<script>
    document.addEventListener('DOMContentLoaded', (event) => {
        const radioYes = document.getElementById('radioYes');
        const radioNo = document.getElementById('radioNo');
        const pathContainer = document.getElementById('pathContainer');
        const documentContainer = document.getElementById('documentContainer');
        const fileUploaded = @json($document['path_document']);
        const pathInput = document.getElementById('path');
        const fileInput = document.getElementById('document');
        const fileName = document.getElementById('file-name');
        const deleteButton = document.getElementById('delete');

        // Function to show/hide containers based on radio selection
        function visibility() {
            if (radioYes.checked) {
                pathContainer.style.display = 'block';
                documentContainer.style.display = 'none';
                pathInput.setAttribute('required', 'required');
                fileInput.removeAttribute('required');
            } else if (radioNo.checked) {
                pathContainer.style.display = 'none';
                documentContainer.style.display = 'block';
                if (!fileUploaded) {
                    pathInput.removeAttribute('required');
                    fileInput.setAttribute('required', 'required');
                }
            }
        }

        // Function to update file name display
        function updateFileName() {
            const file = fileInput.files[0];
            if (file) {
                if (file.size > 20 * 1024 * 1024) {
                    alert('El archivo no debe superar los 20 MB.');
                    if (fileUploaded) {
                        fileName.textContent = fileUploaded;
                        deleteButton.style.display = 'inline-block';
                        fileInput.value = null;
                    } else {
                        fileInput.value = null;
                        fileName.textContent = 'o arrastrar archivo';
                        deleteButton.style.display = 'none';
                    }
                } else if (file.type !== 'application/pdf') {
                    alert('Solo se permiten archivos con extensión PDF.');
                    if (fileUploaded) {
                        fileName.textContent = fileUploaded;
                        deleteButton.style.display = 'inline-block';
                        fileInput.value = null;
                    } else {
                        fileInput.value = null;
                        fileName.textContent = 'o arrastrar archivo';
                        deleteButton.style.display = 'none';
                    }
                } else {
                    fileName.textContent = file.name;
                    deleteButton.style.display = 'inline-block';
                }
            } else {
                if (fileUploaded) {
                    fileName.textContent = fileUploaded;
                    deleteButton.style.display = 'inline-block';
                } else {
                    fileName.textContent = 'o arrastrar archivo';
                    deleteButton.style.display = 'none';
                }
            }
        }

        // Function to delete file name display and remove file
        function deleteFile() {
            fileName.textContent = 'o arrastrar archivo';
            fileInput.value = null;
            deleteButton.style.display = 'none';
        }

        // Check initial states when the page loads
        visibility();
        updateFileName();

        // Add event listeners
        radioYes.addEventListener('change', visibility);
        radioNo.addEventListener('change', visibility);
        fileInput.addEventListener('change', updateFileName);
        deleteButton.addEventListener('click', deleteFile);
    });
</script>
@stop
