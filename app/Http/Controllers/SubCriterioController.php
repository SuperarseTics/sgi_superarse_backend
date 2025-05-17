<?php

namespace App\Http\Controllers;

/**
 * Description of SubCriterioController
 *
 * @author USUARIO
 */
use App\Http\Controllers\Controller;
use App\Models\CriterioModel;
use App\Models\SubCriterioModel;

class SubCriterioController extends Controller {

    //put your code here

    private $modulo;
    private $breadcume;
    private $id;
    private $permiso;

    public function __construct() {
        $this->id = 2;
        $this->permiso = 0;

        if (!isset($_SESSION['usuarioCalidad'])) {
            \Redirect::to(url('/'))->send();
        }

        if (isset($_SESSION['permisosCalidad'][$this->id])) {
            $this->permiso = $_SESSION['permisosCalidad'][$this->id];
        }

        $this->modulo = "Administración de Criterios";
        $this->breadcume = array(
            array('url' => '', 'nombre' => $this->modulo)
        );
    }

    public function index() {

        $datos['modulo'] = $this->modulo;
        $datos['breadcume'] = $this->breadcume;
        $datos['permiso'] = $this->permiso;
        $datos['lista'] = SubCriterioModel::all();

        $SubCriterio = new SubCriterioModel();
        $SubCriterio->id = 0;
        $SubCriterio->criterio_id = 0;
        $SubCriterio->nombre = "";
        $SubCriterio->estado = 1;
        $datos['SubCriterio'] = $SubCriterio;

        $datos['criterios'] = CriterioModel::where('estado', 1)->orderBy('nombre', 'asc')->get();

        return view('subcriterio/vista', $datos);
    }

    public function ingresar() {
        try {
            if ($_POST['idSubCriterio'] == 0) {
                $SubCriterio = new SubCriterioModel();
                $SubCriterio->valor = 0;
                $SubCriterio->criterio_id = $_POST['criterio'];
                $mensaje = "SubCriterio Creado con Exito";
            } else {
                $SubCriterio = SubCriterioModel::find($_POST['idSubCriterio']);
                $mensaje = "SubCriterio Actualziado con Exito";
            }
            $SubCriterio->nombre = $_POST['nombre'];
            $SubCriterio->estado = $_POST['estado'];
            $SubCriterio->save();

            return redirect(url('/') . "/subcriterio")->with("success", $mensaje);
        } catch (\Exception $ex) {
            return redirect()->back()->with("error", $ex->getMessage());
        }
    }

    public function editar($id) {
        $SubCriterio = SubCriterioModel::find($id);

        $datos['modulo'] = $this->modulo;
        $datos['permiso'] = $this->permiso;
        if ($this->permiso == 0) {
            return view('sinPermiso', $datos);
        }
        $this->breadcume[0]['url'] = url('/') . "/subcriterio";
        $this->breadcume[] = array(
            "url" => "",
            "nombre" => $SubCriterio->nombre
        );

        $datos['breadcume'] = $this->breadcume;

        $datos['SubCriterio'] = $SubCriterio;

        $datos['criterios'] = CriterioModel::where('estado', 1)->orderBy('nombre', 'asc')->get();
		
		
        $datos['lista'] = SubCriterioModel::where('id', '<>', 0)->orderBy('nombre', 'asc')->get();

        return view('subcriterio/vista', $datos);
    }

    public function getIndicadores() {
        $Sub = \App\Models\IndicadorModel::where('subcriterio_id', $_GET['idSubCriterio'])->where('estado', 1)->orderBy('nombre', 'asc')->get();
        $datos['indicadores'] = $Sub;

        $todos = 0;
        $modulo = "";
        if (isset($_GET['modulo'])) {

            switch ($_GET['modulo']) {
                case "buscador":
                    $todos = 1;
                    break;
                default:
                    $todos = 0;
                    break;
            }
        }
        $datos['todos'] = $todos;

        return view('subcriterio/indicadores', $datos);
    }

}
