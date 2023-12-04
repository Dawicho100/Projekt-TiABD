<x-layout>
    <x-admin>
        <h1 class="text-2xl font-semibold mb-4">Panel admina {{ auth()->user()->name }}</h1>

        <h1 class="text-3xl font-semibold">Lista Produktów</h1>

        @if (session('success'))
            <div class="bg-green-200 text-green-800 p-2 my-4 rounded">
                {{ session('success') }}
            </div>
        @endif

        <table class="table-auto w-full mt-4">
            <thead>
            <tr class="bg-gray-100">
                <th class="px-4 py-2">ID</th>
                <th class="px-4 py-2">Nazwa</th>
                <th class="px-4 py-2">Kategorie</th>
                <th class="px-4 py-2">Parametry</th>
                <th class="px-4 py-2">Odnosnik</th>
                <th class="px-4 py-2">Ilość</th>
                <th class="px-4 py-2">Cena</th>
                <th class="px-4 py-2">Opis</th>
                <th class="px-4 py-2">Akcje</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($products as $product)
                <tr id="row_{{ $product->id }}" class="border-b border-gray-200 hover:bg-gray-100">
                    <td class="px-4 py-2">{{ $product->id }}</td>
                    <td>
                        <span id="display_name_{{ $product->id }}" class="mr-2">{{ $product->name }}</span>
                        <input type="text" class="form-input hidden" id="edit_name_{{ $product->id }}"
                               value="{{ $product->name }}">
                    </td>
                    <td>
                        <div>
                            @foreach ($categories as $category)
                                <label>
                                    <input type="checkbox" name="categories_{{ $product->id }}[]"
                                           value="{{ $category->id }}"
                                        {{ in_array($category->id, $product->categories->pluck('id')->toArray()) ? 'checked' : '' }}>
                                    {{ $category->name }}
                                </label><br>
                            @endforeach
                        </div>
                    </td>
                    <td>
                        <div>
                            @foreach ($parameters as $parameter)
                                <label>
                                    <input type="checkbox" name="parameters_{{ $product->id }}[]"
                                           value="{{ $parameter->id }}"
                                        {{ in_array($parameter->id, $product->parameters->pluck('id')->toArray()) ? 'checked' : '' }}>
                                    {{ $parameter->name }}
                                </label><br>
                            @endforeach
                        </div>
                    </td>
                    <td>
                        <span id="display_odnosnik_{{ $product->id }}">{{ $product->odnosnik }}</span>
                        <input type="text" class="form-input hidden" id="edit_odnosnik_{{ $product->id }}"
                               value="{{ $product->odnosnik }}">
                    </td>
                    <td>
                        <span id="display_ilosc_{{ $product->id }}">{{ $product->ilosc }}</span>
                        <input type="text" class="form-input hidden" id="edit_ilosc_{{ $product->id }}"
                               value="{{ $product->ilosc }}">
                    </td>
                    <td>
                        <span id="display_cena_{{ $product->id }}">{{ $product->cena }}</span>
                        <input type="text" class="form-input hidden" id="edit_cena_{{ $product->id }}"
                               value="{{ $product->cena }}">
                    </td>
                    <td>
                        <span id="display_opis_{{ $product->id }}">{{ $product->opis }}</span>
                        <input type="text" class="form-input hidden" id="edit_opis_{{ $product->id }}"
                               value="{{ $product->opis }}">
                    </td>
                    <td>
                        <button class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded"
                                onclick="editProduct({{ $product->id }})">Edytuj</button>
                        <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded"
                                onclick="deleteProduct({{ $product->id }})">Usuń</button>
                        <button class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded hidden"
                                onclick="updateProduct({{ $product->id }})">Zapisz</button>
                        <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded hidden"
                                onclick="cancelEditProduct({{ $product->id }})">Anuluj</button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <div class="flex">
            <div class="w-1/2">
                <h2 class="text-xl font-semibold mt-6">Dodaj nowy produkt</h2>
                <form id="dodajProduktForm" action="{{ route('products.store') }}" method="POST" class="mt-4">
            @csrf
            <div class="mb-4">
                <input type="text" name="name" class="form-input w-64" placeholder="Nazwa">
            </div>
            <div class="mb-4">
                <label for="categories">Kategorie:</label>
                <div>
                    @foreach ($categories as $category)
                        <label>
                            <input type="checkbox" name="categories[]" value="{{ $category->id }}">
                            {{ $category->name }}
                        </label><br>
                    @endforeach
                </div>
            </div>
            <div class="mb-4">
                <label for="parameters">Parametry:</label>
                <div>
                    @foreach ($parameters as $parameter)
                        <label>
                            <input type="checkbox" name="parameters[]" value="{{ $parameter->id }}">
                            {{ $parameter->name }}
                        </label><br>
                    @endforeach
                </div>
            </div>
            <div class="mb-4">
                <input type="text" name="odnosnik" class="form-input w-64" placeholder="Odnosnik">
            </div>
            <div class="mb-4">
                <input type="text" name="ilosc" class="form-input w-64" placeholder="Ilość">
            </div>
            <div class="mb-4">
                <input type="text" name="cena" class="form-input w-64" placeholder="Cena">
            </div>
            <div class="mb-4">
                <input type="text" name="opis" class="form-input w-64" placeholder="Opis">
            </div>
            <button class="bg-green-500 hover.bg-green-600 text-white px-3 py-1 rounded">Dodaj</button>
                </form>
            </div>

            <div class="w-1/2 ml-4">
                <h2 class="text-xl font-semibold mt-6">Dodaj obrazy</h2>
                <form action="{{ route('images.upload') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <label for="image">Wybierz obraz do uploadu:</label>
                    <input type="file" name="image" id="image" accept="image/*">

                    @error('image')
                    <div class="text-red-500">{{ $message }}</div>
                    @enderror

                    <button type="submit">Upload</button>
                </form>

                @if (session('success'))
                    <div class="text-green-500">{{ session('success') }}</div>
                @endif
            </div>
        </div>
        <script>
            function editProduct(id) {
                hideAllEditFields();
                document.getElementById('display_name_' + id).style.display = 'none';
                document.getElementById('edit_name_' + id).style.display = 'block';
                document.getElementById('display_odnosnik_' + id).style.display = 'none';
                document.getElementById('edit_odnosnik_' + id).style.display = 'block';
                document.getElementById('display_ilosc_' + id).style.display = 'none';
                document.getElementById('edit_ilosc_' + id).style.display = 'block';
                document.getElementById('display_cena_' + id).style.display = 'none';
                document.getElementById('edit_cena_' + id).style.display = 'block';
                document.getElementById('display_opis_' + id).style.display = 'none';
                document.getElementById('edit_opis_' + id).style.display = 'block';
                document.querySelector(`button[onclick="editProduct(${id})"]`).style.display = 'none';
                document.querySelector(`button[onclick="updateProduct(${id})"]`).style.display = 'block';
                document.querySelector(`button[onclick="cancelEditProduct(${id})"]`).style.display = 'block';
            }

            function updateProduct(id) {
                const newName = document.getElementById('edit_name_' + id).value;
                const newOdnosnik = document.getElementById('edit_odnosnik_' + id).value;
                const newIlosc = document.getElementById('edit_ilosc_' + id).value;
                const newCena = document.getElementById('edit_cena_' + id).value;
                const newOpis = document.getElementById('edit_opis_' + id).value;
                const categories = Array.from(document.getElementsByName('categories_' + id + '[]')).filter(input => input.checked).map(input => input.value);
                const parameters = Array.from(document.getElementsByName('parameters_' + id + '[]')).filter(input => input.checked).map(input => input.value);
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                // Upewnij się, że dane są prawidłowo zdefiniowane
                const data = {
                    name: newName,
                    categories: categories,
                    parameters: parameters,
                    odnosnik: newOdnosnik,
                    ilosc: newIlosc,
                    cena: newCena,
                    opis: newOpis,
                };

                // Wyślij dane na serwer
                fetch(`/products/update/${id}`, {
                    method: 'PUT',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(data),
                })

                    .then(data => {
                        //if (data.success) {
                            document.getElementById('display_name_' + id).textContent = newName;
                            document.getElementById('display_odnosnik_' + id).textContent = newOdnosnik;
                            document.getElementById('display_ilosc_' + id).textContent = newIlosc;
                            document.getElementById('display_cena_' + id).textContent = newCena;
                            document.getElementById('display_opis_' + id).textContent = newOpis;

                            hideAllEditFields();
                        //} else {
                            //alert('Wystąpił błąd podczas aktualizacji rekordu.');
                       // }
                    })
                    .catch(error => {
                        alert('Wystąpił błąd podczas aktualizacji rekordu: ' + error.message);
                    });
            }


            function cancelEditProduct(id) {
                hideAllEditFields();
            }

            function deleteProduct(id) {
                if (confirm('Czy na pewno chcesz usunąć ten produkt?')) {
                    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                    fetch(`/products/delete/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                        },
                    })
                        .then(response => {
                            //if (response.ok) {
                                // Usunięcie płatności powiodło się, usuń wiersz z tabeli
                                const row = document.getElementById('row_' + id);
                                row.remove();
                           // } else {
                         //       alert('Wystąpił błąd podczas usuwania produktu.');
                       //     }
                        })
                        .catch(error => {
                            alert('Wystąpił błąd podczas usuwania produktu: ' + error.message);
                        });
                }
            }

            function hideAllEditFields() {
                const editFields = document.querySelectorAll('[id^="edit_"]');
                editFields.forEach(field => field.style.display = 'none');
                const displayFields = document.querySelectorAll('[id^="display_"]');
                displayFields.forEach(field => field.style.display = 'block');
                const editButtons = document.querySelectorAll(`button[onclick^="editProduct("]`);
                editButtons.forEach(button => button.style.display = 'block');
                const updateButtons = document.querySelectorAll(`button[onclick^="updateProduct("]`);
                updateButtons.forEach(button => button.style.display = 'none');
                const cancelButtons = document.querySelectorAll(`button[onclick^="cancelEditProduct("]`);
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
