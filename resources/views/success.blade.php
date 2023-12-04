<!-- resources/views/order_confirmation.blade.php -->

<x-layout>
    <div class="max-w-4xl m-5 shadow-2xl mx-auto px-20 py-8 bg-white border border-gray-300 rounded-lg">
        <h1 class="text-3xl font-semibold text-red-600 mb-4">Dziękujemy za złożenie zamówienia!</h1>
        <p class="text-gray-700">Wysłaliśmy e-mail z potwierdzeniem zamówienia.</p>

        <div class="mt-6">
            <a href="{{ route('products.index2') }}" class="text-red-500 hover:underline">Powrót do strony głównej</a>
        </div>
    </div>
</x-layout>
