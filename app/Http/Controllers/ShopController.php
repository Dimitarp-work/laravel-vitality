<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StoreItem;

class ShopController extends Controller
{
    public function index()
    {
        $storeItems = StoreItem::with('item')->get();
        $user = auth()->user();

        return view('shop.index', compact('storeItems', 'user'));
    }

    public function setBadge($badgeId)
    {
        $user = auth()->user();
        if ($user->badges->contains($badgeId)) {
            $user->active_badge_id = $badgeId;
            $user->save();
        }

        return redirect()->back();
    }

    public function removeBadge()
    {
        $user = auth()->user();
        $user->active_badge_id = null;
        $user->save();

        return redirect()->back();
    }
    public function purchase($id)
{
    $item = StoreItem::findOrFail($id);
    $user = auth()->user();

    if ($user->credits >= $item->price) {
        $user->credits -= $item->price;
        $user->{$item->category . 's'}()->attach($item->item_id);
        $user->save();
    }

    return back();
}

public function activate($type, $id)
{
    $user = auth()->user();
    $user->{'active_'.$type.'_id'} = $id;
    $user->save();

    return back();
}

}
