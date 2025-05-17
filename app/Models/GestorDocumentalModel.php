<?php

namespace App\Models;

/**
 * Description of GestorDocumentalModel
 *
 * @author USUARIO
 */
use Illuminate\Database\Eloquent\Model;

class GestorDocumentalModel extends Model {

    //put your code here

    protected $table = "gestor_documental";

    public function indicador() {
        return $this->belongsTo(IndicadorModel::class, "indicador_id");
    }

    public function subcriterio() {
        return $this->belongsTo(SubCriterioModel::class, "subcriterio_id");
    }

    public function criterio() {
        return $this->belongsTo(CriterioModel::class, "criterio_id");
    }

    public function ciclo() {
        return $this->belongsTo(EtapaClicloDemingModel::class, "etapa_ciclo_deming_id");
    }

    public function tipoDocumento() {
        return $this->belongsTo(TipoDocumentoModel::class, "tipo_documento_id");
    }

    public function academic_period () {
        return $this->belongsTo(AcademicPeriod::class, 'periodo_academico_id');
    }

}
