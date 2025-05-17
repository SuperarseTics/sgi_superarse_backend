<nav class="navbar navbar-default">
    <ul class="nav navbar-nav">
        <?php if ($_SESSION['rolCalidad'] != "Evaluador") { ?>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Configuración <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="{{url('/')}}/rol">Roles</a></li>
                    <li><a href="{{url('/')}}/usuario">Usuarios</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Tablas Maestras <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="{{url('/')}}/etapa">Etapas de Cliclo Deming</a></li>
                    <li><a href="{{url('/')}}/cargo">Cargo</a></li>
                    <li><a href="{{url('/')}}/academic-periods">Periodos Académicos</a></li>
                    <li><a href="{{url('/')}}/tipo-documento">Tipo Documento</a></li>
                    <li><a href="{{url('/')}}/valoracion">Valoración</a></li>
                    <li><a href="{{url('/')}}/responsable">Responsable</a></li>
                    <li><a href="{{url('/')}}/evaluador">Evaluador</a></li>
                </ul>
            </li>

            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Criterios <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="{{url('/')}}/criterio">Criterio</a></li>
                    <li><a href="{{url('/')}}/subcriterio">Sub Criterio</a></li>
                    <li><a href="{{url('/')}}/indicador">Indicador</a></li>
                </ul>
            </li>
        <?php } ?>
        <li>
            <a href="{{url('/')}}/buscador-documental">Buscador Documental</a>
        </li>

    </ul>
</nav>
