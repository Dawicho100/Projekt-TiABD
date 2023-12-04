<x-layout>
    <x-user>

    <h1 class="text-3xl font-semibold">Lista Zamówień {{ auth()->user()->name }}</h1>

    @if (session('success'))
        <div class="bg-green-200 text-green-800 p-2 my-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    <table class="table-auto w-full mt-4">
        <thead>
        <tr class="bg-gray-100">
            <th class="px-4 py-2">Numer zamówienia</th>
                <th class="px-4 py-2">Klient</th>
                <th class="px-4 py-2">Email</th>
                <th class="px-4 py-2">Adres</th>
                <th class="px-4 py-2">Miasto</th>
                <th class="px-4 py-2">Metoda płatności</th>
                <th class="px-4 py-2">Metoda dostawy</th>
                <th class="px-4 py-2">Produkty</th>
                <th class="px-4 py-2">Kwota</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($orders as $order)
            @if ($order->email == auth()->user()->email)
                <tr class="border-b border-gray-200 hover:bg-gray-100">
                    <td class="px-4 py-2">{{ $order->id }}</td>
                    <td>{{ $order->users->name ?? '' }}</td>
                    <td>{{ $order->users->email ?? '' }}</td>
                    <td>{{ $order->users->adres ?? '' }}</td>
                    <td>{{ $order->users->miasto ?? '' }}</td>
                    <td>{{ $order->payment->name ?? '' }}</td>
                    <td>{{ $order->delivery->name ?? '' }}</td>
                    <td>
                        @php
                            $totalAmount = 0;
                        @endphp
                        @foreach ($order->szczegoly as $szczegol)
                            <div>
                                {{ $szczegol->ilosc }} {{ $szczegol->product->name }}
                                    <?php
                                    $productAmount = $szczegol->ilosc * $szczegol->product->cena;
                                    $totalAmount += $productAmount;
                                    ?>
                                ({{ $productAmount }} PLN)
                            </div>
                        @endforeach
                    </td>
                    <td>{{ $totalAmount }} PLN</td>
                </tr>
            @endif
        @endforeach
        </tbody>
    </table>
    </x-user>
</x-layout>
