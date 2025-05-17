<?php

namespace App\Http\Controllers;

/**
 * Description of ElementosFundamentalesController
 *
 * @author USUARIO
 */
use App\Http\Controllers\Controller;
use App\Models\ElementosFundamentalesModel;

class ElementosFundamentalesController extends Controller {

    //put your code here

    private $modulo;
    private $breadcume;
    private $id;
    private $permiso;

    public function __construct() {
        $this->id = 5;
        $this->permiso = 0;

        if (!isset($_SESSION['usuarioCalidad'])) {
            \Redirect::to(url('/'))->send();
        }

        if (isset($_SESSION['permisosCalidad'][$this->id])) {
            $this->permiso = $_SESSION['permisosCalidad'][$this->id];
        }

        $this->modulo = "Administración de Elementos Fundamentales";
        $this->breadcume = array(
            array('url' => '', 'nombre' => $this->modulo)
        );
    }

    public function index() {

        $datos['modulo'] = $this->modulo;
        $datos['breadcume'] = $this->breadcume;
        $datos['permiso'] = $this->permiso;
        $datos['lista'] = ElementosFundamentalesModel::all();

        $ElementosFundamentales = new ElementosFundamentalesModel();
        $ElementosFundamentales->id = 0;
        $ElementosFundamentales->nombre = "";
        $ElementosFundamentales->clasificacion = "";
        $ElementosFundamentales->descripcion_elemento = "";
        $ElementosFundamentales->descripcion_evidencia = "";
        $ElementosFundamentales->estado = 1;
        $datos['ElementosFundamentales'] = $ElementosFundamentales;

        return view('elementosFundamentales/vista', $datos);
    }

    public function ingresar() {
        try {
            if ($_POST['idElementosFundamentales'] == 0) {
                $ElementosFundamentales = new ElementosFundamentalesModel();
                $mensaje = "Elementos Fundamentales Creado con Exito";
            } else {
                $ElementosFundamentales = ElementosFundamentalesModel::find($_POST['idElementosFundamentales']);
                $mensaje = "Elementos Fundamentales Actualziado con Exito";
            }
            $ElementosFundamentales->nombre = $_POST['nombre'];
            $ElementosFundamentales->descripcion_elemento = $_POST['descripcionElemento'];
            $ElementosFundamentales->descripcion_evidencia = $_POST['descripcionEvidencia'];
            $ElementosFundamentales->estado = $_POST['estado'];
            $ElementosFundamentales->save();

            return redirect(url('/') . "/elementos-fundamentales")->with("success", $mensaje);
        } catch (\Exception $ex) {
            return redirect()->back()->with("error", $ex->getMessage());
        }
    }

    public function editar($id) {
        $ElementosFundamentales = ElementosFundamentalesModel::find($id);

        $datos['modulo'] = $this->modulo;
        $datos['permiso'] = $this->permiso;
        if ($this->permiso == 0) {
            return view('sinPermiso', $datos);
        }
        $this->breadcume[0]['url'] = url('/') . "/elementos-fundamentales";
        $this->breadcume[] = array(
            "url" => "",
            "nombre" => $ElementosFundamentales->nombre
        );

        $datos['breadcume'] = $this->breadcume;

        $datos['ElementosFundamentales'] = $ElementosFundamentales;
        $datos['lista'] = ElementosFundamentalesModel::where('id', '<>', 0)->orderBy('nombre', 'asc')->get();

        return view('elementosFundamentales/vista', $datos);
    }

}
