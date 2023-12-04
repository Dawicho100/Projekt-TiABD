<?php

namespace App\Http\Controllers;

use App\Models\szczegoly_zamowienia;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Http\Request;
use App\Models\zamowienia;
use App\Models\AnonimowyKlient;
use Illuminate\Support\Facades\Auth;
use App\Models\Platnosci;
use App\Models\Dostawa;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{

    public function index()
    {
        $orders = zamowienia::with(['users', 'anonimowyKlient', 'payment', 'delivery', 'szczegoly'])->get();

        return view('panels.panel_admina.zamowienia', ['orders' => $orders]);
    }

    public function index1()
    {
        $orders = zamowienia::with(['users', 'payment', 'delivery', 'szczegoly'])->get();

        return view('panels.panel_user.zamowienia', ['orders' => $orders]);
    }

    public function userDataForm()
    {
        return view('user_data_form');
    }

    public function processOrder(Request $request)
    {
        // Pobierz aktualny koszyk z ciasteczka
        $cart = Cookie::get('cart', []);

        // Sprawdź, czy $cart jest stringiem i przekonwertuj go na tablicę
        if (is_string($cart)) {
            $cart = json_decode($cart, true);
        }
        // Sprawdź, czy $cart jest tablicą
        if (!is_array($cart)) {
            $cart = [];
        }

        $userData = Auth::check() ? Auth::user()->only(['name', 'address', 'city', 'phone', 'email']) : [];
        $totalPrice = isset($_COOKIE['totalPrice']) ? $_COOKIE['totalPrice'] : 0;
        $selectedDelivery = $_COOKIE['selectedDelivery'];
        $selectedPayment = $_COOKIE['selectedPayment'];
        $orderData = session('order_data');
        $name = $request->name;
        setcookie('name', $name, time() + (86400 * 30), "/");
        $email = $request->email;
        setcookie('email', $email, time() + (86400 * 30), "/");
        $nrtel = $request->phone;
        setcookie('nrtel', $nrtel, time() + (86400 * 30), "/");
        $adres = $request->address;
        setcookie('adres', $adres, time() + (86400 * 30), "/");
        $miasto = $request->city;
        setcookie('miasto', $miasto, time() + (86400 * 30), "/");

        // Zapisanie danych w sesji
        session([
            'order_data' => $request->only(['name', 'address', 'city', 'phone', 'email']),
        ]);

        // Pass all required data to the view
        return view('order_summary', compact('cart', 'name', 'email', 'nrtel', 'adres', 'miasto', 'totalPrice', 'userData', 'orderData', 'selectedDelivery', 'selectedPayment'));
    }

    public function orderSummary()
    {
        // Pobranie danych z sesji
        $orderData = session('order_data');

        // Debugging: Dump the cart data

        // Wyświetlenie widoku z danymi zamówienia
        return view('order_summary', compact('orderData'));
    }

    public function placeOrder(Request $request)
    {
        // Pobierz dane z sesji i ciasteczek
        $orderData = session('order_data');
        $cart = json_decode(Cookie::get('cart', '[]'), true); // Ensure $cart is an array
        $totalPrice = $_COOKIE['totalPrice'];
        $selectedDelivery = $_COOKIE['selectedDelivery'];
        $selectedPayment = $_COOKIE['selectedPayment'];
        $czyanon=0;
        // Uzyskaj identyfikatory (ID) dla wybranej metody płatności i dostawy
        $paymentId = Platnosci::where('name', $selectedPayment)->value('id');
        $deliveryId = Dostawa::where('name', $selectedDelivery)->value('id');
        $email = $orderData['email'];
        if (auth()->check()) {
        } else {
            // 1a. Jeśli użytkownik nie jest zalogowany, zapisz dane w tabeli anonimowych użytkowników
            $anonimowyKlient = new AnonimowyKlient;
            $anonimowyKlient->name = $_COOKIE['name'];
            $anonimowyKlient->email = $_COOKIE['email'];
            $anonimowyKlient->adres = $_COOKIE['adres'];
            $anonimowyKlient->miasto = $_COOKIE['miasto'];
            $anonimowyKlient->nr_tel = $_COOKIE['nrtel'];
            $anonimowyKlient->save();
            $czyanon=1;
        }
        // Utwórz nowe zamówienie w bazie danych
        $zamowienie = new zamowienia([
            'email' => $orderData['email'],
            'id_platnosci' => $paymentId,
            'id_dostawy' => $deliveryId,
            'czy_anon' => $czyanon,
            'adres' => $_COOKIE['adres'],
            'miasto' => $_COOKIE['miasto'],
            // Dodaj inne pola zamówienia, jeśli są dostępne
        ]);

        // Zapisz zamówienie w bazie danych
        $zamowienie->save();

        // Dodaj szczegóły zamówienia do tabeli zamowienie_szczegoly
        foreach ($cart as $productId => $cartItem) {
            if (is_array($cartItem) && isset($cartItem['product'])) {
                $szczegoly = new szczegoly_zamowienia([
                    'id_zamowinie' => $zamowienie->id,
                    'id_produkt' => $cartItem['product']['id'],
                    'ilosc' => $cartItem['quantity'],
                    // Dodaj inne pola szczegółów zamówienia, jeśli są dostępne
                ]);

                $szczegoly->save();
            }
        }

        Mail::send("emails.potwierdzenie-zaaamowienia", ['id' => $zamowienie->id], function ($message) use ($email) {
            $message->to($email);
            $message->subject("Potwierdzenie zamówienia");
        });
        $past = time() - 3600;
        foreach ($_COOKIE as $key => $value) {
            setcookie($key, $value, $past, '/');
        }
        // Przykładowa operacja po zapisaniu zamówienia, np. przekierowanie
        return view('success');
    }

    public function successpage(Request $request)
    {
        return redirect()->route('place-order');
    }

    public function editOrder($id)
    {
        // Pobierz zamówienie do edycji
        $order = zamowienia::with(['users', 'payment', 'delivery', 'szczegoly'])->findOrFail($id);

        // Wczytaj widok edycji zamówienia
        return view('panels.panel_admina.edit_order', ['order' => $order]);
    }

    public function updateOrder(Request $request, $id)
    {
        // Zaktualizuj dane zamówienia na podstawie danych z formularza
        $order = zamowienia::findOrFail($id);
        $order->update([
            'adres' => $request->input('adres'),
            'miasto' => $request->input('miasto'),
        ]);

        // Przekieruj po zaktualizowaniu
        return redirect()->route('orders')->with('success', 'Zamówienie zostało zaktualizowane.');
    }

    public function deleteOrder($id)
    {
        // Znajdź i usuń zamówienie
        $order = zamowienia::find($id);
        $order->delete();
        // Przekieruj po usunięciu
        return redirect()->route('orders')->with('success', 'Zamówienie zostało usunięte.');
    }
}
