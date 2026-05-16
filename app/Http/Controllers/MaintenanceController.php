<?php

namespace App\Http\Controllers;

use App\Models\Maintenance;
use Illuminate\Http\Request;

class MaintenanceController extends Controller
{
    public function index()
    {
        $schedules = Maintenance::orderBy('date', 'desc')->get();
        return view('pages.maintenance', compact('schedules'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'date' => 'required|date',
            'location' => 'required|string',
        ]);

        Maintenance::create([
            'title' => $request->title,
            'date' => $request->date,
            'location' => $request->location,
            'status' => 'Terjadwal',
            'description' => $request->description,
        ]);

        return redirect()->back()->with('success', 'Jadwal berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'date' => 'required|date',
            'location' => 'required|string',
            'status' => 'required|string',
        ]);

        $maintenance = Maintenance::findOrFail($id);
        $maintenance->update([
            'title' => $request->title,
            'date' => $request->date,
            'location' => $request->location,
            'status' => $request->status,
            'description' => $request->description,
        ]);

        return redirect()->back()->with('success', 'Jadwal berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $maintenance = Maintenance::findOrFail($id);
        $maintenance->delete();

        return redirect()->back()->with('success', 'Jadwal berhasil dihapus!');
    }
}
