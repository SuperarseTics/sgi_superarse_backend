<?php

namespace App\Http\Controllers;

/**
 * Description of GestorDocumentalController
 *
 * @author USUARIO
 */
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\AcademicPeriod;
use App\Models\IndicadorModel;
use App\Models\TipoDocumentoModel;
use App\Http\Controllers\Controller;
use App\Helpers\AcademicPeriodHelper;
use App\Models\GestorDocumentalModel;
use App\Models\EtapaClicloDemingModel;

class GestorDocumentalController extends Controller {
    private $modulo;
    private $breadcume;
    private $id;
    private $permiso;

    public function __construct() {
        $this->id = 13;
        $this->permiso = 0;

        if (!isset($_SESSION['usuarioCalidad'])) {
            \Redirect::to(url('/'))->send();
        }

        if (isset($_SESSION['permisosCalidad'][$this->id])) {
            $this->permiso = $_SESSION['permisosCalidad'][$this->id];
        }

        $this->modulo = "Gestor Documental";
        $this->breadcume = array(
            array('url' => '', 'nombre' => $this->modulo)
        );
    }

    public function index($id) {
        $datos['modulo'] = $this->modulo;
        $datos['breadcume'] = $this->breadcume;
        $datos['permiso'] = $this->permiso;

        $Indicador = IndicadorModel::find($id);

        $datos['Indicador'] = $Indicador;

        // Generate periods list
        $periods = AcademicPeriod::orderBy('start_year')
        ->orderBy('start_month')
        ->orderBy('end_year')
        ->orderBy('end_month')
        ->where('enabled', true)
        ->get();

        $datos['periodosAcademicos'] = $periods->map(function ($periodData){
            return [
                'id' => $periodData->id,
                'name' => AcademicPeriodHelper::formatName($periodData)
            ];
        });

        $datos['tipoDocumentos'] = TipoDocumentoModel::where('estado', 1)->orderBy('nombre', 'asc')->get();
        $datos['etapaCiclo'] = EtapaClicloDemingModel::where('estado', 1)->orderBy('nombre', 'asc')->get();

        // Generate documents list
        $documents = GestorDocumentalModel::where('indicador_id', $Indicador->id)
        ->get();

        $groupedDocuments = $documents->groupBy(function ($item) {
            return $item->evidencia ?? 'Sin evidencia';
        })->map(function ($group) {
            return $group->groupBy(function ($item) {
                return AcademicPeriodHelper::formatName($item->academic_period) ?? 'Sin período académico';
            })->map(function ($periodGroup) {
                // Ordenar por fecha_documento antes de mapear los datos
                return $periodGroup->sortByDesc('fecha_documento')->map(function ($documentData) {
                    return [
                        'nombre' => $documentData->nombre,
                        'fecha_documento' => $documentData->fecha_documento ?? '-',
                        'tipo_documento' => $documentData->tipoDocumento->nombre,
                        'version' => $documentData->version,
                        'ciclo' => $documentData->ciclo->nombre,
                        'resolucion_ocs' => $documentData->resolucion_ocs,
                        'url_externa' => $documentData->url_externa,
                        'path' => $documentData->url_externa == 1 ? $documentData->path : $documentData->path_document,
                        'id' => $documentData->id
                    ];
                });
            });
        });

        // Ordenar las evidencias, colocando 'Sin evidencia' al final
        $sortedGroupedDocuments = $groupedDocuments->sortKeys()->toArray();
        if (isset($sortedGroupedDocuments['Sin evidencia'])) {
            $sinEvidencia = $sortedGroupedDocuments['Sin evidencia'];
            unset($sortedGroupedDocuments['Sin evidencia']);
            $sortedGroupedDocuments['Sin evidencia'] = $sinEvidencia;
        }

        $datos['lista'] = $sortedGroupedDocuments;

        return view('gestorDocumental/vista', $datos);
    }

    /**
     * Show specific document information
     * @param string $indicatorId
     * @param int $documentId
     */
    public function show (string $indicatorId, int $documentId)
    {
        $data['document'] = GestorDocumentalModel::find($documentId)->toArray();
        if (empty($data['document'])) {
            return redirect()->route('indicator.document.index', [$indicatorId])
            ->with('error', 'No existe el documento.');
        }

        // Generate periods list
        $periods = AcademicPeriod::orderBy('start_year')
        ->orderBy('start_month')
        ->orderBy('end_year')
        ->orderBy('end_month')
        ->where('enabled', true)
        ->get();

        $data['academicPeriods'] = $periods->map(function ($periodData){
            return [
                'id' => $periodData->id,
                'name' => AcademicPeriodHelper::formatName($periodData)
            ];
        });

        $data['typeDocuments'] = TipoDocumentoModel::where('estado', 1)->orderBy('nombre', 'asc')->get();
        $data['cycles'] = EtapaClicloDemingModel::where('estado', 1)->orderBy('nombre', 'asc')->get();
        $data['indicatorId'] = $indicatorId;
        $data['modulo'] = $this->modulo;
        $data['breadcume'] = $this->breadcume;
        $data['permiso'] = $this->permiso;

        return view('gestorDocumental/edit', $data);
    }

    public function ingresar() {
        try {
            $Gestor = new GestorDocumentalModel();
            $Gestor->criterio_id = $_POST['idCriterio'];
            $Gestor->subcriterio_id = $_POST['idSubCriterio'];
            $Gestor->indicador_id = $_POST['idIndicador'];
            $Gestor->tipo_documento_id = $_POST['tipoDocumento'];
            $Gestor->fecha_documento = $_POST['date_document'];
            $Gestor->periodo_academico_id = $_POST['academic_period'];
            $Gestor->evidencia = $_POST['evidencia'];
            $Gestor->nombre = $_POST['nombre'];
            $Gestor->version = $_POST['version'];
            $Gestor->etapa_ciclo_deming_id = $_POST['etapaCiclo'];
            $Gestor->resolucion_ocs = $_POST['resolucion'];
            $Gestor->url_externa = $_POST['urlExterno'];

            if ($_POST['urlExterno'] == 1) {
                $Gestor->path = $_POST['pathExterno'];
            } else {
                $tipo = explode("/", $_FILES['documento']['type']);
                $nombre = $this->getSlug($_POST['nombre']) . "_" . $_POST['version'] . "_" . time() . "." . $tipo[count($tipo) - 1];
                @copy($_FILES['documento']['tmp_name'], base_path() . "/public/documentos/" . $nombre);
                $Gestor->path_document = $nombre;
            }

            $Gestor->save();

            return redirect(url('/') . "/indicador/gestor-documental/" . $_POST['idIndicador'])->with("success", "Documento subido con Exito");
        } catch (\Exception $ex) {
            return redirect()->back()->with("error", $ex->getMessage());
        }
    }

    public function update (int $documentId, Request $request) {
        // dd($request);
        $document = GestorDocumentalModel::find($documentId);
        $document->nombre = $request->documentName;
        $document->fecha_documento = $request->documentDate;
        $document->periodo_academico_id = $request->academicPeriod;
        $document->tipo_documento_id = $request->typeDocument;
        $document->etapa_ciclo_deming_id = $request->cycleDeming;
        $document->version = $request->version;
        $document->resolucion_ocs = $request->resolution;
        $document->evidencia = $request->evidency;
        $document->url_externa = $request->typeDocumentOrigin;

        if ($request->typeDocumentOrigin == 1) {
            $document->path = $request->path;
            $document->path_document = null;
        } else {
            if ($request->hasFile('document')) {
                $file = $request->file('document');
                $fileName = $file->getClientOriginalName() . "_" . $request->version . "_" . Carbon::now()->toDateTimeString() . "." . $file->getClientOriginalExtension();
                if ($fileName != $document->path_document) {
                    $file->move(public_path('documentos'), $fileName);
                    $document->path_document = $fileName;
                }
            }

            $document->path = null;
        }

        $document->save();

        return redirect()->route('indicator.document.index', $document->indicador_id)
        ->with('success', 'El documento ha sido actualizado con éxito.');
    }

    public function eliminar($id) {
        try {
            $Gestor = GestorDocumentalModel::find($id);
            $idIndicador = $Gestor->indicador_id;
            if ($Gestor->url_externa == 0) {
                @unlink(base_path() . "/public/documentos/" . $Gestor->path);
            }
            $sql = "delete from gestor_documental where id=" . $Gestor->id;
            \DB::select($sql);

            return redirect(url('/') . "/indicador/gestor-documental/" . $idIndicador)->with("success", "Documento Eliminado con Exito");
        } catch (\Exception $ex) {
            return redirect()->back()->with("error", $ex->getMessage());
        }
    }

}
