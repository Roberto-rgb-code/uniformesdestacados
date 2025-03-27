<?php

namespace App\Http\Controllers;

use App\Models\Uniforme;
use App\Models\UniformeFoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UniformeController extends Controller
{
    // Métodos para vistas web (Blade)
    public function index()
    {
        $uniformes = Uniforme::with('fotos')->get();
        return view('uniformes_list', compact('uniformes'));
    }

    public function create()
    {
        return view('uniforme_form');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'categoria' => 'required|in:Industriales,Médicos,Escolares,Corporativos',
            'tipo' => 'required|string|max:255',
            'fotos.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        $uniforme = Uniforme::create($validatedData);

        if ($request->hasFile('fotos')) {
            foreach ($request->file('fotos') as $foto) {
                $path = $foto->store('uploads', 'public');
                $uniforme->fotos()->create(['foto_path' => $path]);
            }
        }

        return redirect()->route('uniformes.index')->with('success', 'Uniforme creado exitosamente');
    }

    public function edit($id)
    {
        $uniforme = Uniforme::with('fotos')->findOrFail($id);
        return view('uniforme_form', compact('uniforme'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nombre' => 'sometimes|string|max:255',
            'descripcion' => 'sometimes|string',
            'categoria' => 'sometimes|in:Industriales,Médicos,Escolares,Corporativos',
            'tipo' => 'sometimes|string|max:255',
            'fotos.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        $uniforme = Uniforme::findOrFail($id);
        $uniforme->update($request->only(['nombre', 'descripcion', 'categoria', 'tipo']));

        if ($request->hasFile('fotos')) {
            foreach ($request->file('fotos') as $foto) {
                $path = $foto->store('uploads', 'public');
                $uniforme->fotos()->create(['foto_path' => $path]);
            }
        }

        return redirect()->route('uniformes.index')->with('success', 'Uniforme actualizado exitosamente');
    }

    public function destroy($id)
    {
        $uniforme = Uniforme::findOrFail($id);
        foreach ($uniforme->fotos as $foto) {
            Storage::disk('public')->delete($foto->foto_path);
            $foto->delete();
        }
        $uniforme->delete();

        return redirect()->route('uniformes.index')->with('success', 'Uniforme eliminado exitosamente');
    }

    public function destroyPhoto($fotoId)
    {
        $foto = UniformeFoto::findOrFail($fotoId);
        Storage::disk('public')->delete($foto->foto_path);
        $foto->delete();

        return redirect()->back()->with('success', 'Foto eliminada exitosamente');
    }

    // Métodos para API (usados por la landing page)
    public function apiIndex()
    {
        $uniformes = Uniforme::with('fotos')->get();
        return response()->json($uniformes);
    }

    public function apiShow($id)
    {
        $uniforme = Uniforme::with('fotos')->findOrFail($id);
        return response()->json($uniforme);
    }
}