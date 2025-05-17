<?php

namespace App\Models;

/**
 * Description of SubCriterioModel
 *
 * @author USUARIO
 */
use Illuminate\Database\Eloquent\Model;

class SubCriterioModel extends Model {

    //put your code here

    protected $table = "subcriterio";

    public function criterio() {
        return $this->belongsTo(CriterioModel::class, "criterio_id");
    }

}
