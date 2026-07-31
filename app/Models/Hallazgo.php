<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Hallazgo extends Model
{
    protected $fillable = [
        'checklist_item_id',
        'titulo',
        'tipo',
        'descripcion',
        'fecha_notificacion',
        'estado_notificacion'
    ];

    public function evidencias(): HasMany
    {
        return $this->hasMany(Evidencia::class);
    }

    public function checklistItem(): BelongsTo
    {
        return $this->belongsTo(ChecklistItem::class);
    }

    public function accionCorrectiva(): HasOne
    {
        return $this->hasOne(AccionCorrectiva::class);
    }
}