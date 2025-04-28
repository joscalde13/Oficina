<x-layouts.app :title="__('Documentos')">
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Gestión de Documentos</h1>
            <a href="{{ route('documents.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded transition-colors duration-200">
                Nuevo Documento
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 dark:bg-green-900 border border-green-400 dark:border-green-600 text-green-700 dark:text-green-300 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <div class="bg-white dark:bg-zinc-900 shadow-md rounded-lg overflow-visible">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-zinc-700">
                <thead class="bg-gray-50 dark:bg-zinc-800">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Nombre</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tipo de Documento</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Estado</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-zinc-900 divide-y divide-gray-200 dark:divide-zinc-700">
                    @foreach($documents as $document)
                        <tr class="hover:bg-gray-50 dark:hover:bg-zinc-800 transition-colors duration-200">
                            <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-300">{{ $document->nombre }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-300">{{ $document->tipo_documento }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="relative" x-data="{ open: false }">
                                    <div>
                                        <button @click="open = !open" type="button" 
                                                class="group inline-flex justify-between items-center w-40 px-4 py-2 text-sm rounded-md
                                                {{ $document->estado === 'en_proceso' 
                                                    ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' 
                                                    : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300' }}">
                                            <span>{{ $document->estado === 'en_proceso' ? 'En Proceso' : 'Cancelado' }}</span>
                                            <svg class="ml-2 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </div>

                                    <div x-show="open"
                                         @click.away="open = false"
                                         class="absolute z-[100] mt-1 w-40 rounded-md shadow-lg bg-white dark:bg-zinc-800 ring-1 ring-black ring-opacity-5"
                                         style="position: fixed; transform: translateY(-50%);"
                                         x-cloak>
                                        <div class="py-1">
                                            <form action="{{ route('documents.toggle-status', $document) }}" method="POST" class="block w-full">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="estado" value="en_proceso">
                                                <button type="submit" 
                                                        class="w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-zinc-700
                                                        {{ $document->estado === 'en_proceso' ? 'bg-green-50 dark:bg-green-900/50' : '' }}">
                                                    En Proceso
                                                </button>
                                            </form>
                                            <form action="{{ route('documents.toggle-status', $document) }}" method="POST" class="block w-full">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="estado" value="cancelado">
                                                <button type="submit" 
                                                        class="w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-zinc-700
                                                        {{ $document->estado === 'cancelado' ? 'bg-red-50 dark:bg-red-900/50' : '' }}">
                                                    Cancelado
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('documents.edit', $document) }}" 
                                   class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 mr-3 transition-colors duration-200">
                                    Editar
                                </a>
                                <form action="{{ route('documents.destroy', $document) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 transition-colors duration-200" 
                                            onclick="return confirm('¿Está seguro de eliminar este documento?')">
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

    @push('scripts')
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        [x-cloak] { display: none !important; }
    </style>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('dropdown', (buttonId) => ({
                open: false,
                init() {
                    this.$watch('open', (value) => {
                        if (value) {
                            const button = document.getElementById(buttonId);
                            const rect = button.getBoundingClientRect();
                            const dropdown = this.$refs.dropdown;
                            dropdown.style.top = `${rect.top}px`;
                            dropdown.style.left = `${rect.left}px`;
                        }
                    });
                }
            }));
        });
    </script>
    @endpush
</x-layouts.app> 