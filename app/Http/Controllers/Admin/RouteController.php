<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Route;
use App\Models\Station;
use Illuminate\Http\Request;

class RouteController extends Controller
{
    public function index()
    {
        $routes = Route::with('originStation', 'destinationStation')->latest()->get();

        return view('admin.routes.index', compact('routes'));
    }

    public function create()
    {
        $stations = Station::all();

        return view('admin.routes.create', compact('stations'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'origin_station_id' => 'required|exists:stations,id',
            'destination_station_id' => 'required|exists:stations,id|different:origin_station_id',
            'distance_km' => 'nullable|numeric|min:0',
            'estimated_duration' => 'nullable|integer|min:1',
        ]);

        Route::create($data);

        return redirect()->route('admin.routes.index')->with('success', 'Route created successfully.');
    }

    public function edit(Route $route)
    {
        $stations = Station::all();

        return view('admin.routes.edit', compact('route', 'stations'));
    }

    public function update(Request $request, Route $route)
    {
        $data = $request->validate([
            'origin_station_id' => 'required|exists:stations,id',
            'destination_station_id' => 'required|exists:stations,id|different:origin_station_id',
            'distance_km' => 'nullable|numeric|min:0',
            'estimated_duration' => 'nullable|integer|min:1',
        ]);

        $route->update($data);

        return redirect()->route('admin.routes.index')->with('success', 'Route updated successfully.');
    }

    public function destroy(Route $route)
    {
        $route->delete();

        return redirect()->route('admin.routes.index')->with('success', 'Route deleted successfully.');
    }
}
