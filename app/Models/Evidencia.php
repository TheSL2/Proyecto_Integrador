<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Evidencia extends Model
{
    protected $fillable = [
        'checklist_item_id',
        'hallazgo_id',
        'nombre_archivo',
        'ruta_almacenamiento',
        'hash_sha256',
        'subido_por'
    ];

    public function hallazgo(): BelongsTo
    {
       return $this->belongsTo(Hallazgo::class);
    }

    public function checklistItem(): BelongsTo
    {
        return $this->belongsTo(ChecklistItem::class);
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'subido_por');
    }
}