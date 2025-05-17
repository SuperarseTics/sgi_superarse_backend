<?php

namespace App\Models;

/**
 * Description of CriterioModel
 *
 * @author USUARIO
 */
use Illuminate\Database\Eloquent\Model;

class CriterioModel extends Model {

    //put your code here

    protected $table = "criterio";

    public function indicadores() {
        return $this->hasMany(IndicadorModel::class, "criterio_id");
    }

}
