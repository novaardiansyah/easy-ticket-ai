<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Station;
use Illuminate\Http\Request;

class StationController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $query = Station::query();
            $totalRecords = $query->count();
            if ($request->filled('search.value')) {
                $searchValue = $request->input('search.value');
                $query->where(function ($q) use ($searchValue) {
                    $q->where('code', 'like', '%'.$searchValue.'%')
                        ->orWhere('name', 'like', '%'.$searchValue.'%')
                        ->orWhere('city', 'like', '%'.$searchValue.'%');
                });
            }
            $filteredRecords = $query->count();
            $query->latest();
            $start = $request->input('start', 0);
            $length = $request->input('length', 10);
            $stations = $query->skip($start)->take($length)->get();

            return response()->json([
                'draw' => intval($request->input('draw')),
                'recordsTotal' => $totalRecords,
                'recordsFiltered' => $filteredRecords,
                'data' => $stations,
            ]);
        }

        return view('admin.stations.index');
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
