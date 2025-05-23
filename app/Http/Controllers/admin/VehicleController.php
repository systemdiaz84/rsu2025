<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Brandmodel;
use App\Models\Color;
use App\Models\Vehicletype;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $vehicles = DB::select('CALL sp_vehicles(1,0)');

        /*foreach ($vehicles as $vehicle) {
            $assignedcount = DB::table('vehicleocuppants')
                ->where('vehicle_id', $vehicle->id)
                ->where('status', 1)
                ->count();      

            $vehicle->assigned_users = $assignedcount;
        }*/

        if ($request->ajax()) {

            return DataTables::of($vehicles)
                ->addColumn('image', function ($vehicle) {
                    return '<img src="' . ($vehicle->imagen == '' ? asset('storage/brand_logo/no_image.png') : asset($vehicle->logo)) . '" width="100px" height="70px" class="card">';
                })
                ->addColumn('status', function ($vehicle) {
                    return $vehicle->status == 1 ? '<div style="color: green"><i class="fas fa-check"></i> Activo</div>' : '<div style="color: red"><i class="fas fa-times"></i> Inactivo</div>';
                })
                ->addColumn('edit', function ($brand) {
                    return '<button class="btn btn-success btn-sm btnEditar" id="' . $brand->id . '"><i
                                        class="fas fa-pen"></i></button>';
                })
                ->addColumn('delete', function ($brand) {
                    return '<form action="' . route('admin.brands.destroy', $brand->id) . '" method="POST"
                                    class="frmEliminar">
                                   ' . csrf_field() . method_field('DELETE') . '
                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                            </form>';
                })
                ->addColumn('ocuppants', function ($vehicle) {
                    return '<button class="btn btn-success btn-sm btnOcuppants" data-id="' . $vehicle->id . '">
                    <i class="fas fa-people-arrows"></i>&nbsp;&nbsp;(0)</button>';
                })
                ->rawColumns(['image', 'status', 'edit', 'delete', 'ocuppants'])
                ->make(true);
        } else {
            return view('admin.vehicles.index', compact('vehicles'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $brandsSQL = Brand::whereRaw("id IN (SELECT brand_id FROM brandmodels)");
        $brands = $brandsSQL->pluck("name", "id");
        $models = Brandmodel::where("brand_id", $brandsSQL->first()->id)->pluck("name", "id");
        $types = Vehicletype::pluck("name", "id");
        $colors = Color::pluck("name", "id");
        return view("admin.vehicles.create", compact("brands", "models", "types", "colors"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
