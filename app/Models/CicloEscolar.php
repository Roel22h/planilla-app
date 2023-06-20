<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CicloEscolar extends Model
{
	use HasFactory;

	public const STATUS = [
		'ACTIVO' => true,
		'SUSPENDIDO' => false
	];

	protected $table = 'ciclo_escolar';
	public $incrementing = true;
	protected $keyType = 'int';
	public $timestamps = true;

	protected $fillable = [
		'id',
		'description',
		'inicio',
		'fin',
		'estado'
	];

	public function regiPlanillas(): HasMany
	{
		return $this->hasMany(RegiPlanilla::class);
	}
}
