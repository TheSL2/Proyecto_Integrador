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

        </div>
    </div>
</x-app-layout>