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
        $query = TrainCarriage::with('train');

        if ($request->filled('train_id')) {
            $query->where('train_id', $request->train_id);
        }

        $carriages = $query->latest()->get();
        $trains = Train::where('status', 'active')->get();

        return view('admin.carriages.index', compact('carriages', 'trains'));
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
