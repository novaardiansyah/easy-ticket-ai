<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Route;
use App\Models\Schedule;
use App\Models\Train;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index()
    {
        $schedules = Schedule::with('train', 'route.originStation', 'route.destinationStation')->latest()->get();

        return view('admin.schedules.index', compact('schedules'));
    }

    public function create()
    {
        $trains = Train::where('status', 'active')->get();
        $routes = Route::with('originStation', 'destinationStation')->get();

        return view('admin.schedules.create', compact('trains', 'routes'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'train_id' => 'required|exists:trains,id',
            'route_id' => 'required|exists:routes,id',
            'departure_time' => 'required|date',
            'arrival_time' => 'required|date|after:departure_time',
            'base_price' => 'required|numeric|min:0',
        ]);

        Schedule::create($data);

        return redirect()->route('admin.schedules.index')->with('success', 'Schedule created successfully.');
    }

    public function show(Schedule $schedule)
    {
        $schedule->load('train', 'route.originStation', 'route.destinationStation', 'stops.station');

        return view('admin.schedules.show', compact('schedule'));
    }

    public function edit(Schedule $schedule)
    {
        $trains = Train::where('status', 'active')->get();
        $routes = Route::with('originStation', 'destinationStation')->get();

        return view('admin.schedules.edit', compact('schedule', 'trains', 'routes'));
    }

    public function update(Request $request, Schedule $schedule)
    {
        $data = $request->validate([
            'train_id' => 'required|exists:trains,id',
            'route_id' => 'required|exists:routes,id',
            'departure_time' => 'required|date',
            'arrival_time' => 'required|date|after:departure_time',
            'base_price' => 'required|numeric|min:0',
        ]);

        $schedule->update($data);

        return redirect()->route('admin.schedules.index')->with('success', 'Schedule updated successfully.');
    }

    public function destroy(Schedule $schedule)
    {
        $schedule->delete();

        return redirect()->route('admin.schedules.index')->with('success', 'Schedule deleted successfully.');
    }
}
