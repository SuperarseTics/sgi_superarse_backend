<?php

namespace App\Http\Controllers;

/**
 * Description of EvaluadorController
 *
 * @author USUARIO
 */
use App\Http\Controllers\Controller;
use App\Models\EvaluadorModel;
use App\Http\Clases\MailClass;

class EvaluadorController extends Controller {

    //put your code here


    private $modulo;
    private $breadcume;
    private $id;
    private $permiso;

    public function __construct() {
        $this->id = 14;
        $this->permiso = 0;

        if (!isset($_SESSION['usuarioCalidad'])) {
            \Redirect::to(url('/'))->send();
        }
        if (isset($_SESSION['permisosCalidad'][$this->id])) {
            $this->permiso = $_SESSION['permisosCalidad'][$this->id];
        }
        $this->modulo = "Administración de Evaluadores";
        $this->breadcume = array(
            array('url' => '', 'nombre' => $this->modulo)
        );
    }

    public function index() {

        $datos['modulo'] = $this->modulo;
        $datos['permiso'] = $this->permiso;
        $datos['breadcume'] = $this->breadcume;

        $Evaluador = new EvaluadorModel();
        $Evaluador->id = 0;
        $Evaluador->nombre = "";
        $Evaluador->correo = "";
        $Evaluador->usuario = "";
        $Evaluador->estado = 1;
        $datos['Evaluador'] = $Evaluador;
        $datos['lista'] = EvaluadorModel::where('id', '<>', 0)->get();

        return view('evaluador/vista', $datos);
    }

    public function ingresar() {
        try {
            $mensaje = "";
            if ($_POST['idEvaluador'] == 0) {
                $Evaluador = new EvaluadorModel();
                $Evaluador->password = md5($_POST['password']);
                $mensaje = "Evaluador Ingresado con éxito";
            } else {
                $Evaluador = EvaluadorModel::find($_POST['idEvaluador']);
                if ($_POST['password'] != "**--**") {
                    $Evaluador->password = md5($_POST['password']);
                }
                $mensaje = "Evaluador Actualizado con éxito";
            }

            $Evaluador->nombre = $_POST['nombre'];
            $Evaluador->correo = $_POST['correo'];
            $Evaluador->usuario = $_POST['usuario'];
            $Evaluador->estado = $_POST['estado'];
            $Evaluador->save();
            if ($_POST['password'] != "**--**") {
                $Mail = new MailClass();
                $Mail->enviarCorreoEvaluador($Evaluador->id, $_POST['password']);
            }

            return redirect(url('/') . "/evaluador")->with('success', $mensaje);
        } catch (\Exception $e) {
            return redirect(url('/') . "/evaluador")->with('error', $e->getMessage());
        }
    }

    public function editar($id) {

        $datos['modulo'] = $this->modulo;
        $datos['permiso'] = $this->permiso;
        $datos['breadcume'] = $this->breadcume;

        $Evaluador = EvaluadorModel::find($id);
        $Evaluador->password = "**--**";
        $datos['Evaluador'] = $Evaluador;
        $datos['lista'] = EvaluadorModel::where('id', '<>', 0)->get();
        return view('evaluador/vista', $datos);
    }

}
