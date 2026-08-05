<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Auditoría: ') }} {{ $auditoria->titulo }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    @if ($errors->any())
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                            <strong class="font-bold">¡Atención! </strong>
                            <ul class="mt-1 list-disc list-inside text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('auditorias.update', $auditoria) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="titulo" class="block text-sm font-medium text-gray-700">Título de la Auditoría *</label>
                            <input type="text" name="titulo" id="titulo" value="{{ old('titulo', $auditoria->titulo) }}" required
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <div>
                            <label for="objetivo" class="block text-sm font-medium text-gray-700">Objetivo * (RN-PLAN ANUAL-01)</label>
                            <textarea name="objetivo" id="objetivo" rows="3" required
                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('objetivo', $auditoria->objetivo) }}</textarea>
                        </div>

                        <div>
                            <label for="alcance" class="block text-sm font-medium text-gray-700">Alcance * (RN-PLAN ANUAL-01)</label>
                            <textarea name="alcance" id="alcance" rows="3" required
                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('alcance', $auditoria->alcance) }}</textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Área(s) Evaluar *</label>
                            @php
                                $areasAsignadas = old('areas', $auditoria->areas->pluck('id')->toArray());
                            @endphp
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3 bg-gray-50 p-4 rounded-md border border-gray-200">
                                @foreach($areas as $area)
                                    <label class="inline-flex items-center space-x-2">
                                        <input type="checkbox" name="areas[]" value="{{ $area->id }}"
                                               {{ in_array($area->id, $areasAsignadas) ? 'checked' : '' }}
                                               class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">
                                        <span class="text-sm text-gray-700">{{ $area->nombre }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <div>
                            <label for="auditor_lider_id" class="block text-sm font-medium text-gray-700">Auditor Líder * (RN-PA-02 & RN-UR-01)</label>
                            <select name="auditor_lider_id" id="auditor_lider_id" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">-- Seleccionar Auditor Líder --</option>
                                @foreach($auditores as $auditor)
                                    <option value="{{ $auditor->id }}" {{ old('auditor_lider_id', $auditoria->auditor_lider_id) == $auditor->id ? 'selected' : '' }}>
                                        {{ $auditor->name }} ({{ ucfirst($auditor->rol) }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="fecha_inicio" class="block text-sm font-medium text-gray-700">Fecha de Inicio *</label>
                                <input type="date" name="fecha_inicio" id="fecha_inicio" value="{{ old('fecha_inicio', $auditoria->fecha_inicio) }}" required
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label for="fecha_fin" class="block text-sm font-medium text-gray-700">Fecha de Término *</label>
                                <input type="date" name="fecha_fin" id="fecha_fin" value="{{ old('fecha_fin', $auditoria->fecha_fin) }}" required
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                        </div>

                        <div>
                            <label for="estado" class="block text-sm font-medium text-gray-700">Estado de la Auditoría *</label>
                            <select name="estado" id="estado" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @foreach(['Borrador', 'Planificada', 'En Ejecución', 'En Revisión', 'Cerrada'] as $est)
                                    <option value="{{ $est }}" {{ old('estado', $auditoria->estado) == $est ? 'selected' : '' }}>
                                        {{ $est }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex justify-end space-x-3 pt-4">
                            <a href="{{ route('auditorias.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md font-semibold text-xs uppercase hover:bg-gray-300">
                                Cancelar
                            </a>
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md font-semibold text-xs uppercase hover:bg-blue-700">
                                Actualizar Auditoría
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>