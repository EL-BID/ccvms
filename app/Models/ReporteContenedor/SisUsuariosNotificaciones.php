<?php

namespace App\Models\ReporteContenedor;

use Illuminate\Database\Eloquent\Model;

class SisUsuariosNotificaciones extends Model {

	public function SisUsuario(){
		return $this->belongsTo('App\Models\ReporteContenedor\SisUsuario','sis_usuarios_id','id');
    }
}
