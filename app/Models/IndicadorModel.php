<?php

namespace App\Models;

/**
 * Description of IndicadorModel
 *
 * @author USUARIO
 */
use Illuminate\Database\Eloquent\Model;

class IndicadorModel extends Model {

    //put your code here
    protected $table = "indicador";

    public function criterio() {
        return $this->belongsTo(CriterioModel::class, "criterio_id");
    }

    public function subCriterio() {
        return $this->belongsTo(SubCriterioModel::class, "subcriterio_id");
    }

    public function responsableEjecucion() {
        return $this->belongsTo(ResponsableModel::class, "responsable_ejecucion");
    }

    public function responsableEvaluacion() {
        return $this->belongsTo(EvaluadorModel::class, "responsable_evaluacion");
    }

    public function cargoResponsableEjecucion() {
        return $this->belongsTo(CargoModel::class, "cargo_responsable_ejecucion");
    }

    public function cargoResponsableEvaluacion() {
        return $this->belongsTo(CargoModel::class, "cargo_responsable_evaluacion");
    }

    public function usuario() {
        return $this->belongsTo(UsuarioModel::class, "usuario_id");
    }
	

}
