<?php

namespace App\Http\Controllers\Production;

use App\Http\Controllers\Controller;
use App\Models\Maps\ProductionToMap;
use App\Models\Production\Production;

class ProductionsController extends Controller
{
    public function index()
    {
        $productions = Production::orderBy('name')->with('productionToMaps')->get();
        foreach ($productions as $index => $production) {
            foreach ($production['productionToMaps'] as $productionToMap) {
                if ($productionToMap['project_id'] === auth()->user()->current_project_id) {
                    $productions[$index]['production_id'] = $productionToMap['production_id'];
                    $productions[$index]['project_id'] = $productionToMap['project_id'];
                }
            }
        }

        return view('settings.admin.productions.index', compact('productions'));
    }

    public function create()
    {
        return view('settings.admin.productions.create');
    }

    public function delete(Production $production)
    {
        $productionsMap = ProductionToMap::where('production_id', $production['id'])->get();
        foreach ($productionsMap as $productionMap) {
            $productionMap->forceDelete();
        }

        $production->forceDelete();

        toastr()->error('Produktion wurde gelöscht', ' ');

        return redirect(route('settings.admin.production.index'));
    }
}
