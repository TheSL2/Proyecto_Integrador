<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detalle de la Auditoría: ') }} {{ $auditoria->titulo }}
            </h2>
            <a href="{{ route('auditorias.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-md text-xs font-semibold uppercase hover:bg-gray-700">
                Volver
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-b border-gray-200">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <div>
                        <h3 class="text-xs uppercase font-semibold text-gray-500">Estado</h3>
                        <p class="mt-1 font-bold text-lg text-blue-600">{{ $auditoria->estado }}</p>
                    </div>
                    <div>
                        <h3 class="text-xs uppercase font-semibold text-gray-500">Auditor Líder</h3>
                        <p class="mt-1 text-base text-gray-800">{{ $auditoria->auditorLider->name ?? 'Sin asignar' }}</p>
                    </div>
                    <div>
                        <h3 class="text-xs uppercase font-semibold text-gray-500">Período de Ejecución</h3>
                        <p class="mt-1 text-base text-gray-800">
                            {{ \Carbon\Carbon::parse($auditoria->fecha_inicio)->format('d/m/Y') }} — 
                            {{ \Carbon\Carbon::parse($auditoria->fecha_fin)->format('d/m/Y') }}
                        </p>
                    </div>
                </div>

                <div class="border-t border-gray-200 pt-4 mb-6">
                    <h3 class="text-xs uppercase font-semibold text-gray-500 mb-2">Área(s) Evaluada(s)</h3>
                    <div class="flex flex-wrap gap-2">
                        @forelse($auditoria->areas as $area)
                            <span class="px-3 py-1 text-sm font-semibold rounded bg-blue-50 text-blue-700 border border-blue-200">
                                {{ $area->nombre }}
                            </span>
                        @empty
                            <span class="text-sm text-gray-400">Sin áreas asociadas.</span>
                        @endforelse
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 border-t border-gray-200 pt-4">
                    <div>
                        <h3 class="text-xs uppercase font-semibold text-gray-500 mb-1">Objetivo</h3>
                        <p class="text-sm text-gray-800 whitespace-pre-line">{{ $auditoria->objetivo }}</p>
                    </div>
                    <div>
                        <h3 class="text-xs uppercase font-semibold text-gray-500 mb-1">Alcance</h3>
                        <p class="text-sm text-gray-800 whitespace-pre-line">{{ $auditoria->alcance }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-b border-gray-200">
                <h3 class="text-lg font-bold text-gray-800 mb-4">
                    Checklist de Evaluación ISO/IEC 27001:2022
                </h3>

                @if($errors->any())
                    <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-4 rounded-r">
                        <ul class="list-disc pl-5 text-sm">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if(session('success'))
                    <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded-r text-sm">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('warning'))
                    <div class="bg-yellow-50 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-4 rounded-r text-sm">
                        {{ session('warning') }}
                    </div>
                @endif

                @can('ejecutar-auditoria', $auditoria)
                    <form action="{{ route('checklist.store', $auditoria) }}" method="POST" class="bg-gray-50 p-4 rounded-md border mb-6">
                        @csrf
                        <h4 class="font-semibold text-gray-700 mb-3 text-sm uppercase">Registrar / Agregar Evaluación de Requisito</h4>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Requisito / Control ISO *</label>
                                <select name="requisito_iso_id" required class="w-full border-gray-300 rounded-md shadow-sm text-sm">
                                    <option value="">-- Seleccionar Requisito --</option>
                                    @foreach($requisitosIso as $req)
                                        <option value="{{ $req->id }}">
                                            [{{ $req->categoria }}] {{ $req->codigo }} - {{ Str::limit($req->descripcion, 60) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Estado de Cumplimiento *</label>
                                <select name="estado_cumplimiento" required class="w-full border-gray-300 rounded-md shadow-sm text-sm">
                                    <option value="Conforme">Conforme</option>
                                    <option value="No Conforme Mayor">No Conforme Mayor</option>
                                    <option value="No Conforme Menor">No Conforme Menor</option>
                                    <option value="Oportunidad de Mejora">Oportunidad de Mejora</option>
                                    <option value="No Aplicable">No Aplicable</option>
                                </select>
                            </div>
                        </div>

                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Observaciones / Justificación SoA
                                <span class="text-xs text-gray-500 font-normal">(Obligatorio según RN-CHECK LIST-01 si el estado es "No Aplicable")</span>
                            </label>
                            <textarea name="observaciones" rows="2" class="w-full border-gray-300 rounded-md shadow-sm text-sm" placeholder="Ingrese las observaciones del hallazgo o la justificación técnica..."></textarea>
                        </div>

                        <div class="mt-4 text-right">
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md text-xs font-semibold uppercase hover:bg-blue-700">
                                Guardar Evaluación
                            </button>
                        </div>
                    </form>
                @endcan

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 border text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left font-semibold text-gray-600 uppercase text-xs">Código</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-600 uppercase text-xs">Requisito / Descripción</th>
                                <th class="px-4 py-3 text-center font-semibold text-gray-600 uppercase text-xs">Estado</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-600 uppercase text-xs">Observaciones</th>
                                <th class="px-4 py-3 text-right font-semibold text-gray-600 uppercase text-xs">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            @forelse($auditoria->checklistItems as $item)
                                <tr>
                                    <td class="px-4 py-3 font-bold text-gray-800 whitespace-nowrap">
                                        {{ $item->requisitoIso->codigo }}
                                    </td>
                                    <td class="px-4 py-3 text-gray-600">
                                        {{ $item->requisitoIso->descripcion }}
                                    </td>
                                    <td class="px-4 py-3 text-right whitespace-nowrap space-x-2">
                                        @if(in_array($item->estado_cumplimiento, ['No Conforme Mayor', 'No Conforme Menor']))
                                            <a href="{{ route('hallazgos.create', ['auditoria' => $auditoria->id, 'checklist' => $item->id]) }}" 
                                            class="inline-block px-2 py-1 bg-red-600 text-white font-semibold text-xs rounded hover:bg-red-700 uppercase">
                                                + Hallazgo
                                            </a>
                                        @endif

                                        @can('ejecutar-auditoria', $auditoria)
                                            <form action="{{ route('checklist.destroy', $item) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 font-semibold text-xs uppercase" onclick="return confirm('¿Deseas eliminar esta evaluación?')">
                                                    Eliminar
                                                </button>
                                            </form>
                                        @endcan
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-6 text-center text-gray-400">
                                        No se han evaluado requisitos en esta auditoría aún.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>