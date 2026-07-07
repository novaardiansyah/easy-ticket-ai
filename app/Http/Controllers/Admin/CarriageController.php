<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Train;
use App\Models\TrainCarriage;
use Illuminate\Http\Request;

class CarriageController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $query = TrainCarriage::with('train');
            if ($request->filled('train_id')) {
                $query->where('train_id', $request->train_id);
            }
            $totalRecords = $query->count();
            if ($request->filled('search.value')) {
                $searchValue = $request->input('search.value');
                $query->where(function ($q) use ($searchValue) {
                    $q->where('name', 'like', '%'.$searchValue.'%')
                        ->orWhereHas('train', function ($q2) use ($searchValue) {
                            $q2->where('name', 'like', '%'.$searchValue.'%')
                                ->orWhere('code', 'like', '%'.$searchValue.'%');
                        });
                });
            }
            $filteredRecords = $query->count();
            $query->latest();
            $start = $request->input('start', 0);
            $length = $request->input('length', 10);
            $carriages = $query->skip($start)->take($length)->get();

            return response()->json([
                'draw' => intval($request->input('draw')),
                'recordsTotal' => $totalRecords,
                'recordsFiltered' => $filteredRecords,
                'data' => $carriages,
            ]);
        }
        $trains = Train::where('status', 'active')->get();

        return view('admin.carriages.index', compact('trains'));
    }

    public function create()
    {
        $trains = Train::where('status', 'active')->get();

        return view('admin.carriages.create', compact('trains'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'train_id' => 'required|exists:trains,id',
            'class' => 'required|in:economy,business,executive,luxury',
            'name' => 'required|string|max:50',
            'capacity' => 'required|integer|min:1|max:100',
        ]);

        TrainCarriage::create($data);

        return redirect()->route('admin.carriages.index')->with('success', 'Carriage created successfully.');
    }

    public function edit(TrainCarriage $carriage)
    {
        $trains = Train::where('status', 'active')->get();

        return view('admin.carriages.edit', compact('carriage', 'trains'));
    }

    public function update(Request $request, TrainCarriage $carriage)
    {
        $data = $request->validate([
            'train_id' => 'required|exists:trains,id',
            'class' => 'required|in:economy,business,executive,luxury',
            'name' => 'required|string|max:50',
            'capacity' => 'required|integer|min:1|max:100',
        ]);

        $carriage->update($data);

        return redirect()->route('admin.carriages.index')->with('success', 'Carriage updated successfully.');
    }

    public function destroy(TrainCarriage $carriage)
    {
        $carriage->delete();

        return redirect()->route('admin.carriages.index')->with('success', 'Carriage deleted successfully.');
    }
}
