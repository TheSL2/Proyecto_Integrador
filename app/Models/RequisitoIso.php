<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RequisitoIso extends Model
{
    protected $table = 'requisitos_iso';

    protected $fillable = [
        'tipo',
        'codigo',
        'categoria',
        'titulo',
        'descripcion',
        'orientacion_implementacion'
    ];

    public function checklistItems(): HasMany
    {
        return $this->hasMany(ChecklistItem::class);
    }
}