<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\Make;
use Illuminate\Http\Request;

class AdController extends Controller
{
    public function search(Request $request)
    {
        $query = Ad::with(['make', 'user'])->active();

        if ($request->filled('type'))      $query->where('type', $request->type);
        if ($request->filled('make'))      $query->where('make_id', $request->make);
        if ($request->filled('model'))     $query->where('model', 'like', '%'.$request->model.'%');
        if ($request->filled('city'))      $query->where('city', $request->city);
        if ($request->filled('min_price')) $query->where('price', '>=', $request->min_price);
        if ($request->filled('max_price')) $query->where('price', '<=', $request->max_price);
        if ($request->filled('min_year'))  $query->where('year', '>=', $request->min_year);
        if ($request->filled('max_year'))  $query->where('year', '<=', $request->max_year);
        if ($request->filled('fuel'))      $query->where('fuel_type', $request->fuel);
        if ($request->filled('trans'))     $query->where('transmission', $request->trans);
        if ($request->filled('condition')) $query->where('condition_type', $request->condition);
        if ($request->filled('featured'))  $query->featured();

        $query->orderBy(match($request->sort) {
            'price_low'  => 'price',
            'price_high' => 'price',
            'mileage'    => 'mileage',
            default      => 'id',
        }, in_array($request->sort, ['price_high']) ? 'desc' : ($request->sort === 'oldest' ? 'asc' : 'desc'));

        $ads    = $query->paginate(12)->withQueryString();
        $makes  = Make::orderBy('name')->get();
        $cities = config('autoshift.cities');
        $years  = range(date('Y') + 1, 1990);

        return view('ads.search', compact('ads', 'makes', 'cities', 'years'));
    }

    public function show($id)
    {
        $ad = Ad::with(['make', 'user'])->where('status', 'active')->findOrFail($id);
        $ad->increment('views');

        $isFav  = auth()->check()
            ? auth()->user()->favoriteAds()->where('ad_id', $id)->exists()
            : false;

        $similar = Ad::with('make')->active()
            ->where('make_id', $ad->make_id)
            ->where('id', '!=', $id)
            ->take(4)->get();

        return view('ads.show', compact('ad', 'isFav', 'similar'));
    }

    public function create()
    {
        $makes  = Make::orderBy('name')->get();
        $cities = config('autoshift.cities');
        $years  = range(date('Y') + 1, 1990);
        return view('ads.create', compact('makes', 'cities', 'years'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type'           => 'required|in:car,bike',
            'make_id'        => 'required|exists:makes,id',
            'model'          => 'required|string|max:100',
            'year'           => 'required|integer|min:1990|max:'.( date('Y')+1),
            'price'          => 'required|numeric|min:1',
            'mileage'        => 'nullable|integer|min:0',
            'fuel_type'      => 'required|in:Petrol,Diesel,CNG,Hybrid,Electric',
            'transmission'   => 'required|in:Manual,Automatic',
            'engine_cc'      => 'nullable|integer',
            'color'          => 'nullable|string|max:50',
            'condition_type' => 'required|in:Used,New',
            'city'           => 'required|string',
            'description'    => 'nullable|string|max:2000',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['status']  = 'pending';

        Ad::create($validated);

        return redirect()->route('user.my-ads')
            ->with('success', 'Your ad has been submitted and is under review!');
    }
}
