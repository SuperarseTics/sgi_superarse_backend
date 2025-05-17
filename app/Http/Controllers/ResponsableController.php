<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers;

/**
 * Description of ResponsableController
 *
 * @author sebas
 */
use App\Http\Controllers\Controller;
use App\Models\ResponsableModel;
use App\Http\Clases\MailClass;

//use App\Http\Models\ConfiguracionModel;

class ResponsableController extends Controller {

    //put your code here


    private $modulo;
    private $breadcume;
    private $id;
    private $permiso;

    public function __construct() {
        $this->id = 8;
        $this->permiso = 0;

        if (!isset($_SESSION['usuarioCalidad'])) {
            \Redirect::to(url('/'))->send();
        }
        if (isset($_SESSION['permisosCalidad'][$this->id])) {
            $this->permiso = $_SESSION['permisosCalidad'][$this->id];
        }
        $this->modulo = "Administración de Responsables";
        $this->breadcume = array(
            array('url' => '', 'nombre' => $this->modulo)
        );
    }

    public function index() {

        $datos['modulo'] = $this->modulo;
        $datos['permiso'] = $this->permiso;
        $datos['breadcume'] = $this->breadcume;

        $Responsable = new ResponsableModel();
        $Responsable->id = 0;
        $Responsable->nombre = "";
        $Responsable->celular = "";
        $Responsable->correo = "";
        $Responsable->usuario = "";
        $Responsable->estado = 1;
        $datos['Responsable'] = $Responsable;
        $datos['lista'] = ResponsableModel::where('id', '<>', 0)->get();

        return view('responsable/vista', $datos);
    }

    public function ingresar() {
        try {
            $mensaje = "";
            if ($_POST['idResponsable'] == 0) {
                $Responsable = new ResponsableModel();
                $Responsable->password = md5($_POST['password']);
                $mensaje = "Responsable Ingresado con éxito";
            } else {
                $Responsable = ResponsableModel::find($_POST['idResponsable']);
                if ($_POST['password'] != "**--**") {
                    $Responsable->password = md5($_POST['password']);
                }
                $mensaje = "ResponsableActualizado con éxito";
            }

            $Responsable->nombre = $_POST['nombre'];
            $Responsable->nombre = $_POST['nombre'];
            $Responsable->celular = $_POST['celular'];
            $Responsable->correo = $_POST['correo'];
            $Responsable->usuario = $_POST['usuario'];
            $Responsable->estado = $_POST['estado'];
            $Responsable->save();
            if ($_POST['password'] != "**--**") {
                $Mail = new MailClass();
                $Mail->enviarCorreoResponsable($Responsable->id, $_POST['password']);
            }

            return redirect(url('/') . "/responsable")->with('success', $mensaje);
        } catch (\Exception $e) {
            return redirect(url('/') . "/responsable")->with('error', $e->getMessage());
        }
    }

    public function editar($id) {

        $datos['modulo'] = $this->modulo;
        $datos['permiso'] = $this->permiso;
        $datos['breadcume'] = $this->breadcume;

        $Responsable = ResponsableModel::find($id);
        $Responsable->password = "**--**";
        $datos['Responsable'] = $Responsable;
        $datos['lista'] = ResponsableModel::where('id', '<>', 0)->get();
        return view('responsable/vista', $datos);
    }

}
