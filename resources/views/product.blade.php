<x-layout>

    <div id="cartMessage" class="hidden bg-green-200 p-2 mb-4">
        <!-- Komunikat o dodaniu produktu do koszyka pojawi się tutaj -->
    </div>
    <div class="flex flex-col items-center justify-center mt-8 bg-gray-100 mx-300 p-8">
        <div class="flex items-start mb-4">
            <img src="{{ asset('images/' . $product->odnosnik) }}" alt="{{ $product->name }}" class="w-64 h-64 object-cover mr-10">
            <div>
                <h2 class="text-3xl font-semibold mb-2">{{ $product->name }}
                    @auth
                        <button onclick="toggleFavorite({{ $product->id }})" class="text-red-500 focus:outline-none flex items-center">
                            <i id="heartIcon-{{ $product->id }}" class="{{ auth()->user()->favoriteProducts->contains($product) ? 'fas' : 'far' }} fa-heart mr-1"></i>
                        </button>
                    @endauth
                </h2>
                <p class="text-xl mb-2">{{ $product->cena }} PLN</p>
                <div class="flex items-center">
                    <label for="quantity" class="mr-2">Ilość:</label>
                    <input type="number" id="quantity" name="quantity" value="1" min="1" class="w-16 text-center">
                    <button onclick="addToCart({{ $product->id }})" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded ml-4">Kup</button>
                </div>
            </div>
        </div>

        <div class="mt-8 mx-20">
            <div class="flex">
                <div class="mr-8">
                    <h3 class="text-xl font-semibold mb-2">Kategorie</h3>
                    <ul>
                        @foreach ($product->categories as $category)
                            <li>{{ $category->name }}</li>
                        @endforeach
                    </ul>
                </div>

                <div>
                    <h3 class="text-xl font-semibold mb-2">Parametry</h3>
                    <ul>
                        @foreach ($product->parameters as $parameter)
                            <li>{{ $parameter->name }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <div class="mt-8">
            <h3 class="text-xl font-semibold mb-2">Opis</h3>
            <p>{{ $product->opis }}</p>
        </div>
    </div>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        function toggleFavorite(productId) {
            $.ajax({
                url: `/favorite/${productId}`,
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    if (response.success) {
                        var heartIcon = $(`#heartIcon-${productId}`);

                        // Toggle the heart icon and add pulse animation
                        heartIcon.toggleClass('far fa-heart fas fa-heart').effect('pulsate', { times: 1 }, 300);

                        console.log('Product favorite status toggled!');
                    } else {
                        console.error('Error toggling favorite status:', response.error);
                    }
                },
                error: function (xhr, status, error) {
                    console.error('AJAX request failed:', error);
                }
            });
        }

        function addToCart(productId) {
            var quantity = $('#quantity').val();

            $.ajax({
                url: `/addToCart/${productId}/${quantity}`,
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    if (response.success) {
                        console.log('Product added to the cart!');
                        // Dodaj komunikat po dodaniu produktu do koszyka
                        showCartMessage('Produkt dodany do koszyka');
                        // Dodaj dowolne dalsze operacje, np. aktualizacja ikony koszyka, etc.
                    } else {
                        console.error('Error adding product to the cart:', response.error);
                        showCartMessage('Error adding product to the cart. Please try again.', 'bg-red-200');
                    }
                },
                error: function (xhr, status, error) {
                    console.error('AJAX request failed:', error);
                    showCartMessage('An error occurred. Please try again.', 'bg-red-200');
                }
            });
        }

        function showCartMessage(message, bgColor = 'bg-green-200') {
            // Pobierz element div, w którym będzie wyświetlany komunikat
            var cartMessageDiv = $('#cartMessage');

            // Ustaw tekst komunikatu
            cartMessageDiv.text(message);

            // Ustaw klasę tła w zależności od przekazanego koloru (domyślnie zielony)
            cartMessageDiv.removeClass().addClass('p-2 mb-4 ' + bgColor);

            // Wyświetl komunikat
            cartMessageDiv.slideDown();

            // Ukryj komunikat po pewnym czasie (np. 3 sekundy)
            setTimeout(function() {
                cartMessageDiv.slideUp();
            }, 3000);
        }
    </script>
</x-layout>
