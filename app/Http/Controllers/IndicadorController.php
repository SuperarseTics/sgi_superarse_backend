<?php

namespace App\Http\Controllers;

/**
 * Description of IndicadorController
 *
 * @author USUARIO
 */
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Models\GestorDocumentalModel;
use App\Models\ResponsableModel;
use App\Models\CargoModel;
use App\Models\IndicadorModel;
use App\Models\CriterioModel;
use App\Models\ElementosFundamentalesModel;
use App\Models\SubCriterioModel;
use App\Models\EvaluadorModel;
use App\Models\ValoracionModel;
use App\Http\Clases\MailClass;

class IndicadorController extends Controller {

    //put your code here

    private $modulo;
    private $breadcume;
    private $id;
    private $permiso;

    public function __construct() {
        $this->id = 10;
        $this->permiso = 0;

        if (!isset($_SESSION['usuarioCalidad'])) {
            \Redirect::to(url('/'))->send();
        }

        if (isset($_SESSION['permisosCalidad'][$this->id])) {
            $this->permiso = $_SESSION['permisosCalidad'][$this->id];
        }

        $this->modulo = "AdministraciÃ³n de Indicadores";
        $this->breadcume = array(
            array('url' => '', 'nombre' => $this->modulo)
        );
    }

    public function index() {
        $Configuracion = $this->getConfiguracion();

        $datos['modulo'] = $this->modulo;
        $datos['breadcume'] = $this->breadcume;
        $datos['permiso'] = $this->permiso;
        $Criterio = CriterioModel::where('estado', 1)->orderBy('nombre', 'asc')->get();
        for ($i = 0; $i < count($Criterio); $i++) {
            $sql = "select sum(peso) as 'peso' from indicador where criterio_id=" . $Criterio[$i]->id;
            $result = \DB::select($sql);
            foreach ($result as $res) {
                $Criterio[$i]->peso_utilizado = $res->peso;
            }
        }

        $datos['criterios'] = $Criterio;
        $datos['subcriterios'] = array();
        $datos['tipoIndicador'] = json_decode($Configuracion['tipo_indicador'], true);
        $datos['responsableEjecucion'] = ResponsableModel::where('estado', 1)->orderBy('nombre', 'asc')->get();
        $datos['cargos'] = CargoModel::where('estado', 1)->orderBy('nombre', 'asc')->get();
        $datos['responsableEvaluacion'] = EvaluadorModel::where('estado', 1)->orderBy('nombre', 'asc')->get();

        $Indicador = new IndicadorModel();
        $Indicador->id = 0;
        $Indicador->nombre = "";
        $Indicador->criterio_id = 0;
        $Indicador->subcriterio_id = 0;
        $Indicador->tipo_indicador = 1;
        $Indicador->responsable_ejecucion = 0;
        $Indicador->cargo_responsable_ejecucion = 0;
        $Indicador->responsable_evaluacion = 0;
        $Indicador->cargo_responsable_evaluacion = 0;
        $Indicador->elementos_fundamentales_id = 0;
        $Indicador->descripcion = "";
        $Indicador->estado = 1;
        $Indicador->peso = 1;
        $Indicador->formula = "";

        $datos['Indicador'] = $Indicador;

        if ($_SESSION['rolCalidad'] == "SuperAdministrador" || $_SESSION['rolCalidad'] == "EJECUTOR") {
            $datos['lista'] = IndicadorModel::all();
        } else {
            $datos['lista'] = IndicadorModel::where('usuario_id', $_SESSION['idUsuarioCalidad'])->get();
        }
        
        $datos['edit'] = false;

        return view('indicador/vista', $datos);
    }

    public function ingresar() {

        try {

            if ($_POST['idIndicador'] == 0) {
                $Indicador = new IndicadorModel();
                $mensaje = "Indicador Creado con Exito";
                $Indicador->usuario_id = $_SESSION['idUsuarioCalidad'];
                $Indicador->fecha_autoevaluacion = date("Y-m-d");
                $Indicador->fecha_cumplimiento = date("Y-m-d");
                $Indicador->valor = 0;
            } else {
                $Indicador = IndicadorModel::find($_POST['idIndicador']);
                $mensaje = "Indicador Actualizado con Exito";
            }
            $Indicador->nombre = $_POST['nombre'];
            $Indicador->criterio_id = $_POST['criterio'];
            $Indicador->subcriterio_id = $_POST['subcriterio'];
            $Indicador->tipo_indicador = $_POST['tipoIndicador'];
            $Indicador->responsable_ejecucion = $_POST['responsableEjecucion'];
            $Indicador->cargo_responsable_ejecucion = $_POST['cargoResponsableEjecucion'];
            $Indicador->responsable_evaluacion = $_POST['responsableEvaluacion'];
            $Indicador->cargo_responsable_evaluacion = $_POST['cargoResponsableEvaluacion'];
            $Indicador->elementos_fundamentales_id = 0;
            $Indicador->descripcion = $_POST['descripcion'];
            $Indicador->estado = $_POST['estado'];
            $Indicador->peso = $_POST['peso'];

            if ($_POST['tipoIndicador'] == "Cuantitativo") {
                $Indicador->valor_estandar = $_POST['valorEstandar'];
                $formula = $_POST['formula'];
                $pattern = '/\$[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*/';
// Buscar todas las coincidencias en la cadena
                preg_match_all($pattern, $formula, $matches);
// Obtener las variables encontradas

                foreach ($matches[0] as $ma) {
                    $variables[$ma] = 0;
                }

                $Indicador->formula = json_encode(array(
                    'variables' => $variables,
                    'resultado' => 0,
                    'formula' => $_POST['formula']
                ));
            } else {
                $Indicador->valor_estandar = 0;
                $Indicador->formula = "";
            }

            $Indicador->save();
            return redirect(url('/') . "/indicador")->with("success", $mensaje);
        } catch (\Exception $ex) {
            return redirect()->back()->with("error", $ex->getMessage());
        }
    }

    public function editar($id) {
        $Configuracion = $this->getConfiguracion();
        $Indicador = IndicadorModel::find($id);

        $fomula = json_decode($Indicador->formula);
        if ($Indicador->tipo_indicador == "Cuantitativo") {
            $Indicador->formula = $fomula->formula;
        }

        $datos['modulo'] = $this->modulo;
        $datos['breadcume'] = $this->breadcume;
        $datos['permiso'] = $this->permiso;

        $Criterio = CriterioModel::where('estado', 1)->orderBy('nombre', 'asc')->get();
        for ($i = 0; $i < count($Criterio); $i++) {
            $sql = "select sum(peso) as 'peso' from indicador where criterio_id=" . $Criterio[$i]->id;
            $result = \DB::select($sql);
            foreach ($result as $res) {
                $Criterio[$i]->peso_utilizado = $res->peso;
            }
        }

        $datos['criterios'] = $Criterio;
        $datos['subcriterios'] = SubCriterioModel::where('criterio_id', $Indicador->criterio_id)->get();

        $datos['tipoIndicador'] = json_decode($Configuracion['tipo_indicador'], true);
        $datos['responsableEjecucion'] = ResponsableModel::where('estado', 1)->orderBy('nombre', 'asc')->get();
        $datos['cargos'] = CargoModel::where('estado', 1)->orderBy('nombre', 'asc')->get();
        $datos['responsableEvaluacion'] = EvaluadorModel::where('estado', 1)->orderBy('nombre', 'asc')->get();

        $datos['Indicador'] = $Indicador;

        $datos['lista'] = IndicadorModel::all();
        $datos['edit'] = true;

        return view('indicador/vista', $datos);
    }

    public function evaluar($id) {
        try {

            $datos['modulo'] = $this->modulo;
            $datos['breadcume'] = $this->breadcume;
            $datos['permiso'] = $this->permiso;

            $Indicador = IndicadorModel::find($id);

            $datos['Indicador'] = $Indicador;
            $datosContenido['Indicador'] = $Indicador;
            switch ($Indicador->tipo_indicador) {
                case "Cualitativo":
                    $datosContenido['valoraciones'] = ValoracionModel::where('estado', 1)->orderBy('porcentaje', 'asc')->get();
                    $contenido = view('indicador/evaluarCualitativo', $datosContenido);
                    break;
                case "Cuantitativo":
                    $For = json_decode($Indicador->formula);
                    $formula = $For->formula;
                    $variables = $For->variables;
                    $resultado = $For->resultado;
                    $datosContenido['formula'] = $formula;
                    $datosContenido['variables'] = $variables;
                    $datosContenido['resultado'] = $resultado;
                    $contenido = view('indicador/evaluarCuantitativo', $datosContenido);
                    break;
            }


            $datos['contenido'] = $contenido;

            return view('indicador/evaluacion', $datos);
        } catch (\Exception $ex) {
            return redirect()->back()->with("error", $ex->getMessage());
        }
    }

    public function ingresarEvaluacion() {

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

            return redirect(url('/') . "/indicador/evaluar/" . $_POST['idIndicador'])->with("success", "EvaluaciÃ³n Actualizada con Exito");
        } catch (\Exception $ex) {
            return redirect()->back()->with("error", $ex->getMessage());
        }
    }

    public function downloadPdfZip(Request $request)
    {
        // Obtener los nombres de los archivos PDF que se deben incluir en el ZIP
        $paths = GestorDocumentalModel::where('indicador_id', $request->indicadorZIP)
            ->where('evidencia', $request->evidenciaZIP)
            ->where('url_externa', false)
            ->pluck('path_document');

        if ($paths->isEmpty()) {
            return redirect()->route('indicator.document.index', $request->indicadorZIP)
                ->with('error', 'No se encuentran los documentos para generar el comprimido.');
        }

        $pdfFiles = File::files(public_path('documentos'));

        $zip = new \ZipArchive();
        $zipFileName = 'pdfs_' . time() . '.zip';

        if ($zip->open(public_path($zipFileName), \ZipArchive::CREATE) === TRUE) {
            foreach ($pdfFiles as $file) {
                // Verifica si el archivo actual est¨¢ en la lista de $paths
                if (in_array($file->getFilename(), $paths->toArray())) {
                    $zip->addFile($file->getRealPath(), basename($file));
                }
            }
            $zip->close();
        }

        return response()->download(public_path($zipFileName))->deleteFileAfterSend(true);
    }

}
