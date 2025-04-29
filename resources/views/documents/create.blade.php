<x-layouts.app :title="__('Nuevo Documento')">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Crear Nuevo Documento</h1>
                <a href="{{ route('documents.index') }}" 
                   class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded transition-colors duration-200">
                    Volver
                </a>
            </div>

            <form action="{{ route('documents.store') }}" method="POST" class="bg-white dark:bg-zinc-900 shadow-md rounded-lg px-8 sm:px-12 pt-6 pb-8 mb-4 space-y-6">
                @csrf

                <div class="space-y-2">
                    <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold" for="nombre">
                        Nombre del Documento
                    </label>
                    <input class="w-full h-12 rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-zinc-800 dark:text-gray-300 focus:border-blue-500 dark:focus:border-blue-400 focus:ring focus:ring-blue-200 dark:focus:ring-blue-800 focus:ring-opacity-50 transition-colors duration-200 @error('nombre') border-red-500 @enderror"
                           id="nombre"
                           type="text"
                           name="nombre"
                           value="{{ old('nombre') }}"
                           placeholder="  Ingrese el nombre del documento"
                           required>
                    @error('nombre')
                        <p class="text-red-500 dark:text-red-400 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-2">
                    <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold" for="tipo_documento">
                        Tipo de Documento
                    </label>
                    <input class="w-full h-12 rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-zinc-800 dark:text-gray-300 focus:border-blue-500 dark:focus:border-blue-400 focus:ring focus:ring-blue-200 dark:focus:ring-blue-800 focus:ring-opacity-50 transition-colors duration-200 @error('tipo_documento') border-red-500 @enderror"
                           id="tipo_documento"
                           type="text"
                           name="tipo_documento"
                           value="{{ old('tipo_documento') }}"
                           placeholder="  Ingrese el tipo de documento"
                           required>
                    @error('tipo_documento')
                        <p class="text-red-500 dark:text-red-400 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-2">
                    <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold" for="estado">
                        Estado
                    </label>
                    <select class="w-full h-12 rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-zinc-800 dark:text-gray-300 focus:border-blue-500 dark:focus:border-blue-400 focus:ring focus:ring-blue-200 dark:focus:ring-blue-800 focus:ring-opacity-50 transition-colors duration-200 @error('estado') border-red-500 @enderror"
                            id="estado"
                            name="estado"
                            required>
                        <option value="">  Seleccione un estado</option>
                        <option value="en_proceso" {{ old('estado') == 'en_proceso' ? 'selected' : '' }}>En Proceso</option>
                        <option value="cancelado" {{ old('estado') == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                    </select>
                    @error('estado')
                        <p class="text-red-500 dark:text-red-400 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-end space-x-4">
                    <a href="{{ route('documents.index') }}" 
                       class="text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 transition-colors duration-200">
                        Cancelar
                    </a>
                    <button type="submit" 
                            class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 transition-colors duration-200">
                        Guardar Documento
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app> 