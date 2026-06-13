<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ad;
use Illuminate\Http\Request;

class AdminAdController extends Controller
{
    public function index(Request $request)
    {
        $query = Ad::with(['make', 'user']);
        if ($request->filled('status')) $query->where('status', $request->status);
        $ads = $query->latest()->paginate(15)->withQueryString();
        return view('admin.ads', compact('ads'));
    }

    public function approve($id)
    {
        Ad::findOrFail($id)->update(['status' => 'active']);
        return back()->with('success', 'Ad approved and published!');
    }

    public function reject($id)
    {
        Ad::findOrFail($id)->update(['status' => 'rejected']);
        return back()->with('success', 'Ad rejected.');
    }

    public function feature($id)
    {
        $ad = Ad::findOrFail($id);
        $ad->update(['featured' => !$ad->featured]);
        $msg = $ad->fresh()->featured ? 'Ad marked as featured!' : 'Ad removed from featured.';
        return back()->with('success', $msg);
    }

    public function destroy($id)
    {
        Ad::findOrFail($id)->delete();
        return back()->with('success', 'Ad deleted.');
    }
}
