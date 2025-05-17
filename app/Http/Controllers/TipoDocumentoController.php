<?php

namespace App\Http\Controllers;

/**
 * Description of TipoDocumentoController
 *
 * @author USUARIO
 */
use App\Http\Controllers\Controller;
use App\Models\TipoDocumentoModel;

class TipoDocumentoController extends Controller {

    //put your code here

    private $modulo;
    private $breadcume;
    private $id;
    private $permiso;

    public function __construct() {
        $this->id = 3;
        $this->permiso = 0;

        if (!isset($_SESSION['usuarioCalidad'])) {
            \Redirect::to(url('/'))->send();
        }

        if (isset($_SESSION['permisosCalidad'][$this->id])) {
            $this->permiso = $_SESSION['permisosCalidad'][$this->id];
        }

        $this->modulo = "Administración de TipoDocumentos";
        $this->breadcume = array(
            array('url' => '', 'nombre' => $this->modulo)
        );
    }

    public function index() {

        $datos['modulo'] = $this->modulo;
        $datos['breadcume'] = $this->breadcume;
        $datos['permiso'] = $this->permiso;
        $datos['lista'] = TipoDocumentoModel::all();

        $TipoDocumento = new TipoDocumentoModel();
        $TipoDocumento->id = 0;
        $TipoDocumento->nombre = "";
        $TipoDocumento->estado = 1;
        $datos['TipoDocumento'] = $TipoDocumento;

        return view('tipoDocumento/vista', $datos);
    }

    public function ingresar() {
        try {
            if ($_POST['idTipoDocumento'] == 0) {
                $TipoDocumento = new TipoDocumentoModel();
                $mensaje = "Tipo Documento Creado con Exito";
            } else {
                $TipoDocumento = TipoDocumentoModel::find($_POST['idTipoDocumento']);
                $mensaje = "Tipo Documento Actualziado con Exito";
            }
            $TipoDocumento->nombre = $_POST['nombre'];
            $TipoDocumento->estado = $_POST['estado'];
            $TipoDocumento->save();

            return redirect(url('/') . "/tipo-documento")->with("success", $mensaje);
        } catch (\Exception $ex) {
            return redirect()->back()->with("error", $ex->getMessage());
        }
    }

    public function editar($id) {
        $TipoDocumento = TipoDocumentoModel::find($id);

        $datos['modulo'] = $this->modulo;
        $datos['permiso'] = $this->permiso;
        if ($this->permiso == 0) {
            return view('sinPermiso', $datos);
        }
        $this->breadcume[0]['url'] = url('/') . "/tipo-documento";
        $this->breadcume[] = array(
            "url" => "",
            "nombre" => $TipoDocumento->nombre
        );

        $datos['breadcume'] = $this->breadcume;

        $datos['TipoDocumento'] = $TipoDocumento;
        $datos['lista'] = TipoDocumentoModel::where('id', '<>', 0)->orderBy('nombre', 'asc')->get();

        return view('tipoDocumento/vista', $datos);
    }

}
