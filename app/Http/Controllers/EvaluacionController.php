<?php

namespace App\Http\Controllers;

/**
 * Description of EvaluacionController
 *
 * @author USUARIO
 */
use App\Http\Controllers\Controller;
use App\Models\CriterioModel;
use App\Models\IndicadorModel;
use App\Models\SubCriterioModel;
use App\Models\GestorDocumentalModel;
use App\Models\AutoevaluacionModel;
use App\Models\ResultadosIndicadorModel;
use App\Models\AccionesCorrectivasModel;
use App\Models\AccionesPreventivasModel;
use App\Models\ValoracionModel;
use App\Http\Clases\MailClass;

class EvaluacionController extends Controller {

    //put your code here
    private $modulo;
    private $breadcume;
    private $id;
    private $permiso;

    public function __construct() {
        $this->id = 15;
        $this->permiso = 1;

        if (!isset($_SESSION['usuarioCalidad'])) {
            \Redirect::to(url('/'))->send();
        }


        $this->modulo = "Evaluaci¨®n de Criterio";
        $this->breadcume = array(
            array('url' => '', 'nombre' => $this->modulo)
        );
    }

    public function index($id) {

        $datos['modulo'] = $this->modulo;
        $datos['breadcume'] = $this->breadcume;
        $datos['permiso'] = $this->permiso;

        $Criterio = CriterioModel::find($id);
        $SubCriterio = SubCriterioModel::where('criterio_id', $Criterio->id)
                ->where('estado', 1)
                ->orderBy('nombre', 'asc')
                ->get();
        $datos['Criterio'] = $Criterio;
        $datos['subcriterios'] = $SubCriterio;

        if (isset($_GET['sub'])) {
            $idSubcriterio = $_GET['sub'];
        } else {
            $idSubcriterio = 0;
            if (count($SubCriterio) > 0) {
                $idSubcriterio = $SubCriterio[0]->id;
            }
        }


        $Indicadores = IndicadorModel::where('subcriterio_id', $idSubcriterio)
                ->where('criterio_id', $Criterio->id)
                ->where('estado', 1)
                ->get();
        $datos['indicadores'] = $Indicadores;

        if (isset($_GET['indicador'])) {
            $idIndicador = $_GET['indicador'];
            $Indicador = IndicadorModel::find($idIndicador);
        } else {
            $idIndicador = 0;
            $Indicador = new IndicadorModel();
            $Indicador->fecha_autoevaluacion = date("Y-m-d");
            $Indicador->fecha_cumplimiento = date("Y-m-d");
            if (count($Indicadores) > 0) {
                $idIndicador = $Indicadores[0]->id;
                $Indicador = IndicadorModel::find($idIndicador);
            }
        }

        $datos['Indicador'] = $Indicador;

        $datos['idSubcriterio'] = $idSubcriterio;
        $datos['idIndicador'] = $idIndicador;

        $tab = "autoevaluacion";
        if (isset($_GET['tab'])) {
            $tab = $_GET['tab'];
        }

        $datos['tab'] = $tab;

        $contenido = "";

        $datosContenido['Indicador'] = $Indicador;
        $datosContenido['idCriterio'] = $Criterio->id;
        $datosContenido['idSubcriterio'] = $idSubcriterio;

        switch ($tab) {
            case "autoevaluacion";
                $contenido = view('evaluacion/autoevaluacion', $datosContenido);
                break;
            case "documentos":
                $datosContenido['lista'] = GestorDocumentalModel::where('indicador_id', $idIndicador)
                        ->orderBy('fecha_documento', 'asc')
                        ->get();
                $contenido = view('evaluacion/documentos', $datosContenido);
                break;
            case "resultados":
                $datosContenido['lista'] = ResultadosIndicadorModel::where('indicador_id', $idIndicador)
                        ->get();
                $contenido = view('evaluacion/resultados', $datosContenido);
                break;

            case "acciones-correctivas":
                $Acciones = new AccionesCorrectivasModel();
                $Acciones->id = 0;
                $Acciones->nombre = "";
                $Acciones->descripcion = "";
                $Acciones->estado = 0;
                $datosContenido['Acciones'] = $Acciones;

                $datosContenido['lista'] = AccionesCorrectivasModel::where('indicador_id', $idIndicador)
                        ->get();
                $contenido = view('evaluacion/accionesCorrectivas', $datosContenido);
                break;

            case "acciones-preventivas":
                $Acciones = new AccionesPreventivasModel();
                $Acciones->id = 0;
                $Acciones->nombre = "";
                $Acciones->descripcion = "";
                $Acciones->estado = 0;
                $datosContenido['Acciones'] = $Acciones;

                $datosContenido['lista'] = AccionesPreventivasModel::where('indicador_id', $idIndicador)
                        ->get();
                $contenido = view('evaluacion/accionesPreventivas', $datosContenido);
                break;

            case "evaluar":

                switch ($Indicador->tipo_indicador) {
                    case "Cualitativo":
                        $datosContenido['valoraciones'] = ValoracionModel::where('estado', 1)->orderBy('porcentaje', 'asc')->get();
                        $contenido = view('evaluacion/evaluarCualitativo', $datosContenido);
                        break;
                    case "Cuantitativo":
                        $For = json_decode($Indicador->formula);
                        $formula = $For->formula;
                        $variables = $For->variables;
                        $resultado = $For->resultado;
                        $datosContenido['formula'] = $formula;
                        $datosContenido['variables'] = $variables;
                        $datosContenido['resultado'] = $resultado;
                        $contenido = view('evaluacion/evaluarCuantitativo', $datosContenido);
                        break;
                }
        }

        $datos['contenido'] = $contenido;

        return view('evaluacion/vista', $datos);
    }

    public function ingresarAutoevaluacion() {
        try {

            $Indicador = IndicadorModel::find($_POST['idIndicador']);
            $Indicador->fecha_autoevaluacion = $_POST['fechaAutoevaluacion'];
            $Indicador->fecha_cumplimiento = $_POST['fechaCumplimiento'];
            $Indicador->save();

            return redirect(url('/') . "/evaluacion/" . $_POST['idCriterio'] . "?sub=" . $_POST['idSubcriterio'] . "&indicador=" . $_POST['idIndicador'] . "&tab=autoevaluacion")->with("success", "Autoevaluaci¨®n Actualizada con Exito");
        } catch (\Exception $ex) {
            return redirect()->back()->with("error", $ex->getMessage());
        }
    }

    public function ingresarResultados() {
        try {

            $Resultado = new ResultadosIndicadorModel();
            $Resultado->indicador_id = $_POST['idIndicador'];
            $Resultado->resultado = $_POST['resultado'];
            $Resultado->save();

            return redirect(url('/') . "/evaluacion/" . $_POST['idCriterio'] . "?sub=" . $_POST['idSubcriterio'] . "&indicador=" . $_POST['idIndicador'] . "&tab=resultados")->with("success", "Resultado INgresado con Exito");
        } catch (\Exception $ex) {
            return redirect()->back()->with("error", $ex->getMessage());
        }
    }

    public function ingresarAccionesCorrectivas() {
        try {
            if ($_POST['idAcciones'] == 0) {
                $Acciones = new AccionesCorrectivasModel();
                $Acciones->indicador_id = $_POST['idIndicador'];
                $mensaje = "Acciones Ingresada con Exito";
            } else {
                $Acciones = AccionesCorrectivasModel::find($_POST['idAcciones']);
                $mensaje = "Acciones Actualizado con Exito";
            }
            $Acciones->nombre = $_POST['nombre'];
            $Acciones->descripcion = $_POST['descripcion'];
            $Acciones->estado = $_POST['estado'];
            $Acciones->save();
            return redirect(url('/') . "/evaluacion/" . $_POST['idCriterio'] . "?sub=" . $_POST['idSubcriterio'] . "&indicador=" . $_POST['idIndicador'] . "&tab=acciones-correctivas")->with("success", $mensaje);
        } catch (\Exception $ex) {
            return redirect()->back()->with("error", $ex->getMessage());
        }
    }

    public function editarAccionesCorrectivas($id) {

        $datos['modulo'] = $this->modulo;
        $datos['breadcume'] = $this->breadcume;
        $datos['permiso'] = $this->permiso;

        $Criterio = CriterioModel::find($id);
        $SubCriterio = SubCriterioModel::where('criterio_id', $Criterio->id)
                ->where('estado', 1)
                ->orderBy('nombre', 'asc')
                ->get();
        $datos['Criterio'] = $Criterio;
        $datos['subcriterios'] = $SubCriterio;

        if (isset($_GET['sub'])) {
            $idSubcriterio = $_GET['sub'];
        } else {
            $idSubcriterio = 0;
            if (count($SubCriterio) > 0) {
                $idSubcriterio = $SubCriterio[0]->id;
            }
        }


        $Indicadores = IndicadorModel::where('subcriterio_id', $idSubcriterio)
                ->where('criterio_id', $Criterio->id)
                ->where('estado', 1)
                ->get();
        $datos['indicadores'] = $Indicadores;

        if (isset($_GET['indicador'])) {
            $idIndicador = $_GET['indicador'];
            $Indicador = IndicadorModel::find($idIndicador);
        } else {
            $idIndicador = 0;
            $Indicador = new IndicadorModel();
            $Indicador->fecha_autoevaluacion = date("Y-m-d");
            $Indicador->fecha_cumplimiento = date("Y-m-d");
            if (count($Indicadores) > 0) {
                $idIndicador = $Indicadores[0]->id;
                $Indicador = IndicadorModel::find($idIndicador);
            }
        }

        $datos['Indicador'] = $Indicador;

        $datos['idSubcriterio'] = $idSubcriterio;
        $datos['idIndicador'] = $idIndicador;

        $tab = "autoevaluacion";
        if (isset($_GET['tab'])) {
            $tab = $_GET['tab'];
        }

        $datos['tab'] = $tab;

        $contenido = "";

        $datosContenido['Indicador'] = $Indicador;
        $datosContenido['idCriterio'] = $Criterio->id;
        $datosContenido['idSubcriterio'] = $idSubcriterio;

        switch ($tab) {

            case "acciones-correctivas":
                $Acciones = AccionesCorrectivasModel::find($_GET['idAccion']);
                $datosContenido['Acciones'] = $Acciones;
                $datosContenido['lista'] = AccionesCorrectivasModel::where('indicador_id', $idIndicador)
                        ->get();
                $contenido = view('evaluacion/accionesCorrectivas', $datosContenido);
                break;
        }

        $datos['contenido'] = $contenido;

        return view('evaluacion/vista', $datos);
    }

    public function ingresarAccionesPreventivas() {
        try {
            if ($_POST['idAcciones'] == 0) {
                $Acciones = new AccionesPreventivasModel();
                $Acciones->indicador_id = $_POST['idIndicador'];
                $mensaje = "Acciones Ingresada con Exito";
            } else {
                $Acciones = AccionesPreventivasModel::find($_POST['idAcciones']);
                $mensaje = "Acciones Actualizado con Exito";
            }
            $Acciones->nombre = $_POST['nombre'];
            $Acciones->descripcion = $_POST['descripcion'];
            $Acciones->estado = $_POST['estado'];
            $Acciones->save();
            return redirect(url('/') . "/evaluacion/" . $_POST['idCriterio'] . "?sub=" . $_POST['idSubcriterio'] . "&indicador=" . $_POST['idIndicador'] . "&tab=acciones-preventivas")->with("success", $mensaje);
        } catch (\Exception $ex) {
            return redirect()->back()->with("error", $ex->getMessage());
        }
    }

    public function editarAccionesPreventivas($id) {

        $datos['modulo'] = $this->modulo;
        $datos['breadcume'] = $this->breadcume;
        $datos['permiso'] = $this->permiso;

        $Criterio = CriterioModel::find($id);
        $SubCriterio = SubCriterioModel::where('criterio_id', $Criterio->id)
                ->where('estado', 1)
                ->orderBy('nombre', 'asc')
                ->get();
        $datos['Criterio'] = $Criterio;
        $datos['subcriterios'] = $SubCriterio;

        if (isset($_GET['sub'])) {
            $idSubcriterio = $_GET['sub'];
        } else {
            $idSubcriterio = 0;
            if (count($SubCriterio) > 0) {
                $idSubcriterio = $SubCriterio[0]->id;
            }
        }


        $Indicadores = IndicadorModel::where('subcriterio_id', $idSubcriterio)
                ->where('criterio_id', $Criterio->id)
                ->where('estado', 1)
                ->get();
        $datos['indicadores'] = $Indicadores;

        if (isset($_GET['indicador'])) {
            $idIndicador = $_GET['indicador'];
            $Indicador = IndicadorModel::find($idIndicador);
        } else {
            $idIndicador = 0;
            $Indicador = new IndicadorModel();
            $Indicador->fecha_autoevaluacion = date("Y-m-d");
            $Indicador->fecha_cumplimiento = date("Y-m-d");
            if (count($Indicadores) > 0) {
                $idIndicador = $Indicadores[0]->id;
                $Indicador = IndicadorModel::find($idIndicador);
            }
        }

        $datos['Indicador'] = $Indicador;

        $datos['idSubcriterio'] = $idSubcriterio;
        $datos['idIndicador'] = $idIndicador;

        $tab = "autoevaluacion";
        if (isset($_GET['tab'])) {
            $tab = $_GET['tab'];
        }

        $datos['tab'] = $tab;

        $contenido = "";

        $datosContenido['Indicador'] = $Indicador;
        $datosContenido['idCriterio'] = $Criterio->id;
        $datosContenido['idSubcriterio'] = $idSubcriterio;

        switch ($tab) {

            case "acciones-preventivas":
                $Acciones = AccionesPreventivasModel::find($_GET['idAccion']);
                $datosContenido['Acciones'] = $Acciones;
                $datosContenido['lista'] = AccionesPreventivasModel::where('indicador_id', $idIndicador)
                        ->get();
                $contenido = view('evaluacion/accionesPreventivas', $datosContenido);
                break;
        }

        $datos['contenido'] = $contenido;

        return view('evaluacion/vista', $datos);
    }

    public function ingresarEvaluar() {

        try {

            $Indicador = IndicadorModel::find($_POST['idIndicador']);

            switch ($Indicador->tipo_indicador) {
                case "Cualitativo":
                    $Valoracion = ValoracionModel::find($_POST['valoracion']);

                    $porcentaje = $Valoracion->porcentaje;
                    $valor = $porcentaje * $Indicador->peso / 100;
                    $Indicador->valor = $valor;
                    $Indicador->formula = $_POST['valoracion'];
                    break;
                case "Cuantitativo":

                    $formulaOriginal = json_decode($Indicador->formula)->formula;
                    $variables = json_decode($Indicador->formula, true)['variables'];
                    $formula = $formulaOriginal;

                    foreach ($_POST['variable'] as $key => $value) {
                        $formula = str_replace($key, $value, $formula);
                        $variables[$key] = $value;
                    }
                    eval("\$resultadoFormula = $formula;");

                    $valorEstandar = $Indicador->valor_estandar;
                    if ($resultadoFormula >= $valorEstandar) {
                        $valor = $Indicador->peso;
                    } else {
                        $valor = $resultadoFormula * $Indicador->peso / $valorEstandar;
                    }

                    $Indicador->valor = $valor;

                    $formula = json_decode($Indicador->formula);

                    $formulaNueva = array(
                        'variables' => $variables,
                        'resultado' => $resultadoFormula,
                        'formula' => $formulaOriginal
                    );
                    $Indicador->formula = json_encode($formulaNueva);

                    break;
            }
            $Indicador->save();
            $this->evaluarCriterio($_POST['idIndicador']);

            $Mail = new MailClass();
            $Mail->evaluacionIndicador($Indicador->id);

            return redirect(url('/') . "/evaluacion/" . $_POST['idCriterio'] . "?sub=" . $_POST['idSubcriterio'] . "&indicador=" . $_POST['idIndicador'] . "&tab=evaluar")->with("success", "Evaluaci¨®n Actualizada con Exito");
        } catch (\Exception $ex) {
            return redirect()->back()->with("error", $ex->getMessage());
        }
    }

    public function calcularCuantitativo() {
        $Indicador = IndicadorModel::find($_GET['idIndicador']);

        $formulaOriginal = json_decode($Indicador->formula)->formula;
        $variables = json_decode($Indicador->formula, true)['variables'];
        $formula = $formulaOriginal;

        foreach ($_GET['variable'] as $key => $value) {
            $formula = str_replace($key, $value, $formula);
            $variables[$key] = $value;
        }
        eval("\$resultadoFormula = $formula;");

        $valorEstandar = $Indicador->valor_estandar;
        if ($resultadoFormula >= $valorEstandar) {
            $valor = $Indicador->peso;
        } else {
            $valor = $resultadoFormula * $Indicador->peso / $valorEstandar;
        }

        $return = array(
            'resultado' => round($resultadoFormula,2),
            'ponderado' => $valor,
        );

        echo json_encode($return);
    }

}
