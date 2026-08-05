<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Programa Anual de Auditorías') }}
            </h2>
            @can('planificar-auditoria')
            <a href="{{ route('auditorias.create') }}" 
               class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                + Planificar Auditoría
            </a>
            @endcan
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">TÍTULO</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">ÁREA(S) EVALUADA(S)</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">AUDITOR LÍDER</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">FECHAS</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">ESTADO</th>
                                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">ACCIONES</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($auditorias as $auditoria)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap font-bold text-gray-900 text-sm">
                                            {{ $auditoria->titulo }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex flex-wrap gap-1">
                                                @forelse($auditoria->areas as $area)
                                                    <span class="px-2 py-1 text-xs font-semibold rounded bg-blue-50 text-blue-700 border border-blue-200">
                                                        {{ $area->nombre }}
                                                    </span>
                                                @empty
                                                    <span class="text-xs text-gray-400">Sin áreas</span>
                                                @endforelse
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                            {{ $auditoria->auditorLider->name ?? 'Sin asignar' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ \Carbon\Carbon::parse($auditoria->fecha_inicio)->format('d/m/Y') }} - 
                                            {{ \Carbon\Carbon::parse($auditoria->fecha_fin)->format('d/m/Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @php
                                                $badgeClasses = match($auditoria->estado) {
                                                    'Borrador' => 'bg-gray-100 text-gray-800',
                                                    'Planificada' => 'bg-blue-100 text-blue-800',
                                                    'En Ejecución' => 'bg-yellow-100 text-yellow-800',
                                                    'En Revisión' => 'bg-purple-100 text-purple-800',
                                                    'Cerrada' => 'bg-green-100 text-green-800',
                                                    default => 'bg-gray-100 text-gray-800'
                                                };
                                            @endphp
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $badgeClasses }}">
                                                {{ $auditoria->estado }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                            <a href="{{ route('auditorias.show', $auditoria) }}" class="text-indigo-600 hover:text-indigo-900">Ver</a>
                                            @can('ejecutar-auditoria', $auditoria)
                                            <a href="{{ route('auditorias.edit', $auditoria) }}" class="text-indigo-600 hover:text-indigo-900">Editar</a>
                                            @endcan
                                            
                                            @can('gestionar-usuarios')
                                            <form action="{{ route('auditorias.destroy', $auditoria) }}" method="POST" class="inline-block" onsubmit="return confirm('¿Estás seguro de eliminar esta auditoría?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Eliminar</button>
                                            </form>
                                            @endcan
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-8 text-center text-gray-500 text-sm">
                                            No hay auditorías registradas en el Programa Anual.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>