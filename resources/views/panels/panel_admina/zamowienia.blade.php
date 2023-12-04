<x-layout>
    <x-admin>
        <h1 class="text-2xl font-semibold mb-4">Panel admina {{ auth()->user()->name }}</h1>

        <h1 class="text-3xl font-semibold">Lista Zamówień</h1>

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
                <th class="px-4 py-2">Akcje</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($orders as $order)
                <tr class="border-b border-gray-200 hover:bg-gray-100" id="row_{{ $order->id }}">
                    <td class="px-4 py-2">{{ $order->id }}</td>
                    <td>
                        @if($order->czy_anon)
                            <span id="display_name_{{ $order->id }}">{{ $order->anonimowyKlient->name ?? '' }}</span>
                            <input type="text" class="hidden" id="edit_name_{{ $order->id }}" value="{{ $order->anonimowyKlient->name ?? '' }}">
                        @else
                            <span id="display_name_{{ $order->id }}">{{ $order->users->name ?? '' }}</span>
                            <input type="text" class="hidden" id="edit_name_{{ $order->id }}" value="{{ $order->users->name ?? '' }}">
                        @endif
                    </td>
                    <td>
                        @if($order->czy_anon)
                            <span id="display_email_{{ $order->id }}">{{ $order->anonimowyKlient->email ?? '' }}</span>
                            <input type="text" class="hidden" id="edit_email_{{ $order->id }}" value="{{ $order->anonimowyKlient->email ?? '' }}">
                        @else
                            <span id="display_email_{{ $order->id }}">{{ $order->users->email ?? '' }}</span>
                            <input type="text" class="hidden" id="edit_email_{{ $order->id }}" value="{{ $order->users->email ?? '' }}">
                        @endif
                    </td>
                    <td>
                        @if($order->czy_anon)
                            <span id="display_adres_{{ $order->id }}">{{ $order->adres ?? '' }}</span>
                            <input type="text" class="hidden" id="edit_adres_{{ $order->id }}" value="{{ $order->adres ?? '' }}">
                        @else
                            <span id="display_adres_{{ $order->id }}">{{ $order->adres ?? '' }}</span>
                            <input type="text" class="hidden" id="edit_adres_{{ $order->id }}" value="{{ $order->adres ?? '' }}">
                        @endif
                    </td>
                    <td>
                        @if($order->czy_anon)
                            <span id="display_miasto_{{ $order->id }}">{{ $order->miasto ?? '' }}</span>
                            <input type="text" class="hidden" id="edit_miasto_{{ $order->id }}" value="{{ $order->miasto ?? '' }}">
                        @else
                            <span id="display_miasto_{{ $order->id }}">{{ $order->miasto ?? '' }}</span>
                            <input type="text" class="hidden" id="edit_miasto_{{ $order->id }}" value="{{ $order->miasto ?? '' }}">
                        @endif
                    </td>
                    <td>
                        <span id="display_payment_{{ $order->id }}">{{ $order->payment->name ?? '' }}</span>
                        <input type="text" class="hidden" id="edit_payment_{{ $order->id }}" value="{{ $order->payment->name ?? '' }}">
                    </td>
                    <td>
                        <span id="display_delivery_{{ $order->id }}">{{ $order->delivery->name ?? '' }}</span>
                        <input type="text" class="hidden" id="edit_delivery_{{ $order->id }}" value="{{ $order->delivery->name ?? '' }}">
                    </td>
                    <td>
                        @foreach ($order->szczegoly as $szczegol)
                            <div id="product_row_{{ $szczegol->id }}">
                                {{ $szczegol->ilosc }} {{ $szczegol->product->name }}
                                ({{ $szczegol->product->cena }} PLN)
                            </div>
                        @endforeach
                    </td>
                    <td>{{ $order->calculateTotalAmount() }} PLN</td>
                    <td>
                        <button class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded"
                                onclick="editOrder('{{ $order->id }}')">Edytuj
                        </button>
                        <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded"
                                onclick="deleteOrder('{{ $order->id }}')">Usuń
                        </button>

                        <button class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded hidden"
                                onclick="updateOrder('{{ $order->id }}')">Zapisz
                        </button>
                        <button class="bg-gray-500 hover:bg-gray-600 text-white px-3 py-1 rounded hidden"
                                onclick="cancelEditOrder('{{ $order->id }}')">Anuluj
                        </button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <script>
            function editOrder(id) {
                hideAllEditFields();
               // document.getElementById(`display_name_${id}`).style.display = 'none';
              //  document.getElementById(`edit_name_${id}`).style.display = 'block';
               // document.getElementById(`display_email_${id}`).style.display = 'none';
               // document.getElementById(`edit_email_${id}`).style.display = 'block';
                document.getElementById(`display_adres_${id}`).style.display = 'none';
                document.getElementById(`edit_adres_${id}`).style.display = 'block';
                document.getElementById(`display_miasto_${id}`).style.display = 'none';
                document.getElementById(`edit_miasto_${id}`).style.display = 'block';
               // document.getElementById(`display_payment_${id}`).style.display = 'none';
                //document.getElementById(`edit_payment_${id}`).style.display = 'block';
               // document.getElementById(`display_delivery_${id}`).style.display = 'none';
                //document.getElementById(`edit_delivery_${id}`).style.display = 'block';
                document.querySelector(`button[onclick="editOrder('${id}')"]`).style.display = 'none';
                document.querySelector(`button[onclick="deleteOrder('${id}')"]`).style.display = 'none';
                document.querySelector(`button[onclick="updateOrder('${id}')"]`).style.display = 'block';
                document.querySelector(`button[onclick="cancelEditOrder('${id}')"]`).style.display = 'block';
            }

            function updateOrder(id) {
                const newName = document.getElementById(`edit_name_${id}`).value;
                const newEmail = document.getElementById(`edit_email_${id}`).value;
                const newAdres = document.getElementById(`edit_adres_${id}`).value;
                const newMiasto = document.getElementById(`edit_miasto_${id}`).value;
                const newPayment = document.getElementById(`edit_payment_${id}`).value;
                const newDelivery = document.getElementById(`edit_delivery_${id}`).value;
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                const data = {
                    name: newName,
                    email: newEmail,
                    adres: newAdres,
                    miasto: newMiasto,
                    payment: newPayment,
                    delivery: newDelivery,
                };

                fetch(`/orders/update/${id}`, {
                    method: 'PUT',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(data),
                })
                    .then(response => {
                        //if (response.ok) {
                            document.getElementById(`display_name_${id}`).textContent = newName;
                            document.getElementById(`display_email_${id}`).textContent = newEmail;
                            document.getElementById(`display_adres_${id}`).textContent = newAdres;
                            document.getElementById(`display_miasto_${id}`).textContent = newMiasto;
                            document.getElementById(`display_payment_${id}`).textContent = newPayment;
                            document.getElementById(`display_delivery_${id}`).textContent = newDelivery;
                            location.reload();

                            hideAllEditFields();
                       // } else {
                     //       alert('Wystąpił błąd podczas aktualizacji zamówienia.');
                   //     }
                    }
                    )
                    .catch(error => {
                        alert('Wystąpił błąd podczas aktualizacji zamówienia: ' + error.message);
                    });
            }

            function cancelEditOrder(id) {
                hideAllEditFields();
            }

            function deleteOrder(id) {
                if (confirm('Czy na pewno chcesz usunąć to zamówienie?')) {
                    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                    fetch(`/orders/delete/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                        },
                    })
                        .then(response => {
                            const row = document.getElementById(`row_${id}`);
                            row.remove();
                            location.reload();
                        })
                        .catch(error => {
                            alert('Wystąpił błąd podczas usuwania zamówienia: ' + error.message);
                        });
                }
            }

            function hideAllEditFields() {
                const editFields = document.querySelectorAll('[id^="edit_"]');
                editFields.forEach(field => field.style.display = 'none');
                const displayFields = document.querySelectorAll('[id^="display_"]');
                displayFields.forEach(field => field.style.display = 'block');
                const editButtons = document.querySelectorAll(`button[onclick^="editOrder('"]`);
                editButtons.forEach(button => button.style.display = 'block');
                const deleteButtons = document.querySelectorAll(`button[onclick^="deleteOrder('"]`);
                deleteButtons.forEach(button => button.style.display = 'block');
                const updateButtons = document.querySelectorAll(`button[onclick^="updateOrder('"]`);
                updateButtons.forEach(button => button.style.display = 'none');
                const cancelButtons = document.querySelectorAll(`button[onclick^="cancelEditOrder('"]`);
                cancelButtons.forEach(button => button.style.display = 'none');
            }
        </script>

        @if (session('error'))
            <div class="bg-red-200 text-red-800 p-2 my-4 rounded">
                {{ session('error') }}
            </div>
        @endif
    </x-admin>
</x-layout>
