<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Vehicletype;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class VehicletypesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $types = Vehicletype::all();

        if ($request->ajax()) {

            return DataTables::of($types)
                ->addColumn('edit', function ($type) {
                    return '<button class="btn btn-success btn-sm btnEditar" id="' . $type->id . '"><i
                                        class="fas fa-pen"></i></button>';
                })
                ->addColumn('delete', function ($type) {
                    return '<form action="' . route('admin.vehicletypes.destroy', $type->id) . '" method="POST"
                                    class="frmEliminar">
                                   ' . csrf_field() . method_field('DELETE') . '
                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                            </form>';
                })
                ->rawColumns(['edit', 'delete'])
                ->make(true);
        } else {
            return view('admin.types.index', compact('types'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.types.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {

            $request->validate([
                "name" => "unique:vehicletypes",
            ]);

            Vehicletype::create($request->all());

            return response()->json(['message' => 'tipo registrado correctamente'], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Error en el registro: ' . $th->getMessage()], 400);
        }
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
    public function edit(string $id)
    {
        $type = Vehicletype::find($id);
        return view('admin.types.edit', compact('type'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {

            $type = Vehicletype::find($id);

            $request->validate([
                "name" => "unique:brands,name," . $id,
            ]);

            $type->update($request->all());
            return response()->json(['message' => 'Tipo actualizado correctamente'], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Error en la actualiación: ' . $th->getMessage()], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $type = Vehicletype::find($id);
            $type->delete();
            return response()->json(['message' => 'Tipo eliminado correctamente'], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Error en la eliminación: ' . $th->getMessage()], 400);
        }
    }
}
