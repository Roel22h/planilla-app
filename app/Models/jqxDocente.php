<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class jqxDocente extends Model
{
	use HasFactory;

	protected $table = 'jqxgrid_docente';

	protected $fillable = [
		'id',
		'institucion_id',
        'intitucion-descripcion',
        'dni',
        'nombres',
        'apellidos',
        'direccion',
        'telefono',
        'asignatura',
        'estado'
	];
}
