<x-layouts.app :title="__('Documentos')">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-6 gap-4">
                <h1 class="text-2xl font-bold text-gray-800 dark:text-white text-center md:text-left">
                    Gestión de Documentos
                </h1>
                <a href="{{ route('documents.create') }}" 
                   class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded transition-colors duration-200 text-center">
                    Nuevo Documento
                </a>
            </div>

            @if(session('success'))
                <div class="bg-green-100 dark:bg-green-900 border border-green-400 dark:border-green-600 text-green-700 dark:text-green-300 px-4 py-3 rounded relative mb-4 text-sm sm:text-base">
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <div class="overflow-visible bg-white dark:bg-zinc-900 shadow-md rounded-lg">

                <table class="min-w-full divide-y divide-gray-200 dark:divide-zinc-700 text-sm sm:text-base">
                    <thead class="bg-gray-50 dark:bg-zinc-800">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider whitespace-nowrap">
                                Nombre
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider whitespace-nowrap">
                                Tipo de Documento
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider whitespace-nowrap">
                                Estado
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider whitespace-nowrap">
                                Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-zinc-900 divide-y divide-gray-200 dark:divide-zinc-700">
                        @foreach($documents as $document)
                            <tr class="hover:bg-gray-50 dark:hover:bg-zinc-800 transition-colors duration-200">
                                <td class="px-4 py-4 whitespace-nowrap text-gray-900 dark:text-gray-300">
                                    {{ $document->nombre }}
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-gray-900 dark:text-gray-300">
                                    {{ $document->tipo_documento }}
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap relative">
                                    <div x-data="{ open: false }" class="relative">
                                        <button @click="open = !open" type="button"
                                            class="flex justify-between items-center w-full sm:w-40 px-4 py-2 text-sm rounded-md
                                            {{ $document->estado === 'en_proceso' 
                                                ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' 
                                                : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300' }}">
                                            <span>{{ $document->estado === 'en_proceso' ? 'En Proceso' : 'Cancelado' }}</span>
                                            <svg class="ml-2 h-4 w-4 transform transition-transform duration-200" 
                                                 :class="{ 'rotate-180': open }" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </button>

                                        <div x-show="open"
                                             x-transition:enter="transition ease-out duration-200"
                                             x-transition:enter-start="opacity-0 scale-95"
                                             x-transition:enter-end="opacity-100 scale-100"
                                             x-transition:leave="transition ease-in duration-150"
                                             x-transition:leave-start="opacity-100 scale-100"
                                             x-transition:leave-end="opacity-0 scale-95"
                                             x-cloak
                                             @click.away="open = false"
                                             class="absolute mt-2 right-0 w-40 rounded-md shadow-lg bg-white dark:bg-zinc-800 ring-1 ring-black ring-opacity-5 z-50">
                                            <div class="py-1">
                                                <form action="{{ route('documents.toggle-status', $document) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="estado" value="en_proceso">
                                                    <button type="submit" 
                                                        class="block w-full text-left px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-zinc-700
                                                        {{ $document->estado === 'en_proceso' ? 'bg-green-50 dark:bg-green-900/50' : '' }}">
                                                        En Proceso
                                                    </button>
                                                </form>

                                                <form action="{{ route('documents.toggle-status', $document) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="estado" value="cancelado">
                                                    <button type="submit" 
                                                        class="block w-full text-left px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-zinc-700
                                                        {{ $document->estado === 'cancelado' ? 'bg-red-50 dark:bg-red-900/50' : '' }}">
                                                        Cancelado
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap flex flex-col sm:flex-row gap-2 sm:gap-3 text-sm">
                                    <a href="{{ route('documents.edit', $document) }}"
                                       class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 transition-colors duration-200">
                                        Editar
                                    </a>
                                    <form action="{{ route('documents.destroy', $document) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            onclick="return confirm('¿Está seguro de eliminar este documento?')"
                                            class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 transition-colors duration-200">
                                            Eliminar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('scripts')
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        [x-cloak] { display: none !important; }
    </style>
    @endpush
</x-layouts.app>
