<?php

namespace App\Http\Controllers;

use App\Models\Auditoria;
use App\Models\ChecklistItem;
use App\Models\RequisitoIso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ChecklistItemController extends Controller
{

    public function store(Request $request, Auditoria $auditoria)
    {
        Gate::authorize('ejecutar-auditoria', $auditoria);

        $request->validate([
            'requisito_iso_id' => 'required|exists:requisitos_iso,id',
            'estado_cumplimiento' => 'required|in:Conforme,No Conforme Mayor,No Conforme Menor,Oportunidad de Mejora,No Aplicable',
            'observaciones' => 'nullable|string',
        ]);

        if ($request->estado_cumplimiento === 'No Aplicable' && empty(trim($request->observaciones))) {
            return back()->withInput()->withErrors([
                'observaciones' => 'Regla RN-CHECK LIST-01: Al marcar un requisito/control como "No Aplicable", debe registrar obligatoriamente una justificación técnica basada en la Declaración de Aplicabilidad (SoA).'
            ]);
        }

        $checklistItem = $auditoria->checklistItems()->updateOrCreate(
            ['requisito_iso_id' => $request->requisito_iso_id],
            [
                'estado_cumplimiento' => $request->estado_cumplimiento,
                'observaciones' => $request->observaciones,
            ]
        );

        if (in_array($request->estado_cumplimiento, ['No Conforme Mayor', 'No Conforme Menor'])) {
            return back()->with('warning', 'Evaluación registrada correctamente. Atención (RN-CK-02): Al ser un incumplimiento, recuerde registrar el correspondiente Hallazgo en el Módulo de Hallazgos.');
        }

        return back()->with('success', 'Evaluación del checklist guardada con éxito.');
    }


    public function destroy(ChecklistItem $checklistItem)
    {
        Gate::authorize('ejecutar-auditoria', $checklistItem->auditoria);

        $checklistItem->delete();

        return back()->with('success', 'Evaluación eliminada del checklist.');
    }
}