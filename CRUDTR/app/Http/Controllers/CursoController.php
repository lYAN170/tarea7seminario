<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Curso;
use App\Models\Docente;

class CursoController extends Controller
{
    public function index()
    {
        $cursos = Curso::with('docente')->get();
        return view('cursos.index', compact('cursos'));
    }

    public function create()
    {
        $docentes = Docente::all();
        return view('cursos.create', compact('docentes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:50',
            'descripcion' => 'required|string|max:300',
            'docente_id' => 'required|exists:docentes,id', // El docente_id debe existir en la tabla 'docentes'
            'estado' => 'required|boolean',
        ]);

        Curso::create($request->all());

        return redirect()->route('cursos.index')->with('success', 'Curso creado exitosamente.');
    }

    public function show($id)
    {
        $curso = Curso::findOrFail($id);
        
        return view('cursos.show', compact('curso'));
    }

    public function edit($id)
    {
        $curso = Curso::findOrFail($id);
        
        $docentes = Docente::all();
        return view('cursos.edit', compact('curso', 'docentes'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:50',
            'descripcion' => 'required|string|max:300',
            'docente_id' => 'required|exists:docentes,id', 
            'estado' => 'required|boolean',
        ]);
        
         $curso = Curso::findOrFail($id);
        $curso->update($request->all());
        return redirect()->route('cursos.index')->with('success', 'Curso actualizado correctamente.');
    }

    public function destroy($id)
    {
        $curso = Curso::findOrFail($id);
        $curso->delete();
        return redirect()->route('cursos.index')->with('success', 'Curso eliminado exitosamente.');
    }
}
