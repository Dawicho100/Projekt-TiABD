<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Http\Request;
use App\Models\products;
use App\Models\Dostawa;
use App\Models\Platnosci;
class CartController extends Controller
{
    public function showCart(Request $request)
    {
        // Pobierz aktualny koszyk z ciasteczka
        $cart = $request->cookie('cart', []);

        // Sprawdź, czy $cart jest stringiem i przekonwertuj go na tablicę
        if (is_string($cart)) {
            $cart = json_decode($cart, true);
        }

        // Sprawdź, czy $cart jest tablicą
        if (!is_array($cart)) {
            $cart = [];
        }

        // Oblicz sumę cen produktów w koszyku
        $totalPrice = 0;
        //dd($cart);
        // Przechodź przez produkty w koszyku
        foreach ($cart as $productId => $cartItem) {
            // Sprawdź, czy $cartItem jest tablicą i zawiera produkt
            if (is_array($cartItem) && isset($cartItem['product'])) {
                // Oblicz sumę cen dla każdego produktu
                $totalPrice += $cartItem['quantity'] * $cartItem['product']['cena'];
            }
        }
        $dostawy = Dostawa::all();
        $platnosci = Platnosci::all();
        //dd($deliveryMethods);
        $cart['totalprice']=$totalPrice;
        setcookie('totalprice', $totalPrice, time() + (86400 * 30), "/");
        // Zwróć widok koszyka wraz z danymi
        return view('cart', ['cart' => $cart, 'totalPrice' => $totalPrice, 'dostawy' => $dostawy, 'platnosci' => $platnosci]);
    }



    public function addToCart(Request $request, $productId, $quantity)
    {
        $cart = $request->cookie('cart', []);

        // Sprawdź, czy $cart jest stringiem i przekonwertuj go na tablicę
        if (is_string($cart)) {
            $cart = json_decode($cart, true);
        }

        // Sprawdź, czy $cart jest tablicą
        if (!is_array($cart)) {
            $cart = [];
        }

        // Sprawdź, czy $cart[$productId] istnieje i jest tablicą
        if (!isset($cart[$productId]) || !is_array($cart[$productId])) {
            // Dodaj nowy produkt do koszyka
            $product = products::find($productId); // Załóżmy, że masz model Product

            if ($product) {
                $cart[$productId] = [
                    'quantity' => 0,
                    'product' => $product->toArray(), // Convert the Eloquent model to an array
                ];
            }
        }

        // Aktualizuj ilość produktu w koszyku
        $cart[$productId]['quantity'] += $quantity;

        // Set the cookie with an expiration time (adjust as needed)
        return response()
            ->json(['success' => true])
            ->cookie('cart', json_encode($cart), 60);
    }



    public function removeFromCart(Request $request, $productId) {
        $cart = $request->cookie('cart', []);

        // Ensure $cart is an array
        if (is_string($cart)) {
            $cart = json_decode($cart, true);
        }

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
        }

        // Use the withCookie method to set the cookie
        return response()
            ->json(['success' => true])
            ->withCookie('cart', json_encode($cart), 60);
    }


    public function getCart(Request $request) {
        $cart = $request->cookie('cart', []);

        // Dodatkowe operacje na koszyku, jeśli potrzebujesz

        return view('cart', ['cart' => $cart]);
    }


}
