@extends('template')

@section('contenido')

<style>
    .center-text {
        text-align: center;
    }
</style>

@if ($permiso == 2)
<form method="POST" action="{{ route('academic-periods.store') }}" onsubmit="return validateForm()">
    @csrf
    <div class="row">
        <div class="col-md-2 col-sm-3 col-xs-3 form-group">
            <label>Tipo:</label>
            <select name="type" class="form-control" required>
                <option value="PAO">PAO</option>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-md-2 col-sm-3 col-xs-3 form-group">
            <label>Mes Inicio:</label>
            <select name="startMonth" class="form-control" required>
                <option value="1" selected>ENERO</option>
                <option value="2">FEBRERO</option>
                <option value="3">MARZO</option>
                <option value="4">ABRIL</option>
                <option value="5">MAYO</option>
                <option value="6">JUNIO</option>
                <option value="7">JULIO</option>
                <option value="8">AGOSTO</option>
                <option value="9">SEPTIEMBRE</option>
                <option value="10">OCTUBRE</option>
                <option value="11">NOVIEMBRE</option>
                <option value="12">DICIEMBRE</option>
            </select>
        </div>
        <div class="col-md-2 col-sm-3 col-xs-3 form-group">
            <label>Año Inicio:</label>
            <input type="number" name="startYear" class="form-control" value="2000" required min="2000" max="2100">
        </div>
    </div>
    <div class="row">
        <div class="col-md-2 col-sm-3 col-xs-3 form-group">
            <label>Mes Fin:</label>
            <select name="endMonth" class="form-control" required>
                <option value="1">ENERO</option>
                <option value="2" selected>FEBRERO</option>
                <option value="3">MARZO</option>
                <option value="4">ABRIL</option>
                <option value="5">MAYO</option>
                <option value="6">JUNIO</option>
                <option value="7">JULIO</option>
                <option value="8">AGOSTO</option>
                <option value="9">SEPTIEMBRE</option>
                <option value="10">OCTUBRE</option>
                <option value="11">NOVIEMBRE</option>
                <option value="12">DICIEMBRE</option>
            </select>
        </div>
        <div class="col-md-2 col-sm-3 col-xs-3 form-group">
            <label>Año Fin:</label>
            <input type="number" name="endYear" class="form-control" value="2000" required min="2000" max="2100">
        </div>
    </div>
    <div class="row">
        <div class="col-md-2 col-sm-3 col-xs-3 form-group">
            <button type="submit" class="btn btn-primary">Crear</button>
        </div>
    </div>
</form>
@endif

<div class="row">
    <div class="col-md-12 form-group">
        <legend><small>Lista de Periodos Académicos</small></legend>
        <div class="table-responsive">
            <table class="table table-striped dataTable">
                <thead>
                    <tr>
                        @if ($permiso == 2)
                            <th class="center-text"></th>
                        @endif
                        <th class="center-text">NOMBRE</th>
                        <th class="center-text">ESTADO</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($periods as $period)
                        <tr>
                            @if ($permiso == 2)
                                <td class="center-text">
                                    <a href="{{ route('academic-periods.show', $period['id']) }}" class="btn btn-info btn-sm"><i class="fa fa-pencil"></i></a>
                                </td>
                            @endif
                            <td class="center-text">{{$period['name']}}</td>
                            <td class="center-text">{{$period['enabled']}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@stop

@section('script')

<script>
    function validateForm() {
        const startYear = parseInt(document.querySelector('input[name="startYear"]').value);
        const endYear = parseInt(document.querySelector('input[name="endYear"]').value);
        const startMonth = parseInt(document.querySelector('select[name="startMonth"]').value);
        const endMonth = parseInt(document.querySelector('select[name="endMonth"]').value);

        if (endYear < startYear) {
            alert('El año fin debe ser mayor o igual que el año inicial.');
            return false;
        }

        if (endYear === startYear && (endMonth <= startMonth || endMonth == startMonth)) {
            alert('El mes final no puede ser menor o igual al mes inicial en el mismo año.');
            return false;
        }

        return true;
    }
</script>
