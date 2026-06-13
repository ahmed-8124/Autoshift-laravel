<?php

namespace App\Http\Controllers;

use App\Models\Ad;

class UserController extends Controller
{
    public function myAds()
    {
        $ads = Ad::with('make')
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);
        return view('user.my-ads', compact('ads'));
    }

    public function markSold($id)
    {
        Ad::where('id', $id)->where('user_id', auth()->id())->update(['status' => 'sold']);
        return back()->with('success', 'Ad marked as sold!');
    }

    public function deleteAd($id)
    {
        Ad::where('id', $id)->where('user_id', auth()->id())->delete();
        return back()->with('success', 'Ad deleted.');
    }
}
