<!-- resources/views/user_data_form.blade.php -->

<x-layout>

    <form action="{{ route('process-order') }}" method="post" class="max-w-4xl m-3 shadow-2xl mx-auto px-20 py-4 bg-white border border-gray-300 rounded-lg">
        @csrf
        <h2 class="text-2xl font-semibold mb-4">Dane użytkownika:</h2>

        @php
            // Pobranie wartości z ciasteczek lub domyślnie z konta użytkownika
            $nameValue = isset($_COOKIE['name']) ? $_COOKIE['name'] : (auth()->check() ? auth()->user()->name : '');
            $addressValue = isset($_COOKIE['adres']) ? $_COOKIE['adres'] : (auth()->check() ? auth()->user()->adres : '');
            $cityValue = isset($_COOKIE['miasto']) ? $_COOKIE['miasto'] : (auth()->check() ? auth()->user()->miasto : '');
            $phoneValue = isset($_COOKIE['nrtel']) ? $_COOKIE['nrtel'] : (auth()->check() ? auth()->user()->nrtel : '');
            $emailValue = isset($_COOKIE['email']) ? $_COOKIE['email'] : (auth()->check() ? auth()->user()->email : '');
        @endphp

        <div class="mb-4">
            <label for="name" class="block text-sm font-semibold mb-2">Imię i Nazwisko:</label>
            <input type="text" name="name" id="name" class="border p-2 w-full" value="{{ $nameValue }}" required>
        </div>

        <div class="mb-4">
            <label for="address" class="block text-sm font-semibold mb-2">Adres:</label>
            <input type="text" name="address" id="address" class="border p-2 w-full" value="{{ $addressValue }}" required>
        </div>

        <div class="mb-4">
            <label for="city" class="block text-sm font-semibold mb-2">Miasto:</label>
            <input type="text" name="city" id="city" class="border p-2 w-full" value="{{ $cityValue }}" required>
        </div>

        <div class="mb-4">
            <label for="phone" class="block text-sm font-semibold mb-2">Numer Telefonu:</label>
            <input type="text" name="phone" id="phone" class="border p-2 w-full" value="{{ $phoneValue }}" required>
        </div>

        <div class="mb-4">
            <label for="email" class="block text-sm font-semibold mb-2">E-mail:</label>
            <input type="email" name="email" id="email" class="border p-2 w-full" value="{{ $emailValue }}" required>
        </div>

        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded mt-4">Zakończ zamówienie</button>
    </form>
</x-layout>
