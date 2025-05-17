<table class="table table-striped dataTable">
    <thead>
        <tr>
            <th></th>
            <th>NOMBRE</th>
            <th>TIPO DOCUMENTO</th>
            <th>VERSION</th>
            <th>CICLO DEMING</th>
            <th>RESOLUCION OCS</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($lista as $list) {
            if ($list->url_externa == 0) {
                $url = url('/') . "/documentos/" . $list->path;
            } else {
                $url = $list->path;
            }
            ?>
            <tr>
                <td>
                    <a href="{{$url}}" class="btn btn-primary btn-sm" target="_blank">Visualizar</a>
                </td>
                <td>{{$list->nombre}}</td>
                <td>{{$list->tipoDocumento->nombre}}</td>
                <td>{{$list->version}}</td>
                <td>{{$list->ciclo->nombre}}</td>
                <td>{{$list->resolucion_ocs}}</td>
            </tr>
        <?php } ?>
    </tbody>

</table>