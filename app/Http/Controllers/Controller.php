<?php

namespace App\Http\Controllers;

session_start();

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController {

    use AuthorizesRequests,
        DispatchesJobs,
        ValidatesRequests;

    public function getConfiguracion() {
        $Config = \App\Models\ConfiguracionModel::all();

        $return = array();
        foreach ($Config as $conf) {
            $return[$conf->nombre] = $conf->valor;
        }
        return $return;
    }

    function getSlug($nombre) {
        return strtolower(trim(preg_replace('~[^0-9a-z]+~i', '-', html_entity_decode(preg_replace('~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i', '$1', htmlentities($nombre, ENT_QUOTES, 'UTF-8')), ENT_QUOTES, 'UTF-8')), '-'));
    }

    function evaluarCriterio($idIndicador) {

        $Indicador = \App\Models\IndicadorModel::find($idIndicador);
        $SubCriterio = \App\Models\SubCriterioModel::find($Indicador->subcriterio_id);
        $Criterio = \App\Models\CriterioModel::find($Indicador->criterio_id);

        $sql = "select * from indicador where subcriterio_id=" . $SubCriterio->id;
        $valorSubCriterio = 0;
        $result = \DB::select($sql);
        foreach ($result as $res) {
            $valorSubCriterio = $valorSubCriterio + $res->valor;
        }
        //$valorSubCriterio = $valorSubCriterio / count($result);
        $SubCriterio->valor = $valorSubCriterio;
        $SubCriterio->save();

        $sql = "select * from subcriterio where criterio_id=" . $Criterio->id;
        $valorCriterio = 0;
        $result = \DB::select($sql);
        foreach ($result as $res) {
            $valorCriterio = $valorCriterio + $res->valor;
        }
        //$valorCriterio = $valorCriterio / count($result);
        $Criterio->valor = $valorCriterio;
        $Criterio->save();
    }

}
