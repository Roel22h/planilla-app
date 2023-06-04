<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Docente extends Model
{
	use HasFactory;

	public const STATUS = [
		'ACTIVO' => true,
		'SUSPENDIDO' => false
	];

	protected $table = 'docente';
	public $incrementing = true;
	protected $keyType = 'int';
	public $timestamps = true;

	protected $fillable = [
		'id',
		'institucion_id',
		'dni',
		'nombres',
		'apellidos',
		'direccion',
		'telefono',
		'asignatura',
		'estado'
	];

	public function institucion(): BelongsTo
	{
		return $this->belongsTo(Institucion::class);
	}

	public function pagos(): HasMany
	{
		return $this->hasMany(Pago::class);
	}

	public function regiPlanillas(): HasMany
	{
		return $this->hasMany(RegiPlanilla::class);
	}
}
