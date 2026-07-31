<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AccionCorrectiva extends Model
{
    protected $table = 'acciones_correctivas';

    protected $fillable = [
        'hallazgo_id',
        'causa_raiz',
        'descripcion_accion',
        'responsable_id',
        'fecha_limite',
        'estado',
        'evidencia_cierre_id'
    ];

    public function hallazgo(): BelongsTo
    {
        return $this->belongsTo(Hallazgo::class);
    }

    public function responsable(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responsable_id');
    }

    public function evidenciaCierre(): BelongsTo
    {
        return $this->belongsTo(Evidencia::class, 'evidencia_cierre_id');
    }
}