<?php

namespace App\Http\Controllers;

/**
 * Description of CargoController
 *
 * @author USUARIO
 */
use App\Http\Controllers\Controller;
use App\Models\CargoModel;

class CargoController extends Controller {

    //put your code here
    private $modulo;
    private $breadcume;
    private $id;
    private $permiso;

    public function __construct() {
        $this->id = 11;
        $this->permiso = 0;

        if (!isset($_SESSION['usuarioCalidad'])) {
            \Redirect::to(url('/'))->send();
        }

        if (isset($_SESSION['permisosCalidad'][$this->id])) {
            $this->permiso = $_SESSION['permisosCalidad'][$this->id];
        }

        $this->modulo = "Administración de Cargos";
        $this->breadcume = array(
            array('url' => '', 'nombre' => $this->modulo)
        );
    }

    public function index() {

        $datos['modulo'] = $this->modulo;
        $datos['breadcume'] = $this->breadcume;
        $datos['permiso'] = $this->permiso;
        $datos['lista'] = CargoModel::all();

        $Cargo = new CargoModel();
        $Cargo->id = 0;
        $Cargo->nombre = "";
        $Cargo->estado = 1;
        $datos['Cargo'] = $Cargo;

        return view('cargo/vista', $datos);
    }

    public function ingresar() {
        try {
            if ($_POST['idCargo'] == 0) {
                $Cargo = new CargoModel();
                $mensaje = "Cargo Creado con Exito";
            } else {
                $Cargo = CargoModel::find($_POST['idCargo']);
                $mensaje = "Cargo Actualizado con Exito";
            }
            $Cargo->nombre = $_POST['nombre'];
            $Cargo->estado = $_POST['estado'];
            $Cargo->save();

            return redirect(url('/') . "/cargo")->with("success", $mensaje);
        } catch (\Exception $ex) {
            return redirect()->back()->with("error", $ex->getMessage());
        }
    }

    public function editar($id) {
        $Cargo = CargoModel::find($id);

        $datos['modulo'] = $this->modulo;
        $datos['permiso'] = $this->permiso;
        if ($this->permiso == 0) {
            return view('sinPermiso', $datos);
        }
        $this->breadcume[0]['url'] = url('/') . "/criterio";
        $this->breadcume[] = array(
            "url" => "",
            "nombre" => $Cargo->nombre
        );

        $datos['breadcume'] = $this->breadcume;

        $datos['Cargo'] = $Cargo;
        $datos['lista'] = CargoModel::where('id', '<>', 0)->orderBy('nombre', 'asc')->get();

        return view('cargo/vista', $datos);
    }

}
