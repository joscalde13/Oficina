<?php

use App\Models\Document;
use Livewire\Volt\Component;

new class extends Component {
    public function with(): array
    {
        return [
            'totalDocuments' => Document::count(),
            'documentsInProcess' => Document::where('estado', 'en_proceso')->count(),
            'documentsCanceled' => Document::where('estado', 'cancelado')->count(),
            'recentDocuments' => Document::latest()->take(5)->get(),
        ];
    }
}; ?>

<div class="flex flex-col gap-4">
    <div class="grid auto-rows-min gap-4 md:grid-cols-3">
        <!-- Total de Documentos -->
        <div class="relative overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-zinc-900 p-6">
            <div class="flex flex-col gap-2">
                <h3 class="text-base font-medium text-gray-900 dark:text-gray-100">Total de Documentos</h3>
                <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $totalDocuments }}</p>
            </div>
        </div>

        <!-- Documentos en Proceso -->
        <div class="relative overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-zinc-900 p-6">
            <div class="flex flex-col gap-2">
                <h3 class="text-base font-medium text-gray-900 dark:text-gray-100">En Proceso</h3>
                <p class="text-3xl font-bold text-green-600 dark:text-green-400">{{ $documentsInProcess }}</p>
            </div>
        </div>

        <!-- Documentos Cancelados -->
        <div class="relative overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-zinc-900 p-6">
            <div class="flex flex-col gap-2">
                <h3 class="text-base font-medium text-gray-900 dark:text-gray-100">Cancelados</h3>
                <p class="text-3xl font-bold text-red-600 dark:text-red-400">{{ $documentsCanceled }}</p>
            </div>
        </div>
    </div>

    <!-- Documentos Recientes -->
    <div class="relative overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-zinc-900 p-6">
        <h3 class="mb-4 text-lg font-medium text-gray-900 dark:text-gray-100">Documentos Recientes</h3>
        @if($recentDocuments->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead>
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Nombre</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tipo</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Estado</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($recentDocuments as $document)
                            <tr>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 dark:text-gray-300">
                                    {{ $document->nombre }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 dark:text-gray-300">
                                    {{ $document->tipo_documento }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold leading-5 rounded-full
                                        {{ $document->estado === 'en_proceso' 
                                            ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' 
                                            : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300' }}">
                                        {{ $document->estado === 'en_proceso' ? 'En Proceso' : 'Cancelado' }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-500 dark:text-gray-400">No hay documentos recientes.</p>
        @endif
    </div>
</div> 