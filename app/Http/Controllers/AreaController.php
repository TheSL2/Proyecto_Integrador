<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AreaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $areas = Area::with('responsable')->get();
        return view('areas.index', compact('areas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('planificar-auditoria');

        $usuarios = User::all();
        return view('areas.create', compact('usuarios'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('planificar-auditoria');

        $request->validate([
            'nombre' => 'required|string|max:255|unique:areas,nombre',
            'codigo' => 'required|string|max:20|unique:areas,codigo',
            'descripcion' => 'nullable|string',
            'responsable_id' => 'nullable|exists:users,id',
        ]);

        Area::create($request->all());

        return redirect()->route('areas.index')
            ->with('success', 'Área creada correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Area $area)
    {
        Gate::authorize('planificar-auditoria');

        $usuarios = User::all();
        return view('areas.edit', compact('area', 'usuarios'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Area $area)
    {
        Gate::authorize('planificar-auditoria');

        $request->validate([
            'nombre' => 'required|string|max:255|unique:areas,nombre,' . $area->id,
            'codigo' => 'required|string|max:20|unique:areas,codigo,' . $area->id,
            'descripcion' => 'nullable|string',
            'responsable_id' => 'nullable|exists:users,id',
        ]);

        $area->update($request->all());

        return redirect()->route('areas.index')
            ->with('success', 'Área actualizada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Area $area)
    {
        Gate::authorize('gestionar-usuarios');

        $area->delete();

        return redirect()->route('areas.index')
            ->with('success', 'Área eliminada correctamente.');
    }
}
