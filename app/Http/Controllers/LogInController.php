<?php

namespace App\Http\Controllers;

/**
 * Description of LogInController
 *
 * @author USUARIO
 */
use App\Http\Controllers\Controller;
use App\Models\ModulosModel;
use App\Models\UsuarioModel;
use App\Models\RolModel;
use App\Models\EvaluadorModel;
use App\Models\IndicadorModel;

class LogInController extends Controller {

    //put your code here

    public function index() {
        return view('login');
    }

    public function verificarLogIn() {

        if ($_POST['tipo'] == "usuario") {
            $Usuario = UsuarioModel::where('usuario', $_POST['usuario'])->where('password', md5($_POST['password']))->where('estado', 1)->first();
            if (isset($Usuario->id)) {
                if ($Usuario->estado == 1) {
                    $_SESSION['idUsuarioCalidad'] = $Usuario->id;
                    $_SESSION['usuarioCalidad'] = $Usuario->usuario;

                    if ($Usuario->rol_id == 0) {
                        $_SESSION['rolCalidad'] = "SuperAdministrador";
                        $modulos = ModulosModel::all();
                        $permisosArray = array();
                        foreach ($modulos as $mod) {
                            $permisosArray[$mod->id] = 2;
                        }
                        $_SESSION['permisosCalidad'] = $permisosArray;
                    } else {
                        $Rol = RolModel::find($Usuario->rol_id);
                        $_SESSION['rolCalidad'] = $Rol->nombre;
                        $_SESSION['permisosCalidad'] = json_decode($Usuario->rol->permisos, true);
                    }

                    $_SESSION['criterios'] = array();
                    $_SESSION['subcriterios'] = array();
                    $_SESSION['indicadores'] = array();

                    return redirect(url('/') . "/dash");
                } else {
                    return redirect(url('/') . "?mensaje=" . base64_encode("Usuario Inactivo"));
                }
            } else {
                return redirect(url('/') . "?mensaje=" . base64_encode("Usuario o password Incorrectos"));
            }
        } else {

            $Usuario = EvaluadorModel::where('usuario', $_POST['usuario'])->where('password', md5($_POST['password']))->where('estado', 1)->first();
            if (isset($Usuario->id)) {
                if ($Usuario->estado == 1) {
                    $_SESSION['idUsuarioCalidad'] = $Usuario->id;
                    $_SESSION['usuarioCalidad'] = $Usuario->usuario;

                    $_SESSION['rolCalidad'] = "Evaluador";
                    $_SESSION['permisosCalidad'] = array();

                    $indicadores = IndicadorModel::where('responsable_evaluacion', $Usuario->id)->get();
                    $criterios = array();
                    $subcriterios = array();
                    $idIndicadores = array();
                    foreach ($indicadores as $ind) {
                        $criterios[] = $ind->criterio_id;
                        $subcriterios[] = $ind->subcriterio_id;
                        $idIndicadores[] = $ind->id;
                    }
                    $_SESSION['criterios'] = array_unique($criterios);
                    $_SESSION['subcriterios'] = array_unique($subcriterios);
                    $_SESSION['indicadores'] = $idIndicadores;

                    return redirect(url('/') . "/dash");
                } else {
                    return redirect(url('/') . "?mensaje=" . base64_encode("Usuario Inactivo"));
                }
            } else {
                return redirect(url('/') . "?mensaje=" . base64_encode("Usuario o password Incorrectos"));
            }
        }
    }

    public function cerrarSesion() {
        session_destroy();
        return redirect(url('/'));
    }

}
