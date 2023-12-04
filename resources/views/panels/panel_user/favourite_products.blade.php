<!-- resources/views/favorite_products.blade.php -->

<x-layout>
    <x-user>

    <h1 class="text-3xl font-semibold">Twoje Ulubione Produkty, {{ auth()->user()->name }}</h1>

    @if (session('success'))
        <div class="bg-green-200 text-green-800 p-2 my-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if ($favoriteProducts->isEmpty())
        <p class="text-gray-600 mt-4">Nie masz jeszcze ulubionych produktów.</p>
    @else
        <table class="table-auto w-full mt-4">
            <thead>
            <tr class="bg-gray-100">
                <th class="px-4 py-2">ID Produktu</th>
                <th class="px-4 py-2">Nazwa Produktu</th>
                <th class="px-4 py-2">Cena</th>
                <!-- Dodaj inne kolumny zgodnie z potrzebami -->
            </tr>
            </thead>
            <tbody>
            @foreach ($favoriteProducts as $product)
                <a href="{{ route('product.show1', ['id' => $product->id]) }}">

                <tr class="border-b border-gray-200 hover:bg-gray-100">
                    <td class="px-4 py-2">{{ $product->id }}</td>
                    <td><a href="{{ route('product.show1', ['id' => $product->id]) }}">{{ $product->name }}</a></td>
                    <td>{{ $product->cena }} PLN</td>
                    <!-- Dodaj inne kolumny zgodnie z potrzebami -->

                </tr>
                </a>

            @endforeach
            </tbody>
        </table>
    @endif
    </x-user>
</x-layout>
