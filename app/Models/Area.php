<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Area extends Model
{
    protected $fillable = [
        'nombre',
        'codigo',
        'descripcion',
        'responsable_id'
        ];

    public function responsable(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responsable_id');
    }

    public function auditorias(): BelongsToMany
    {
        return $this->belongsToMany(Auditoria::class, 'auditoria_areas');
    }
}