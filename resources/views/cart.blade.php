<x-layout>
    <div class="max-w-4xl m-5 shadow-2xl mx-auto px-20 py-8 bg-white border border-gray-300 rounded-lg">
        <h2 class="text-2xl font-semibold mb-4">Twój koszyk:</h2>

        @forelse($cart as $productId => $cartItem)
            @if(is_array($cartItem) && isset($cartItem['product']))
                <div class="flex items-center mb-4">
                    <img src="{{ asset('images/' . $cartItem['product']['odnosnik']) }}" alt="{{ $cartItem['product']['name'] }}" class="w-32 h-32 object-cover mr-4">

                    <div>
                        <h3 class="text-lg font-semibold">{{ $cartItem['product']['name'] }}</h3>
                        <p class="text-sm">Ilość: {{ $cartItem['quantity'] }}</p>
                        <p class="text-sm">Cena za jeden: {{ $cartItem['product']['cena'] }} PLN<button onclick="removeFromCart({{ $productId }})" class="ml-4 text-red-500">
                                <i class="fas fa-trash-alt"></i>
                            </button></p>
                    </div>
                </div>
            @endif
        @empty
            <p>Twój koszyk jest pusty.</p>
        @endforelse

        <div class="mt-4">
            @if($totalPrice > 0)
                <form action="" method="post">
                    @csrf

                    <div class="mt-4">
                        <label for="delivery_method" class="block text-sm font-semibold mb-2">Wybierz sposób dostawy:</label>
                        <select name="delivery_method" id="delivery_method" class="border p-2">
                            @foreach ($dostawy as $dostawa)
                                <option value="{{ $dostawa->name }}" data-price="{{ $dostawa->cena }}">{{ $dostawa->name }} ({{ $dostawa->cena }}zł)</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mt-4">
                        <label for="payment_method" class="block text-sm font-semibold mb-2">Wybierz sposób płatności:</label>
                        <select name="payment_method" id="payment_method" class="border p-2">
                            @foreach ($platnosci as $platnosc)
                                <option value="{{ $platnosc->name }}">{{ $platnosc->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <p id="totalPrice" class="text-lg font-semibold mt-4">Suma za cały koszyk: {{ $totalPrice }} PLN</p>
                    <button type="button" onclick="placeOrder()" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded mt-4">Złóż zamówienie</button>
                </form>
            @else
                <p>Twój koszyk jest pusty. Dodaj produkty, aby kontynuować.</p>
            @endif
        </div>
    </div>
    <script>
        $(document).ready(function() {
            // Ustawienie początkowej wartości sumy
            updateTotalPrice();

            // Reakcja na zmianę wybranej dostawy
            $('#delivery_method').change(function() {
                updateTotalPrice();
            });
        });

        function updateTotalPrice() {
            // Pobranie wartości i ceny dostawy
            var selectedDelivery = $('#delivery_method option:selected');
            var deliveryPrice = parseFloat(selectedDelivery.data('price')) || 0;

            // Pobranie total price z ciasteczek
            var totalPrice = parseFloat(getCookie('totalPrice')) || 0;

            // Obliczenie nowej sumy
            var newTotalPrice = {{$totalPrice}} + deliveryPrice;

            // Aktualizacja widoku
            $('#totalPrice').text('Suma za cały koszyk: ' + newTotalPrice.toFixed(2) + ' PLN');
        }

        function getCookie(name) {
            var value = "; " + document.cookie;
            var parts = value.split("; " + name + "=");
            if (parts.length == 2) return parts.pop().split(";").shift();
        }

        function removeFromCart(productId) {
            $.ajax({
                url: `/remove/${productId}`,
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        console.log('Product removed from the cart!');
                        location.reload();
                    } else {
                        console.error('Error removing product to the cart:', response.error);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX request failed:', error);
                }
            });
        }

        function placeOrder() {
            // Pobierz dane dostawy i płatności
            var selectedDelivery = $('#delivery_method option:selected');
            var deliveryPrice = parseFloat(selectedDelivery.data('price')) || 0;

            var selectedPayment = $('#payment_method option:selected');

            // Pobierz total price
            var totalPrice = {{ $totalPrice }};
            totalPrice +=deliveryPrice;
            // Sprawdź, czy wartości są poprawne
            if (!isNaN(totalPrice) && selectedDelivery.val() && selectedPayment.val()) {
                // Zapisz dane w ciasteczkach
                document.cookie = "totalPrice=" + totalPrice;
                document.cookie = "selectedDelivery=" + selectedDelivery.val() + "; path=/";
                document.cookie = "selectedPayment=" + selectedPayment.val() + "; path=/";


                // Przerywamy domyślną akcję formularza
                // event.preventDefault(); // Uncomment this line if needed

                // Przekieruj użytkownika do nowego widoku
                var newViewPath = "{{ route('user-data-form') }}";
                window.location.assign(newViewPath);
            } else {
                console.error('Invalid values for cookies. Check totalPrice, selectedDelivery, and selectedPayment.');
            }
        }

    </script>
</x-layout>
