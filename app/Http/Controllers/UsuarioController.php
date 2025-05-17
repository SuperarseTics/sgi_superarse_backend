<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers;

/**
 * Description of UsuarioController
 *
 * @author sebas
 */
use App\Http\Controllers\Controller;
use App\Models\UsuarioModel;
use App\Models\RolModel;

class UsuarioController extends Controller {

    private $modulo;
    private $breadcume;
    private $id;
    private $permiso;

    public function __construct() {
        $this->id = 7;
        $this->permiso = 0;

        if (!isset($_SESSION['usuarioCalidad'])) {
            \Redirect::to(url('/'))->send();
        }
        if (isset($_SESSION['permisosCalidad'][$this->id])) {
            $this->permiso = $_SESSION['permisosCalidad'][$this->id];
        }

        $this->modulo = "Administración de Usuarios";
        $this->breadcume = array(
            array('url' => '', 'nombre' => $this->modulo)
        );
    }

    public function index() {

        $datos['modulo'] = $this->modulo;
        $Usuario = new UsuarioModel();
        $Usuario->id = 0;
        $Usuario->nombre = "";
        $Usuario->rol_id = 0;
        $Usuario->usuario = "";
        $Usuario->password = "";
        $Usuario->estado = 1;
        $datos['Usuario'] = $Usuario;

        $datos['roles'] = RolModel::all();
        $datos['lista'] = UsuarioModel::where('rol_id', '<>', 0)->orderBy('usuario')->get();
        $datos['breadcume'] = $this->breadcume;
        $datos['permiso'] = $this->permiso;

        return view('usuario/vista', $datos);
    }

    public function ingresar() {
        try {
            $mensaje = "";
            if ($_POST['idUsuario'] == 0) {
                $Usuario = new UsuarioModel();
                $password = md5($_POST['password']);
                $mensaje = "Usuario Ingresado con éxito";
            } else {
                $Usuario = UsuarioModel::find($_POST['idUsuario']);
                $password = $Usuario->password;
                if ($_POST['password'] != "**--**") {
                    $password = md5($_POST['password']);
                }
                $mensaje = "Usuario Actualizado con éxito";
            }
            $Usuario->nombre = $_POST['nombre'];
            $Usuario->rol_id = $_POST['rol'];
            $Usuario->usuario = $_POST['usuario'];
            $Usuario->password = $password;
            $Usuario->estado = $_POST['estado'];
            $Usuario->save();
            return redirect(url('/') . "/usuario")->with('success', $mensaje);
        } catch (\Exception $e) {
            return redirect(url('/') . "/usuario")->with('error', $e->getMessage());
        }
    }

    public function editar($id) {

        $datos['modulo'] = $this->modulo;
        $Usuario = UsuarioModel::find($id);
        $Usuario->password = "**--**";
        $datos['Usuario'] = $Usuario;

        $datos['roles'] = RolModel::all();
        $datos['lista'] = UsuarioModel::where('rol_id', '<>', 0)->orderBy('usuario')->get();
        $datos['breadcume'] = $this->breadcume;
        $datos['permiso'] = $this->permiso;

        return view('usuario/vista', $datos);
    }

}
