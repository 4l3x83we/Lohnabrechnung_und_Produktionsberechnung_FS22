<?php

namespace App\Http\Controllers\Maps;

use App\Http\Controllers\Controller;
use App\Models\Maps\MapProduction;
use Illuminate\Http\Request;

class MapProductionController extends Controller
{
    public function index()
    {
        return MapProduction::all();
    }

    public function store(Request $request)
    {
        $request->validate(['map_id' => ['nullable', 'integer']]);

        return MapProduction::create($request->validated());
    }

    public function show(MapProduction $mapProduction)
    {
        return $mapProduction;
    }

    public function update(Request $request, MapProduction $mapProduction)
    {
        $request->validate(['map_id' => ['nullable', 'integer']]);

        $mapProduction->update($request->validated());

        return $mapProduction;
    }

    public function destroy(MapProduction $mapProduction)
    {
        $mapProduction->delete();

        return response()->json();
    }
}
