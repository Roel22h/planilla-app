<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pago extends Model
{
	use HasFactory;

	public const STATUS = [
		'ACTIVO' => true,
		'SUSPENDIDO' => false
	];

	protected $table = 'pago';
	public $incrementing = true;
	protected $keyType = 'int';
	public $timestamps = true;

	protected $fillable = [
		'id',
		'usuario_id',
		'docente_id',
		'ciclo_escolar_id',
		'monto',
		'observacion',
		'fecha',
		'estado'
	];

	public function usuario(): BelongsTo
	{
		return $this->belongsTo(Usuario::class);
	}

	public function docente(): BelongsTo
	{
		return $this->belongsTo(Docente::class);
	}

	public function cicloEscolar(): BelongsTo
	{
		return $this->belongsTo(CicloEscolar::class);
	}
}
