<?php

namespace App\Http\Controllers;

/**
 * Description of DashController
 *
 * @author USUARIO
 */
use App\Http\Controllers\Controller;
use App\Models\CriterioModel;

class DashController extends Controller {

    //put your code here

    private $modulo;
    private $breadcume;
    private $id;
    private $permiso;

    public function __construct() {
        $this->permiso = 1;

        if (!isset($_SESSION['usuarioCalidad'])) {
            \Redirect::to(url('/'))->send();
        }


        $this->modulo = "SUPERARSE::SIG";
        $this->breadcume = array(
            array('url' => '', 'nombre' => $this->modulo)
        );
    }

    public function index() {

        $datos['modulo'] = $this->modulo;
        $datos['breadcume'] = $this->breadcume;
        $datos['permiso'] = $this->permiso;
        $Criterios = CriterioModel::where('estado', 1)->orderBy('nombre', 'asc')->get();
        $datos['criterios'] = $Criterios;

        $ids = array();
        foreach ($Criterios as $cri) {
            $hexadecimal = $cri->color;
            $rojo = hexdec(substr($hexadecimal, 1, 2));
            $verde = hexdec(substr($hexadecimal, 3, 2));
            $azul = hexdec(substr($hexadecimal, 5, 2));

            $ids[] = array(
                'id' => $cri->id,
                'nombre' => $cri->nombre,
                'valor' => $cri->valor,
                'peso' => $cri->peso,
                'color' => array(
                    'rojo' => $rojo,
                    'verde' => $verde,
                    'azul' => $azul
                )
            );
        }

        $datos['ids'] = $ids;

        $nombreCriterios = array();
        $valoresCriterios = array();
        $faltante = 100;
        $colores = array();
        $bordes = array();
        foreach ($ids as $id) {
            $nombreCriterios[] = $id['nombre'];
            $valoresCriterios[] = $id['valor'];
            $faltante = $faltante - $id['valor'];
            $color = "rgba(" . $id['color']['rojo'] . ", " . $id['color']['verde'] . ", " . $id['color']['azul'] . ", 0.5)";
            $colores[] = $color;
            $borde = "rgba(" . $id['color']['rojo'] . ", " . $id['color']['verde'] . ", " . $id['color']['azul'] . ", 1)";
            $bordes[] = $borde;
        }
        $nombreCriterios[] = "Faltante";
        $valoresCriterios[] = $faltante;
        $colores[] = "rgba(214, 214, 214, 0.5)";
        $bordes[] = "rgba(214,214,214, 1)";

        $datos['nombreCriterios'] = $nombreCriterios;
        $datos['valoresCriterios'] = $valoresCriterios;
        $datos['colores'] = $colores;
        $datos['bordes'] = $bordes;

        return view('dash', $datos);
    }

}
