<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $documents = Document::latest()->get();
        return view('documents.index', compact('documents'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('documents.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'tipo_documento' => 'required|string|max:255',
            'estado' => 'required|in:en_proceso,cancelado'
        ]);

        Document::create($request->all());

        return redirect()->route('documents.index')
            ->with('success', 'Documento creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Document $document)
    {
        return view('documents.edit', compact('document'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Document $document)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'tipo_documento' => 'required|string|max:255',
            'estado' => 'required|in:en_proceso,cancelado'
        ]);

        $document->update($request->all());

        return redirect()->route('documents.index')
            ->with('success', 'Documento actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Document $document)
    {
        $document->delete();

        return redirect()->route('documents.index')
            ->with('success', 'Documento eliminado exitosamente.');
    }

    public function toggleStatus(Document $document)
    {
        $newStatus = request('estado', $document->estado === 'en_proceso' ? 'cancelado' : 'en_proceso');
        $document->update(['estado' => $newStatus]);

        return redirect()->route('documents.index')
            ->with('success', 'Estado del documento actualizado exitosamente.');
    }
}
