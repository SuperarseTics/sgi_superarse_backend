<form method="POST" action="{{url('/')}}/evaluacion/ingresar-resultados">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="idIndicador" value="{{$Indicador->id}}">
    <input type="hidden" name="idCriterio" value="{{$idCriterio}}">
    <input type="hidden" name="idSubcriterio" value="{{$idSubcriterio}}">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12 form-group">
            <label>Resultado</label>
            <textarea name="resultado" class="form-control" required="required" rows="5"></textarea>
        </div>
    </div>
    <div class="row">
        <?php if ($Indicador->id != 0) { ?>
            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                <button type="submit" class="btn btn-primary">Ingresar</button>

            </div>
        <?php } ?>
    </div>
</form>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12 form-group">
        <legend>Lista de Resultados</legend>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Resultado</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($lista as $list) { ?>
                    <tr>
                        <td>{{$list->created_at}}</td>
                        <td>{{$list->resultado}}</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>