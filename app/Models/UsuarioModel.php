<?php

namespace App\Models;

/**
 * Description of UsuarioModel
 *
 * @author USUARIO
 */
use Illuminate\Database\Eloquent\Model;

class UsuarioModel extends Model {

    //put your code here

    protected $table = "usuario";

    public function rol() {
        return $this->belongsTo(RolModel::class, "rol_id");
    }

}
