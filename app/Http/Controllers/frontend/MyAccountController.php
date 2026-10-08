<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Reaction;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MyAccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = auth()->user();
        $wishlistCount = Reaction::where('user_id', $user->id)->where('type', 'wishlist')->count();
        $searchesCount = $user->searches()->count();

        return view('frontend.account.index', compact('user', 'wishlistCount', 'searchesCount'));
    }

    public function MyWishlist()
    {
        $user = auth()->user();
        $reactions = Reaction::with('property')
            ->where('user_id', $user->id)
            ->where('reference_type', 'property')
            ->where('type', 'wishlist')
            ->get();

        return view('frontend.account.wishlist', compact('reactions'));
    }

    public function SavedSearch()
    {
        $user = auth()->user();
        $searches = $user->searches()->latest()->get();

        return view('frontend.account.saved-search', compact('searches'));
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => 'required',
            'new_password' => 'required|min:6',
            'confirm_password' => 'required|same:new_password',
        ]);

        $user = auth()->user();

        if (!Hash::check($request->password, $user->password)) {
            return redirect()->back()->with('wrong', 'Current password entered is incorrect.');
        }

        $user->update([
            'password' => Hash::make($request->new_password)
        ]);

        return redirect()->back()->with('success', 'Password updated successfully.');
    }
}
