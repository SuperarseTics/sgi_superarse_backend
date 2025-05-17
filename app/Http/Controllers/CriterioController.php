<?php

namespace App\Http\Controllers;

/**
 * Description of CriterioController
 *
 * @author USUARIO
 */
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CriterioModel;
use App\Models\SubCriterioModel;

class CriterioController extends Controller {

    private $modulo;
    private $breadcume;
    private $id;
    private $permiso;

    public function __construct() {
        $this->id = 1;
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
        $datos['lista'] = CriterioModel::all();

        $sql = "select sum(peso) as 'peso' from criterio where estado=1";
        $result = \DB::select($sql);
        $peso = 0;
        foreach ($result as $res) {
            $peso = $res->peso;
        }

        $datos['pesoMin'] = 1;
        $datos['pesoMax'] = 100 - $peso;

        $Criterio = new CriterioModel();
        $Criterio->id = 0;
        $Criterio->nombre = "";
        $Criterio->estado = 1;
        $Criterio->peso = $peso;
        $Criterio->color = "FFFFFF";
        $datos['Criterio'] = $Criterio;

        return view('criterio/vista', $datos);
    }

    public function ingresar() {
        try {
            if ($_POST['idCriterio'] == 0) {
                $Criterio = new CriterioModel();
                $Criterio->valor = 0;
                $mensaje = "Criterio Creado con Exito";
            } else {
                $Criterio = CriterioModel::find($_POST['idCriterio']);
                $mensaje = "CCriterio Actualziado con Exito";
            }
            $Criterio->nombre = $_POST['nombre'];
            $Criterio->estado = $_POST['estado'];
            $Criterio->peso = $_POST['peso'];
            $Criterio->color = $_POST['color'];
            $Criterio->save();

            return redirect(url('/') . "/criterio")->with("success", $mensaje);
        } catch (\Exception $ex) {
            return redirect()->back()->with("error", $ex->getMessage());
        }
    }

    public function editar($id) {
        $Criterio = CriterioModel::find($id);

        $datos['modulo'] = $this->modulo;
        $datos['permiso'] = $this->permiso;
        if ($this->permiso == 0) {
            return view('sinPermiso', $datos);
        }
        $this->breadcume[0]['url'] = url('/') . "/criterio";
        $this->breadcume[] = array(
            "url" => "",
            "nombre" => $Criterio->nombre
        );

        $datos['breadcume'] = $this->breadcume;

        $datos['Criterio'] = $Criterio;
        $datos['lista'] = CriterioModel::where('id', '<>', 0)->orderBy('nombre', 'asc')->get();

        $sql = "select sum(peso) as 'peso' from criterio where estado=1";
        $result = \DB::select($sql);
        $peso = 0;
        foreach ($result as $res) {
            $peso = $res->peso;
        }

        $datos['pesoMin'] = 1;
        $datos['pesoMax'] = 100 - $peso;

        return view('criterio/vista', $datos);
    }

    public function getSubCriterio() {
        $Sub = SubCriterioModel::where('criterio_id', $_GET['idCriterio'])->where('estado', 1)->orderBy('nombre', 'asc')->get();
        $datos['subcriterios'] = $Sub;
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

        return view('criterio/subcriterio', $datos);
    }

    public function subcriterionByCriterion (Request $request) {
        $subcriterions = SubCriterioModel::where('criterio_id', $request->criterion)
            ->where('estado', 1)
            ->orderBy('nombre')
            ->get();

        $options = '<option value="">Escoja una Opcion</option>';
        foreach ($subcriterions as $subcriterionData) {
            $options .= '<option value="' . $subcriterionData->id . '">' . $subcriterionData->nombre . '</option>';
        }

        return response($options);
    }

}
