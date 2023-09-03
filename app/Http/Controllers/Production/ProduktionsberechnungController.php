<?php

namespace App\Http\Controllers\Production;

use App\Http\Controllers\Controller;

class ProduktionsberechnungController extends Controller
{
    public function index()
    {
        return view('projects.produktionsberechnung.production');
    }
}
