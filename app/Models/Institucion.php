<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Institucion extends Model
{
	use HasFactory;

	public const STATUS = [
		'ACTIVO' => true,
		'SUSPENDIDO' => false
	];

	protected $table = 'institucion';
	public $incrementing = true;
	protected $keyType = 'int';
	public $timestamps = true;

	protected $fillable = [
		'id',
		'codigo',
		'descripcion',
		'niveles',
		'estado'
	];

	public function docentes(): HasMany
	{
		return $this->hasMany(Docente::class);
	}
}
