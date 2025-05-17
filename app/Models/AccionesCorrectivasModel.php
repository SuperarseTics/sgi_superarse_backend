<?php

namespace App\Models;

/**
 * Description of AccionesCorrectivasModel
 *
 * @author USUARIO
 */
use Illuminate\Database\Eloquent\Model;

class AccionesCorrectivasModel extends Model {

    //put your code here

    protected $table = "acciones_correctivas_indicador";

    public function indicador() {
        return $this->belongsTo(IndicadorModel::class, "indicador_id");
    }

}
