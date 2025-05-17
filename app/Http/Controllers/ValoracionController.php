<?php

namespace App\Http\Controllers;

/**
 * Description of ValoracionController
 *
 * @author USUARIO
 */
use App\Http\Controllers\Controller;
use App\Models\ValoracionModel;

class ValoracionController extends Controller {

    //put your code here

    private $modulo;
    private $breadcume;
    private $id;
    private $permiso;

    public function __construct() {
        $this->id = 4;
        $this->permiso = 0;

        if (!isset($_SESSION['usuarioCalidad'])) {
            \Redirect::to(url('/'))->send();
        }

        if (isset($_SESSION['permisosCalidad'][$this->id])) {
            $this->permiso = $_SESSION['permisosCalidad'][$this->id];
        }

        $this->modulo = "Administración de Valoración Cualitativa";
        $this->breadcume = array(
            array('url' => '', 'nombre' => $this->modulo)
        );
    }

    public function index() {

        $datos['modulo'] = $this->modulo;
        $datos['breadcume'] = $this->breadcume;
        $datos['permiso'] = $this->permiso;
        $datos['lista'] = ValoracionModel::all();

        $Valoracion = new ValoracionModel();
        $Valoracion->id = 0;
        $Valoracion->nombre = "";
        $Valoracion->porcentaje = 0;
        $Valoracion->estado = 1;
        $datos['Valoracion'] = $Valoracion;

        return view('valoracion/vista', $datos);
    }

    public function ingresar() {
        try {
            if ($_POST['idValoracion'] == 0) {
                $Valoracion = new ValoracionModel();
                $mensaje = "Valoración Creado con Exito";
            } else {
                $Valoracion = ValoracionModel::find($_POST['idValoracion']);
                $mensaje = "Valoración Actualizado con Exito";
            }
            $Valoracion->nombre = $_POST['nombre'];
            $Valoracion->estado = $_POST['estado'];
            $Valoracion->porcentaje = $_POST['porcentaje'];
            $Valoracion->save();

            return redirect(url('/') . "/valoracion")->with("success", $mensaje);
        } catch (\Exception $ex) {
            return redirect()->back()->with("error", $ex->getMessage());
        }
    }

    public function editar($id) {
        $Valoracion = ValoracionModel::find($id);

        $datos['modulo'] = $this->modulo;
        $datos['permiso'] = $this->permiso;
        if ($this->permiso == 0) {
            return view('sinPermiso', $datos);
        }
        $this->breadcume[0]['url'] = url('/') . "/valoracion";
        $this->breadcume[] = array(
            "url" => "",
            "nombre" => $Valoracion->nombre
        );

        $datos['breadcume'] = $this->breadcume;

        $datos['Valoracion'] = $Valoracion;
        $datos['lista'] = ValoracionModel::where('id', '<>', 0)->orderBy('nombre', 'asc')->get();

        return view('valoracion/vista', $datos);
    }

}
