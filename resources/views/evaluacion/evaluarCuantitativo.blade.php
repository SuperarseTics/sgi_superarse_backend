<form method="POST" action="{{url('/')}}/indicador/ingresar-evaluacion" id="formulario">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="idIndicador" value="{{$Indicador->id}}">
    <input type="hidden" name="idCriterio" value="{{$Indicador->criterio_id}}">
    <input type="hidden" name="idSubcriterio" value="{{$Indicador->subcriterio_id}}">
    <div class="row">
        <div class="col-md-4 col-sm-4 col-xs-4 form-group">
            <label>Estandar</label>
            <textarea disabled class="form-control">{{ $Indicador->descripcion }}</textarea>
        </div>
    </div>
    <div class="row">
        <div class="col-md-9 col-sm-12 col-xs-12 form-group">
            <h2>{{$formula}}</h2>
        </div>
        <?php if ($Indicador->id != 0) { ?>
            <div class="col-md-3 col-sm-12 col-xs-12 form-group text-right">
                <label>&nbsp;</label>
                <div>
                    <button type="button" id="calcularCuantitativo" class="btn btn-info">Calcular</button>
                    <button type="submit" class="btn btn-primary">Actualizar</button>

                </div>
            </div>
        <?php } ?>
    </div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12 form-group">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Variable</th>
                        <th>Valor</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($variables as $key => $value) {
                        $nombreVariable = str_replace("$", "", $key);
                        ?>
                        <tr>
                            <td><strong>{{$key}}</strong></td>
                            <td>
                                <input type="text" name="variable[{{$key}}]" class="form-control" required="required" value="{{$value}}">
                            </td>
                        </tr>
                    <?php } ?>

                </tbody>
                <tfoot>
                    <tr>
                        <th class="text-right">Resultado</th>
                        <th id="resultado">{{$resultado}}</th>
                    </tr>
                    <tr>
                        <th class="text-right">Valor Estandar</th>
                        <th>{{$Indicador->valor_estandar}}</th>
                    </tr>
                    <tr>
                        <th class="text-right">Valoraci¨®n Ponderada</th>
                        <th id="ponderado">{{$Indicador->valor}}%</th>
                    </tr>

                </tfoot>
            </table>
        </div                            >
    </div>



    <div class="row">

    </div>
</form>

