<?php

namespace App\Http\Controllers;

use App\Models\Auditoria;
use App\Models\Area;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\RequisitoIso;
use Illuminate\Support\Facades\Gate;

class AuditoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $auditorias = Auditoria::with(['areas', 'auditorLider'])->latest()->get();
        return view('auditorias.index', compact('auditorias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('planificar-auditoria');

        $areas = Area::all();
        $auditores = User::whereIn('rol', ['auditor', 'admin', 'consultor'])->get();

        return view('auditorias.create', compact('areas', 'auditores'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('planificar-auditoria');

        $request->validate([
            'titulo' => 'required|string|max:255',
            'objetivo' => 'nullable|string',
            'alcance' => 'nullable|string',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'auditor_lider_id' => 'required|exists:users,id',
            'areas' => 'required|array|min:1',
            'areas.*' => 'exists:areas,id',
            'estado' => 'required|in:Borrador,Planificada,En Ejecución,En Revisión,Cerrada',
        ]);

        $areas = Area::whereIn('id', $request->areas)->get();
        foreach ($areas as $area) {
            if ($area->responsable_id == $request->auditor_lider_id) {
                return back()->withInput()->withErrors([
                    'auditor_lider_id' => 'Regla RN-UR-01: El Auditor Líder seleccionado es el responsable del área a auditar. Debe asignar a un auditor independiente.'
                ]);
            }
        }

        $auditoria = Auditoria::create($request->only([
            'titulo', 'objetivo', 'alcance', 'fecha_inicio', 'fecha_fin', 'auditor_lider_id', 'estado'
        ]));
        $auditoria->areas()->sync($request->areas);

        return redirect()->route('auditorias.index')
            ->with('success', 'Auditoría registrada en el Programa Anual correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Auditoria $auditoria)
    {
        $auditoria->load(['areas', 'auditorLider', 'checklistItems.requisitoIso']);
    
        $requisitosIso = RequisitoIso::all();

        return view('auditorias.show', compact('auditoria', 'requisitosIso'));
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Auditoria $auditoria)
    {
        Gate::authorize('planificar-auditoria');

        $areas = Area::all();
        $auditores = User::whereIn('rol', ['auditor', 'admin', 'consultor'])->get();

        return view('auditorias.edit', compact('auditoria', 'areas', 'auditores'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Auditoria $auditoria)
    {
        Gate::authorize('planificar-auditoria');

        $request->validate([
            'titulo' => 'required|string|max:255',
            'objetivo' => 'nullable|string',
            'alcance' => 'nullable|string',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'estado' => 'required|in:Planificada,En Proceso,Finalizada,Cancelada',
            'auditor_lider_id' => 'required|exists:users,id',
            'areas' => 'required|array|min:1',
            'areas.*' => 'exists:areas,id',
            'estado' => 'required|in:Borrador,Planificada,En Ejecución,En Revisión,Cerrada',
        ]);

        $areas = Area::whereIn('id', $request->areas)->get();
            foreach ($areas as $area) {
                if ($area->responsable_id == $request->auditor_lider_id) {
                return back()->withInput()->withErrors([
                    'auditor_lider_id' => 'Regla RN-UR-01: El Auditor Líder seleccionado es el responsable del área a auditar.'
                ]);
            }
        }

        $auditoria->update($request->only([
            'titulo', 'objetivo', 'alcance', 'fecha_inicio', 'fecha_fin', 'auditor_lider_id', 'estado'
        ]));

        $auditoria->areas()->sync($request->areas);

        return redirect()->route('auditorias.index')
            ->with('success', 'Auditoría actualizada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Auditoria $auditoria)
    {
        Gate::authorize('gestionar-usuarios');

        $auditoria->delete();

        return redirect()->route('auditorias.index')
            ->with('success', 'Auditoría eliminada correctamente.');
    }
}
