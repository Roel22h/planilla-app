<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Usuario extends Model
{
	use HasFactory;

	public const STATUS = [
		'ACTIVO' => true,
		'SUSPENDIDO' => false
	];

	protected $table = 'usuario';
	public $incrementing = true;
	protected $keyType = 'int';
	public $timestamps = true;

	protected $fillable = [
		'id',
		'rol_id',
		'dni',
		'nombres',
		'apellidos',
		'direccion',
		'telefono',
		'usuario',
		'contrasenia',
		'estado'
	];

	public function rol(): BelongsTo
	{
		return $this->belongsTo(Rol::class);
	}

	public function regiPlanillas(): HasMany
	{
		return $this->hasMany(RegiPlanilla::class);
	}
}
