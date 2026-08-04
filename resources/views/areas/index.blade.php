<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Gestión de Áreas y Procesos') }}
            </h2>
            @can('planificar-auditoria')
                <a href="{{ route('areas.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-sm">
                    + Nueva Área
                </a>
            @endcan
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Código</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre del Área</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Descripción</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Responsable</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($areas as $area)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap font-bold text-indigo-600">{{ $area->codigo }}</td>
                                <td class="px-6 py-4 whitespace-nowrap font-semibold text-gray-900">{{ $area->nombre }}</td>
                                <td class="px-6 py-4 text-gray-500">{{ $area->descripcion ?? 'Sin descripción' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-500">
                                    {{ $area->responsable->name ?? 'Sin asignar' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    @can('planificar-auditoria')
                                        <a href="{{ route('areas.edit', $area) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Editar</a>
                                    @endcan
                                    
                                    @can('gestionar-usuarios')
                                        <form action="{{ route('areas.destroy', $area) }}" method="POST" class="inline" onsubmit="return confirm('¿Seguro que deseas eliminar esta área?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">Eliminar</button>
                                        </form>
                                    @endcan
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500">No hay áreas registradas aún.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>