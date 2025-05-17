<select name="indicador" id="indicador" class="form-control">
    <?php if ($todos == 1) { ?>
        <option value="-1">Todos</option>
    <?php } else { ?>
        <option value="">Escoja una Opción</option>
    <?php } ?>

    <?php foreach ($indicadores as $cri) { ?>
        <option value="{{$cri->id}}">{{$cri->nombre}}</option>
    <?php } ?>
</select>