<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Make;
use Illuminate\Http\Request;

class AdminMakeController extends Controller
{
    public function index()
    {
        $makes = Make::withCount('ads')->orderBy('name')->get();
        return view('admin.makes', compact('makes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:makes',
            'type' => 'required|in:car,bike,both',
        ]);
        Make::create($request->only('name', 'type'));
        return back()->with('success', 'Make added!');
    }

    public function destroy($id)
    {
        $make = Make::withCount('ads')->findOrFail($id);
        if ($make->ads_count > 0) {
            return back()->with('error', 'Cannot delete — this make has ads.');
        }
        $make->delete();
        return back()->with('success', 'Make deleted.');
    }
}
