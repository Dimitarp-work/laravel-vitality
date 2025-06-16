<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StoreItem;
use App\Models\Banner;

class ShopController extends Controller
{
public function index()
{
    $storeItems = StoreItem::with('item')->get();
    $banners = StoreItem::with('item')
        ->where('category', 'banner')
        ->get();

    $user = auth()->user();

    return view('shop.index', compact('storeItems', 'banners', 'user'));
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

    $relation = $item->category . 's';

    if ($user->{$relation}->contains($item->item_id)) {
        return back()->with('info', 'You already own this item.');
    }

    if ($user->credits >= $item->price) {
        $user->credits -= $item->price;
        $user->{$relation}()->attach($item->item_id);
        $user->save();
    }

    return back()->with('success', 'Item purchased successfully.');
}


public function activate($type, $id)
{
    $user = auth()->user();
    $user->{'active_'.$type.'_id'} = $id;
    $user->save();

    return back();
}

}
