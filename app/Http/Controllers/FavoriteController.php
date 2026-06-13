<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function index()
    {
        $favorites = auth()->user()->favoriteAds()->with('make')->active()->paginate(12);
        return view('user.favorites', compact('favorites'));
    }

    public function toggle($id)
    {
        $user   = auth()->user();
        $exists = Favorite::where('user_id', $user->id)->where('ad_id', $id)->first();

        if ($exists) {
            $exists->delete();
            $action = 'removed';
        } else {
            Favorite::create(['user_id' => $user->id, 'ad_id' => $id]);
            $action = 'added';
        }

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json(['action' => $action]);
        }

        $msg = $action === 'added' ? 'Ad saved to favorites!' : 'Removed from favorites.';
        return back()->with('success', $msg);
    }
}
