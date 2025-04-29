<x-layouts.app :title="__('Documentos')">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-6xl mx-auto">
            <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-6 gap-4">
                <h1 class="text-xl md:text-2xl font-bold text-gray-800 dark:text-white text-center md:text-left">
                    Gestión de Documentos
                </h1>
                <a href="{{ route('documents.create') }}" 
                   class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-3 md:px-6 rounded transition-colors duration-200 text-center text-sm md:text-base">
                    Nuevo Documento
                </a>
            </div>

            @if(session('success'))
                <div class="bg-green-100 dark:bg-green-900 border border-green-400 dark:border-green-600 text-green-700 dark:text-green-300 px-4 py-3 rounded relative mb-4 text-xs md:text-sm">
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white dark:bg-zinc-900 shadow-md rounded-lg">
                <table class="w-full divide-y divide-gray-200 dark:divide-zinc-700 text-xs md:text-sm">
                    <thead class="bg-gray-50 dark:bg-zinc-800">
                        <tr>
                            <th class="px-2 md:px-4 py-2 text-left font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Nombre
                            </th>
                            <th class="px-2 md:px-4 py-2 text-left font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Tipo de Documento
                            </th>
                            <th class="px-2 md:px-4 py-2 text-left font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Estado
                            </th>
                            <th class="px-2 md:px-4 py-2 text-left font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-zinc-900 divide-y divide-gray-200 dark:divide-zinc-700">
                        @foreach($documents as $document)
                            <tr class="hover:bg-gray-50 dark:hover:bg-zinc-800 transition-colors duration-200">
                                <td class="px-2 md:px-4 py-3 text-gray-900 dark:text-gray-300 whitespace-normal">
                                    {{ $document->nombre }}
                                </td>
                                <td class="px-2 md:px-4 py-3 text-gray-900 dark:text-gray-300 whitespace-normal">
                                    {{ $document->tipo_documento }}
                                </td>
                                <td class="px-2 md:px-4 py-3">
                                    <div class="flex items-center justify-start">
                                        <span class="px-2 inline-flex text-xs md:text-sm leading-5 font-semibold rounded-full
                                            {{ $document->estado === 'en_proceso' 
                                                ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300'
                                                : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300' }}">
                                            {{ $document->estado === 'en_proceso' ? 'En Proceso' : 'Cancelado' }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-2 md:px-4 py-3 flex flex-col sm:flex-row gap-2 text-xs md:text-sm">
                                    <a href="{{ route('documents.edit', $document) }}"
                                       class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">
                                        Editar
                                    </a>
                                    <form action="{{ route('documents.destroy', $document) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            onclick="return confirm('¿Está seguro de eliminar este documento?')"
                                            class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
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
    @endpush
</x-layouts.app>
