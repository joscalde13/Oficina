<x-layouts.app :title="__('Editar Documento')">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-2xl mx-auto">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">Editar Documento</h1>

            <form action="{{ route('documents.update', $document) }}" method="POST" class="bg-white dark:bg-zinc-900 shadow-md rounded px-8 pt-6 pb-8 mb-4">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2" for="nombre">
                        Nombre del Documento
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 dark:bg-zinc-800 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 @error('nombre') border-red-500 @enderror"
                           id="nombre"
                           type="text"
                           name="nombre"
                           value="{{ old('nombre', $document->nombre) }}"
                           required>
                    @error('nombre')
                        <p class="text-red-500 dark:text-red-400 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2" for="tipo_documento">
                        Tipo de Documento
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 dark:bg-zinc-800 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 @error('tipo_documento') border-red-500 @enderror"
                           id="tipo_documento"
                           type="text"
                           name="tipo_documento"
                           value="{{ old('tipo_documento', $document->tipo_documento) }}"
                           required>
                    @error('tipo_documento')
                        <p class="text-red-500 dark:text-red-400 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2" for="estado">
                        Estado
                    </label>
                    <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 dark:bg-zinc-800 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 @error('estado') border-red-500 @enderror"
                            id="estado"
                            name="estado"
                            required>
                        <option value="en_proceso" {{ old('estado', $document->estado) == 'en_proceso' ? 'selected' : '' }}>En Proceso</option>
                        <option value="cancelado" {{ old('estado', $document->estado) == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                    </select>
                    @error('estado')
                        <p class="text-red-500 dark:text-red-400 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between">
                    <button class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 transition-colors duration-200" type="submit">
                        Actualizar
                    </button>
                    <a href="{{ route('documents.index') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 transition-colors duration-200">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app> 