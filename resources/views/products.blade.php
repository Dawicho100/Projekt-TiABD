
<x-layout>

    <div id="cartMessage" class="hidden bg-green-200 p-2 mb-4">
        <!-- Komunikat o dodaniu produktu do koszyka pojawi się tutaj -->
    </div>
    <div class="container mx-auto grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-8">
        @foreach($products as $product)
            <div class="col-span-1 m-5">
                <div class="flex flex-col items-center justify-center p-8 border border-gray-300 rounded-md relative max-w-4xl m-5 shadow-2xl mx-auto px-10 py-8 bg-white ">
                    <img src="{{ asset('images/' . $product->odnosnik) }}" alt="{{ $product->name }}" class="w-64 h-64 object-contain mb-4">
                    <h2 class="text-3xl font-semibold mb-4"><a href="{{ route('product.show1', ['id' => $product->id]) }}">{{ $product->name }}</a></h2>
                    <p class="text-xl">{{ $product->cena }} PLN</p>
                    <button onclick="addToCart({{ $product->id }})" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded mt-4">Kup</button>

                    @auth
                        <div class="absolute top-2 right-2">
                            <button
                                class="text-red-500 focus:outline-none flex items-center hover:text-red-700"
                                onclick="toggleFavorite({{ $product->id }})"
                            >
                                <i id="heartIcon-{{ $product->id }}" class="{{ auth()->user()->favoriteProducts->contains($product) ? 'fas' : 'far' }} fa-heart mr-1"></i>
                            </button>
                        </div>
                    @endauth
                </div>
            </div>
        @endforeach
    </div>

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
            $.ajax({
                url: `/addToCart/${productId}/1`,
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    if (response.success) {
                        console.log('Product added to the cart!');
                        showCartMessage('Produkt dodany do koszyka!');
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
            var cartMessageDiv = $('#cartMessage');
            cartMessageDiv.text(message);
            cartMessageDiv.removeClass().addClass('p-2 mb-4 ' + bgColor);
            cartMessageDiv.slideDown();
            setTimeout(function() {
                cartMessageDiv.slideUp();
            }, 3000);
        }
    </script>
</x-layout>





