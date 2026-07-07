<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Train;
use Illuminate\Http\Request;

class TrainController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $query = Train::withCount('carriages');
            $totalRecords = $query->count();
            if ($request->filled('search.value')) {
                $searchValue = $request->input('search.value');
                $query->where(function ($q) use ($searchValue) {
                    $q->where('code', 'like', '%'.$searchValue.'%')
                        ->orWhere('name', 'like', '%'.$searchValue.'%');
                });
            }
            $filteredRecords = $query->count();
            $query->latest();
            $start = $request->input('start', 0);
            $length = $request->input('length', 10);
            $trains = $query->skip($start)->take($length)->get();

            return response()->json([
                'draw' => intval($request->input('draw')),
                'recordsTotal' => $totalRecords,
                'recordsFiltered' => $filteredRecords,
                'data' => $trains,
            ]);
        }

        return view('admin.trains.index');
    }

    public function create()
    {
        return view('admin.trains.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'code' => 'required|string|max:50|unique:trains,code',
            'name' => 'required|string|max:100',
            'status' => 'required|in:active,inactive',
        ]);

        Train::create($data);

        return redirect()->route('admin.trains.index')->with('success', 'Train created successfully.');
    }

    public function show(Train $train)
    {
        $train->load('carriages.seats');

        return view('admin.trains.show', compact('train'));
    }

    public function edit(Train $train)
    {
        return view('admin.trains.edit', compact('train'));
    }

    public function update(Request $request, Train $train)
    {
        $data = $request->validate([
            'code' => 'required|string|max:50|unique:trains,code,'.$train->id,
            'name' => 'required|string|max:100',
            'status' => 'required|in:active,inactive',
        ]);

        $train->update($data);

        return redirect()->route('admin.trains.index')->with('success', 'Train updated successfully.');
    }

    public function destroy(Train $train)
    {
        $train->delete();

        return redirect()->route('admin.trains.index')->with('success', 'Train deleted successfully.');
    }
}
