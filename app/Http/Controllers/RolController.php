<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers;

/**
 * Description of RolController
 *
 * @author sebas
 */
use App\Http\Controllers\Controller;
use App\Models\RolModel;
use App\Models\ModulosModel;

class RolController extends Controller {

    //put your code here
    private $modulo;
    private $breadcume;
    private $id;
    private $permiso;

    public function __construct() {
        $this->id = 6;
        $this->permiso = 0;
        if (!isset($_SESSION['usuarioCalidad'])) {
            \Redirect::to(url('/'))->send();
        }
        if (isset($_SESSION['permisosCalidad'][$this->id])) {
            $this->permiso = $_SESSION['permisosCalidad'][$this->id];
        }
        $this->modulo = "Administración de Roles";
        $this->breadcume = array(
            array('url' => '', 'nombre' => $this->modulo)
        );
    }

    public function index() {

        $datos['modulo'] = $this->modulo;
        $Roles = RolModel::all();
        $Modulos = ModulosModel::all();
        $modAux = array();
        foreach ($Modulos as $mod) {
            $modAux[$mod->id] = $mod->nombre;
        }

        for ($i = 0; $i < count($Roles); $i++) {
            $permisosArray = json_decode($Roles[$i]->permisos, true);
            $keys = array_keys($permisosArray);
            $permisos = array();
            foreach ($keys as $key) {
                $permisos[] = array(
                    'modulo' => $modAux[$key],
                    'permiso' => \Config::get('parametros.permisosModulo')[$permisosArray[$key]]
                );
            }
            $Roles[$i]['permisosModulo'] = $permisos;
        }


        $datos['lista'] = $Roles;
        $datos['breadcume'] = $this->breadcume;
        $datos['permiso'] = $this->permiso;

        return view('rol/vista', $datos);
    }

    public function nuevo() {
        $datos['modulo'] = $this->modulo . " - Nuevo";
        $datos['modulos'] = ModulosModel::all();
        $datos['breadcume'] = $this->breadcume;
        $datos['permiso'] = $this->permiso;

        return view('rol/formularioIngreso', $datos);
    }

    public function ingresar() {
        try {
            $Rol = new RolModel();
            $Rol->nombre = $_POST['nombre'];
            $Rol->permisos = json_encode($_POST['modulo']);
            $Rol->save();

            return redirect(url('/') . "/rol")->with('success', "Rol Ingresado con éxito");
        } catch (\Exception $e) {
            return redirect(url('/') . "/rol")->with('error', $e->getMessage());
        }
    }

    public function editar($id) {
        $Rol = RolModel::find($id);
        $Rol->permisosModulo = json_decode($Rol->permisos, true);

        $datos['Rol'] = $Rol;
        $datos['modulo'] = $this->modulo . " - " . $Rol->nombre;
        $datos['modulos'] = ModulosModel::all();
        $datos['breadcume'] = $this->breadcume;
        $datos['permiso'] = $this->permiso;

        return view('rol/formularioEdicion', $datos);
    }

    public function actualizar() {
        try {
            $Rol = RolModel::find($_POST['idRol']);
            $Rol->nombre = $_POST['nombre'];
            $Rol->permisos = json_encode($_POST['modulo']);
            $Rol->save();

            return redirect(url('/') . "/rol")->with('success', "Rol Actualizado con éxito");
        } catch (\Exception $e) {
            return redirect(url('/') . "/rol")->with('error', $e->getMessage());
        }
    }

}
