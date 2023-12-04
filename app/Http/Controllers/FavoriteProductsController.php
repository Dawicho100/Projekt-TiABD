<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\products;
use Illuminate\Support\Facades\Auth;

class FavoriteProductsController extends Controller
{
    public function index()
    {
        $favoriteProducts = auth()->user()->favoriteProducts;

        return view('panels.panel_user.favourite_products', compact('favoriteProducts'));
    }

    public function toggleFavorite(products $product)
    {
        $user = Auth::user();

        if ($user->favoriteProducts->contains($product)) {
            $user->favoriteProducts()->detach($product);
        } else {
            $user->favoriteProducts()->attach($product);
        }

        return response()->json(['success' => true]);
    }
}
