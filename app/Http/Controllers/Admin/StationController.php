<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Station;
use Illuminate\Http\Request;

class StationController extends Controller
{
    public function index()
    {
        $stations = Station::latest()->get();

        return view('admin.stations.index', compact('stations'));
    }

    public function create()
    {
        return view('admin.stations.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'code' => 'required|string|max:10|unique:stations,code',
            'name' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'address' => 'nullable|string',
        ]);

        Station::create($data);

        return redirect()->route('admin.stations.index')->with('success', 'Station created successfully.');
    }

    public function show(Station $station)
    {
        return view('admin.stations.show', compact('station'));
    }

    public function edit(Station $station)
    {
        return view('admin.stations.edit', compact('station'));
    }

    public function update(Request $request, Station $station)
    {
        $data = $request->validate([
            'code' => 'required|string|max:10|unique:stations,code,'.$station->id,
            'name' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'address' => 'nullable|string',
        ]);

        $station->update($data);

        return redirect()->route('admin.stations.index')->with('success', 'Station updated successfully.');
    }

    public function destroy(Station $station)
    {
        $station->delete();

        return redirect()->route('admin.stations.index')->with('success', 'Station deleted successfully.');
    }
}
