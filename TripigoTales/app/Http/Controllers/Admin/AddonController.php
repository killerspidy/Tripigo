<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Addon;
use App\Models\Tour;
use Illuminate\Http\Request;

class AddonController extends Controller
{
    public function index()
    {
        $addons = Addon::with('tours')->latest()->get();
        return view('admin.addons.index', compact('addons'));
    }

    public function create()
    {
        $tours = Tour::orderBy('title')->get();
        return view('admin.addons.create', compact('tours'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tour_ids'    => 'nullable|array',
            'tour_ids.*' => 'exists:tours,id',
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric|min:0|max:999999.99',
            'description' => 'nullable|string',
        ]);

        $addon = Addon::create($request->only('name', 'price', 'description'));

        // Sync the many-to-many pivot
        $addon->tours()->sync($request->input('tour_ids', []));

        return redirect()->route('addons.index')->with('success', 'Add-on created successfully.');
    }

    public function edit(Addon $addon)
    {
        $tours = Tour::orderBy('title')->get();
        $selectedTourIds = $addon->tours()->pluck('tours.id')->toArray();
        return view('admin.addons.edit', compact('addon', 'tours', 'selectedTourIds'));
    }

    public function update(Request $request, Addon $addon)
    {
        $request->validate([
            'tour_ids'    => 'nullable|array',
            'tour_ids.*' => 'exists:tours,id',
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric|min:0|max:999999.99',
            'description' => 'nullable|string',
        ]);

        $addon->update($request->only('name', 'price', 'description'));

        // Sync the many-to-many pivot
        $addon->tours()->sync($request->input('tour_ids', []));

        return redirect()->route('addons.index')->with('success', 'Add-on updated successfully.');
    }

    public function destroy(Addon $addon)
    {
        $addon->tours()->detach(); // remove pivot entries
        $addon->delete();
        return redirect()->route('addons.index')->with('success', 'Add-on deleted successfully.');
    }
}
