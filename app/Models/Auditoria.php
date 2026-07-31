<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Auditoria extends Model
{

    protected $fillable = [
        'titulo',
        'objetivo',
        'alcance',
        'area_id',
        'auditor_lider_id',
        'fecha_inicio',
        'fecha_fin',
        'estado'
    ];

    public function areas(): BelongsToMany
    {
        return $this->belongsToMany(Area::class, 'auditoria_areas');
    }

    public function auditorLider(): BelongsTo
    {
        return $this->belongsTo(User::class, 'auditor_lider_id');
    }

    public function checklistItems(): HasMany
    {
        return $this->hasMany(ChecklistItem::class);
    }

    public function hallazgos(): HasManyThrough
    {
        return $this->hasManyThrough(Hallazgo::class, ChecklistItem::class);
    }
}
