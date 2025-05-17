@extends('template')

@section('contenido')

<form method="POST" action="{{ route('academic-periods.update', $academicPeriod['id']) }}" onsubmit="return validateForm()">
    @csrf
    @method('POST')
    <div class="row">
        <div class="col-md-2 col-sm-3 col-xs-3 form-group">
            <label>Tipo:</label>
            <select name="type" class="form-control" required>
                <option value="PAO" {{ $academicPeriod['type'] == 'PAO' ? 'selected' : '' }}>PAO</option>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-md-2 col-sm-3 col-xs-3 form-group">
            <label>Mes Inicio:</label>
            <select name="startMonth" class="form-control" required>
                <option value="1" {{ $academicPeriod['start_month'] == 1 ? 'selected' : '' }}>ENERO</option>
                <option value="2" {{ $academicPeriod['start_month'] == 2 ? 'selected' : '' }}>FEBRERO</option>
                <option value="3" {{ $academicPeriod['start_month'] == 3 ? 'selected' : '' }}>MARZO</option>
                <option value="4" {{ $academicPeriod['start_month'] == 4 ? 'selected' : '' }}>ABRIL</option>
                <option value="5" {{ $academicPeriod['start_month'] == 5 ? 'selected' : '' }}>MAYO</option>
                <option value="6" {{ $academicPeriod['start_month'] == 6 ? 'selected' : '' }}>JUNIO</option>
                <option value="7" {{ $academicPeriod['start_month'] == 7 ? 'selected' : '' }}>JULIO</option>
                <option value="8" {{ $academicPeriod['start_month'] == 8 ? 'selected' : '' }}>AGOSTO</option>
                <option value="9" {{ $academicPeriod['start_month'] == 9 ? 'selected' : '' }}>SEPTIEMBRE</option>
                <option value="10" {{ $academicPeriod['start_month'] == 10 ? 'selected' : '' }}>OCTUBRE</option>
                <option value="11" {{ $academicPeriod['start_month'] == 11 ? 'selected' : '' }}>NOVIEMBRE</option>
                <option value="12" {{ $academicPeriod['start_month'] == 12 ? 'selected' : '' }}>DICIEMBRE</option>
            </select>
        </div>
        <div class="col-md-2 col-sm-3 col-xs-3 form-group">
            <label>Año Inicio:</label>
            <input type="number" name="startYear" class="form-control" value="{{ $academicPeriod['start_year'] }}" required min="2000" max="2100">
        </div>
    </div>
    <div class="row">
        <div class="col-md-2 col-sm-3 col-xs-3 form-group">
            <label>Mes Fin:</label>
            <select name="endMonth" class="form-control" required>
                <option value="1" {{ $academicPeriod['end_month'] == 1 ? 'selected' : '' }}>ENERO</option>
                <option value="2" {{ $academicPeriod['end_month'] == 2 ? 'selected' : '' }}>FEBRERO</option>
                <option value="3" {{ $academicPeriod['end_month'] == 3 ? 'selected' : '' }}>MARZO</option>
                <option value="4" {{ $academicPeriod['end_month'] == 4 ? 'selected' : '' }}>ABRIL</option>
                <option value="5" {{ $academicPeriod['end_month'] == 5 ? 'selected' : '' }}>MAYO</option>
                <option value="6" {{ $academicPeriod['end_month'] == 6 ? 'selected' : '' }}>JUNIO</option>
                <option value="7" {{ $academicPeriod['end_month'] == 7 ? 'selected' : '' }}>JULIO</option>
                <option value="8" {{ $academicPeriod['end_month'] == 8 ? 'selected' : '' }}>AGOSTO</option>
                <option value="9" {{ $academicPeriod['end_month'] == 9 ? 'selected' : '' }}>SEPTIEMBRE</option>
                <option value="10" {{ $academicPeriod['end_month'] == 10 ? 'selected' : '' }}>OCTUBRE</option>
                <option value="11" {{ $academicPeriod['end_month'] == 11 ? 'selected' : '' }}>NOVIEMBRE</option>
                <option value="12" {{ $academicPeriod['end_month'] == 12 ? 'selected' : '' }}>DICIEMBRE</option>
            </select>
        </div>
        <div class="col-md-2 col-sm-3 col-xs-3 form-group">
            <label>Año Fin:</label>
            <input type="number" name="endYear" class="form-control" value="{{ $academicPeriod['end_year'] }}" required min="2000" max="2100">
        </div>
    </div>
    <div class="row">
        <div class="col-md-2 col-sm-3 col-xs-3 form-group">
            <label>Estado:</label>
            <select name="enabled" class="form-control" required>
                <option value="0" {{ $academicPeriod['enabled'] == 0 ? 'selected' : '' }}>INACTIVO</option>
                <option value="1" {{ $academicPeriod['enabled'] == 1 ? 'selected' : '' }}>ACTIVO</option>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-md-2 col-sm-3 col-xs-3 form-group">
            <button type="submit" class="btn btn-primary">Actualizar</button>
        </div>
    </div>
</form>
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

        if (endYear === startYear && (end_month <= start_month || end_month == start_month)) {
            alert('El mes final no puede ser menor o igual al mes inicial en el mismo año.');
            return false;
        }

        return true;
    }
</script>
