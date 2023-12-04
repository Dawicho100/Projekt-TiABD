<!-- resources/views/paypal/form.blade.php -->

<x-layout>
    <h2 class="text-2xl font-semibold mb-4">Formularz Płatności PayPal</h2>

    <form action="{{ route('paypal.process-payment') }}" method="post">
        @csrf

        <div id="paypal-button-container"></div>

        <p id="result-message"></p>

        <!-- Replace the "test" client-id value with your client-id -->

        <script src="https://www.paypal.com/sdk/js?client-id=test&currency=USD"></script>

        <script src="app.js"></script>
    </form>
</x-layout>
