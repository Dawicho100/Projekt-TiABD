<x-layout>
    <div class="max-w-4xl m-5 shadow-2xl mx-auto px-20 py-8 bg-white border border-gray-300 rounded-lg">
        <h2 class="text-2xl font-semibold mb-4">Podsumowanie zamówienia:</h2>

        <div>
            <h3 class="text-xl font-semibold mb-2">Zamówione produkty:</h3>
            <ul>
                @forelse($cart as $productId => $cartItem)
                    @if(is_array($cartItem) && isset($cartItem['product']))
                        <li class="flex items-center border-b border-gray-300 py-2">
                            <img src="{{ asset('images/' . $cartItem['product']['odnosnik']) }}" alt="{{ $cartItem['product']['name'] }}" class="w-16 h-16 object-cover mr-4">
                            <div>
                                <h3 class="text-lg font-semibold">{{ $cartItem['product']['name'] }}</h3>
                                <p class="text-sm">Ilość: {{ $cartItem['quantity'] }}</p>
                                <p class="text-sm">Cena za jeden: {{ $cartItem['product']['cena'] }} PLN</p>
                            </div>
                        </li>
                    @endif
                @empty
                    <p class="mt-4 text-gray-600">Brak produktów w koszyku.</p>
                @endforelse
            </ul>
        </div>

        <div class="mt-6">
            <p><strong>Imię i Nazwisko:</strong> {{ $name }}</p>
            <p><strong>Adres:</strong> {{ $adres }}</p>
            <p><strong>Miasto:</strong> {{ $miasto }}</p>
            <p><strong>Numer Telefonu:</strong> {{ $nrtel }}</p>
            <p><strong>E-mail:</strong> {{ $email}}</p>
        </div>

        <div class="mt-6">
            <p class="text-lg font-semibold">Suma do zapłaty: {{ $totalPrice }} PLN</p>
        </div>

        <div class="mt-6">
            <ul>
                <li><strong>Metoda dostawy:</strong> {{ $selectedDelivery }}</li>
                <li><strong>Metoda płatności:</strong> {{ $selectedPayment }}</li>
            </ul>
        </div>

        <div class="mt-6">
        <form method="post">
            @csrf
            <input type="hidden" name="total_price" value="{{ $totalPrice }}">
            <input type="hidden" name="amount" value="{{ $totalPrice }}">

            @if($selectedPayment == 'przy odbiorze')
                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded mt-4" formaction="{{ route('place-order') }}">Złóż zamówienie</button>
            @else
                <!-- Zamiast formularza POST, przekieruj użytkownika bezpośrednio do trasy session -->
                <a href="{{ route('session') }}" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded mt-4">Przejdź do płatności</a>
            @endif
        </form>
    </div>
    </div>
</x-layout>
