<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Route;
use App\Models\Station;
use Illuminate\Http\Request;

class RouteController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $query = Route::with('originStation', 'destinationStation');
            $totalRecords = $query->count();
            if ($request->filled('search.value')) {
                $searchValue = $request->input('search.value');
                $query->where(function ($q) use ($searchValue) {
                    $q->whereHas('originStation', function ($q2) use ($searchValue) {
                        $q2->where('name', 'like', '%'.$searchValue.'%')
                            ->orWhere('code', 'like', '%'.$searchValue.'%');
                    })->orWhereHas('destinationStation', function ($q2) use ($searchValue) {
                        $q2->where('name', 'like', '%'.$searchValue.'%')
                            ->orWhere('code', 'like', '%'.$searchValue.'%');
                    });
                });
            }
            $filteredRecords = $query->count();
            $query->latest();
            $start = $request->input('start', 0);
            $length = $request->input('length', 10);
            $routes = $query->skip($start)->take($length)->get();

            return response()->json([
                'draw' => intval($request->input('draw')),
                'recordsTotal' => $totalRecords,
                'recordsFiltered' => $filteredRecords,
                'data' => $routes,
            ]);
        }

        return view('admin.routes.index');
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
