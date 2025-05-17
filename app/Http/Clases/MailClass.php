<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Clases;

/**
 * Description of MailClass
 *
 * @author sebas
 */
use Mail;

class MailClass {

    //put your code here


    public function enviarCorreoResponsable($idProfesor, $password) {


        $Profesor = \App\Models\ResponsableModel::find($idProfesor);

        $datos = array();
        $datos['Profesor'] = $Profesor;
        $datos['password'] = $password;
        $subject = "Datos de Acceso a SIG";
        $for = $Profesor->correo;

        Mail::send('correo/responsable', $datos, function ($msj) use ($subject, $for) {
            $msj->from(\Config::get('parametros.correoEnvio'), \Config::get('parametros.nombreCorreo'));
            $msj->subject($subject);
            $msj->to($for);
        });
    }

    public function enviarCorreoEvaluador($idProfesor, $password) {


        $Profesor = \App\Models\EvaluadorModel::find($idProfesor);

        $datos = array();
        $datos['Profesor'] = $Profesor;
        $datos['password'] = $password;
        $subject = "Datos de Acceso a SIG";
        $for = $Profesor->correo;

        Mail::send('correo/responsable', $datos, function ($msj) use ($subject, $for) {
            $msj->from(\Config::get('parametros.correoEnvio'), \Config::get('parametros.nombreCorreo'));
            $msj->subject($subject);
            $msj->to($for);
        });
    }

    public function evaluacionIndicador($idIndicador) {
        $Indicador = \App\Models\IndicadorModel::find($idIndicador);
        $Responsable = \App\Models\ResponsableModel::find($Indicador->responsable_ejecucion);
        $Evaluador = \App\Models\EvaluadorModel::find($Indicador->responsable_evaluacion);
        $Resultados = \App\Models\ResultadosIndicadorModel::where('indicador_id', $Indicador->id)->get();
        $datos = array(
            array(
                'correo' => $Evaluador->correo,
                'nombre' => $Evaluador->nombre,
                'Indicador' => $Indicador,
                'resultados' => $Resultados
            ),
            array(
                'correo' => $Responsable->correo,
                'nombre' => $Responsable->nombre,
                'Indicador' => $Indicador,
                'resultados' => $Resultados
            )
        );

        $subject = "Evaluación del Indicador " . $Indicador->nombre;

        foreach ($datos as $dat) {
            $for = $dat['correo'];
            Mail::send('correo/evaluacionIndicador', $dat, function ($msj) use ($subject, $for) {
                $msj->from(\Config::get('parametros.correoEnvio'), \Config::get('parametros.nombreCorreo'));
                $msj->subject($subject);
                $msj->to($for);
            });
        }
    }

    public function accionesAbiertas() {
        $subject = "Acciones Correctivas Abiertas";
        $sql = "select indicador_id from acciones_correctivas_indicador where estado=1 group by indicador_id";
        $result = \DB::select($sql);

        $acciones = array();
        foreach ($result as $res) {
            $acciones = \App\Models\AccionesCorrectivasModel::where('estado', 1)->where('indicador_id', $res->indicador_id)->get();
            $Indicador = \App\Models\IndicadorModel::find($res->indicador_id);
            $Evaluador = \App\Models\EvaluadorModel::find($Indicador->responsable_evaluacion);

            $datos['accionesCorrectivas'] = $acciones;
            $datos['Indicador'] = $Indicador;
            $datos['nombre'] = $Evaluador->nombre;
            $for = $Evaluador->correo;
            Mail::send('correo/accionesAbiertasIndicador', $datos, function ($msj) use ($subject, $for) {
                $msj->from(\Config::get('parametros.correoEnvio'), \Config::get('parametros.nombreCorreo'));
                $msj->subject($subject);
                $msj->to($for);
            });
        }
    }

}
