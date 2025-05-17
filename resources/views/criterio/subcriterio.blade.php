<select name="subcriterio" id='subcriterio'  class="form-control" required="required">
    <?php if ($todos == 1) { ?>
        <option value="-1">Todos</option>
    <?php } else { ?>
        <option value="">Escoja una Opción</option>
    <?php } ?>

    <?php foreach ($subcriterios as $cri) { ?>
        <option value="{{$cri->id}}">{{$cri->nombre}}</option>
    <?php } ?>
</select>