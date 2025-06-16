<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AppearanceController extends Controller
{
   public function index()
{
    $banners = Auth::user()->banners;
    return view('appearance.index', compact('banners'));
}


    public function update(Request $request)
    {
        $request->validate([
            'banner_id' => 'nullable|exists:banners,id',
        ]);

        $user = Auth::user();
        $user->banner_id = $request->input('banner_id');
        $user->save();

        return redirect()->back()->with('success', 'Banner updated successfully!');
    }

    public function reset()
{
    $user = auth()->user();
    $user->banner_id = null;
    $user->save();

    return redirect()->back()->with('success', 'Banner reset to default!');
}

}
