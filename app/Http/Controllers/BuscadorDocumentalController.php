<?php

namespace App\Http\Controllers;

/**
 * Description of BuscadorDocumental
 *
 * @author USUARIO
 */
use App\Http\Controllers\Controller;
use App\Models\CriterioModel;
use App\Models\SubCriterioModel;
use App\Models\IndicadorModel;
use App\Models\TipoDocumentoModel;
use App\Models\EtapaClicloDemingModel;
use App\Models\GestorDocumentalModel;

class BuscadorDocumentalController extends Controller {

    //put your code here

    private $modulo;
    private $breadcume;
    private $id;
    private $permiso;

    public function __construct() {
        $this->id = 16;
        $this->permiso = 0;

        if (!isset($_SESSION['usuarioCalidad'])) {
            \Redirect::to(url('/'))->send();
        }

        if (isset($_SESSION['permisosCalidad'][$this->id])) {
            $this->permiso = $_SESSION['permisosCalidad'][$this->id];
        }

        $this->modulo = "Buscador Documental";
        $this->breadcume = array(
            array('url' => '', 'nombre' => $this->modulo)
        );
    }

    public function index() {

        if ($_SESSION['rolCalidad'] == "Evaluador") {
            $this->permiso = 1;
        }
        $desde = date("Y-m-d");
        if (isset($_GET['desde'])) {
            $desde = $_GET['desde'];
        }
        $hasta = date("Y-m-d");
        if (isset($_GET['hasta'])) {
            $hasta = $_GET['hasta'];
        }

        $datos['desde'] = $desde;
        $datos['hasta'] = $hasta;

        $datos['subcriterios'] = array();
        $datos['indicadores'] = array();

        $Documentos = GestorDocumentalModel::whereBetween('fecha_documento', [$desde, $hasta]);

        $idCriterio = -1;
        if (isset($_GET['criterio'])) {
            $idCriterio = $_GET['criterio'];
        }
        $datos['idCriterio'] = $idCriterio;
        if ($idCriterio != -1) {
            $Documentos = $Documentos->where('criterio_id', $idCriterio);
            $datos['subcriterios'] = SubCriterioModel::where('criterio_id', $idCriterio)->where('estado', 1)->orderBy('nombre', 'asc')->get();
        }

        $idSubCriterio = -1;
        if (isset($_GET['subcriterio'])) {
            $idSubCriterio = $_GET['subcriterio'];
        }
        $datos['idSubCriterio'] = $idSubCriterio;
        if ($idSubCriterio != -1) {
            $Documentos = $Documentos->where('subcriterio_id', $idSubCriterio);
            $datos['indicadores'] = IndicadorModel::where('criterio_id', $idCriterio)->where('subcriterio_id', $idSubCriterio)->orderBy('nombre', 'asc')->get();
        }

        $idIndicador = -1;
        if (isset($_GET['indicador'])) {
            $idIndicador = $_GET['indicador'];
        }
        $datos['idIndicador'] = $idIndicador;
        if ($idIndicador != -1) {
            $Documentos = $Documentos->where('indicador_id', $idIndicador);
        }

        $idTipoDocumento = -1;
        if (isset($_GET['tipoDocumento'])) {
            $idTipoDocumento = $_GET['tipoDocumento'];
        }
        $datos['idTipoDocumento'] = $idTipoDocumento;
        if ($idTipoDocumento != -1) {
            $Documentos = $Documentos->where('tipo_documento_id', $idTipoDocumento);
        }

        $idEtapa = -1;
        if (isset($_GET['etapaCiclo'])) {
            $idEtapa = $_GET['etapaCiclo'];
        }
        $datos['idEtapa'] = $idEtapa;
        if ($idEtapa != -1) {
            $Documentos = $Documentos->where('etapa_ciclo_deming_id', $idEtapa);
        }

        $Documentos = $Documentos->get();

        $datos['documentos'] = $Documentos;

        $datos['criterios'] = CriterioModel::where('estado', 1)->orderBy('nombre', 'asc')->get();

        $datos['tipoDocumentos'] = TipoDocumentoModel::where('estado', 1)->orderBy('nombre', 'asc')->get();
        $datos['etapaCiclo'] = EtapaClicloDemingModel::where('estado', 1)->get();
        $datos['modulo'] = $this->modulo;
        $datos['breadcume'] = $this->breadcume;
        $datos['permiso'] = $this->permiso;

        return view('buscadorDocumental/vista', $datos);
    }

}
