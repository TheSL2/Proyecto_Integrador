<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ChecklistItem extends Model
{
    protected $table = 'checklist_items';

    protected $fillable = [
        'auditoria_id',
        'requisito_iso_id',
        'estado_cumplimiento',
        'observaciones'
    ];

    public function auditoria(): BelongsTo
    {
        return $this->belongsTo(Auditoria::class);
    }

    public function requisitoIso(): BelongsTo
    {
        return $this->belongsTo(RequisitoIso::class);
    }

    public function evidencias(): HasMany
    {
        return $this->hasMany(Evidencia::class);
    }

    public function hallazgo(): HasOne
    {
        return $this->hasOne(Hallazgo::class);
    }
}