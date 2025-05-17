<?php

namespace App\Http\Controllers;

/**
 * Description of EtapaClicloDemingController
 *
 * @author USUARIO
 */
use App\Http\Controllers\Controller;
use App\Models\EtapaClicloDemingModel;

class EtapaClicloDemingController extends Controller {

    //put your code here

    private $modulo;
    private $breadcume;
    private $id;
    private $permiso;

    public function __construct() {
        $this->id = 12;
        $this->permiso = 0;

        if (!isset($_SESSION['usuarioCalidad'])) {
            \Redirect::to(url('/'))->send();
        }

        if (isset($_SESSION['permisosCalidad'][$this->id])) {
            $this->permiso = $_SESSION['permisosCalidad'][$this->id];
        }

        $this->modulo = "Etapas de Cliclo Deming";
        $this->breadcume = array(
            array('url' => '', 'nombre' => $this->modulo)
        );
    }

    public function index() {

        $datos['modulo'] = $this->modulo;
        $datos['breadcume'] = $this->breadcume;
        $datos['permiso'] = $this->permiso;
        $datos['lista'] = EtapaClicloDemingModel::all();

        $Etapa = new EtapaClicloDemingModel();
        $Etapa->id = 0;
        $Etapa->nombre = "";
        $Etapa->estado = 1;
        $datos['Etapa'] = $Etapa;

        return view('etapaClicloDeming/vista', $datos);
    }

    public function ingresar() {
        try {
            if ($_POST['idEtapa'] == 0) {
                $Etapa = new EtapaClicloDemingModel();
                $mensaje = "Etapa Creado con Exito";
            } else {
                $Etapa = EtapaClicloDemingModel::find($_POST['idEtapa']);
                $mensaje = "Etapa Actualizado con Exito";
            }
            $Etapa->nombre = $_POST['nombre'];
            $Etapa->estado = $_POST['estado'];
            $Etapa->save();

            return redirect(url('/') . "/etapa")->with("success", $mensaje);
        } catch (\Exception $ex) {
            return redirect()->back()->with("error", $ex->getMessage());
        }
    }

    public function editar($id) {
        $Etapa = EtapaModel::find($id);

        $datos['modulo'] = $this->modulo;
        $datos['permiso'] = $this->permiso;
        if ($this->permiso == 0) {
            return view('sinPermiso', $datos);
        }
        $this->breadcume[0]['url'] = url('/') . "/etapa";
        $this->breadcume[] = array(
            "url" => "",
            "nombre" => $Etapa->nombre
        );

        $datos['breadcume'] = $this->breadcume;

        $datos['Etapa'] = $Etapa;
        $datos['lista'] = EtapaClicloDemingModel::where('id', '<>', 0)->orderBy('nombre', 'asc')->get();

        return view('etapaCicloDeming/vista', $datos);
    }

}
