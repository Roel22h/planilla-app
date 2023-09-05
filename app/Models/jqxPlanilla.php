<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class jqxPlanilla extends Model
{
	use HasFactory;

	protected $table = 'jqxgrid_planilla';

	protected $fillable = [
		'id',
		'docente_id',
        'dni',
        'nombres',
        'apellidos',
        'description',
        'imponible',
        'haberes',
        'liquido',
        'fecha',
        'ruta',
        'observacion',
        'estado'
	];
}
