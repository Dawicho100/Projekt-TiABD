<x-layout>
    <x-admin>
    <h1 class="text-3xl font-semibold">Lista Dostaw</h1>

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
            <th class="px-4 py-2">Cena</th>
            <th class="px-4 py-2">Czas dostawy (w godzinach)</th>
            <th class="px-4 py-2">Akcje</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($dostawy as $dostawa)
            <tr id="row_{{ $dostawa->id }}" class="border-b border-gray-200 hover:bg-gray-100">
                <td class="px-4 py-2">{{ $dostawa->id }}</td>
                <td>
                    <span id="display_name_{{ $dostawa->id }}" class="mr-2">{{ $dostawa->name }}</span>
                    <input type="text" class="form-input hidden" id="edit_name_{{ $dostawa->id }}" value="{{ $dostawa->name }}">
                </td>
                <td>
                    <span id="display_cena_{{ $dostawa->id }}" class="mr-2">{{ $dostawa->cena }}</span>
                    <input type="text" class="form-input hidden" id="edit_cena_{{ $dostawa->id }}" value="{{ $dostawa->cena }}">
                </td>
                <td>
                    <span id="display_how_long_{{ $dostawa->id }}" class="mr-2">{{ $dostawa->how_long }}</span>
                    <input type="text" class="form-input hidden" id="edit_how_long_{{ $dostawa->id }}" value="{{ $dostawa->how_long }}">
                </td>
                <td>
                    <button class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded" onclick="editDostawa({{ $dostawa->id }})">Edytuj</button>
                    <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded" onclick="deleteDostawa({{ $dostawa->id }})">Usuń</button>
                    <button class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded hidden" onclick="updateDostawa({{ $dostawa->id }})">Zapisz</button>
                    <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded hidden" onclick="cancelEditDostawa({{ $dostawa->id }})">Anuluj</button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <h2 class="text-xl font-semibold mt-6">Dodaj nową dostawę</h2>
    <form id="dodajDostaweForm" action="{{ route('dostawy.store') }}" method="POST" class="mt-4">
        @csrf
        <div class="mb-4">
            <input type="text" name="name" class="form-input w-64" placeholder="Nazwa">
        </div>
        <div class="mb-4">
            <input type="number" name="cena" class="form-input w-64" placeholder="Cena">
        </div>
        <div class="mb-4">
            <input type="number" name="how_long" class="form-input w-64" placeholder="Czas dostawy (w godzinach)">
        </div>
        <button class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded">Dodaj</button>
    </form>

    <script>
        function editDostawa(id) {
            hideAllEditFields();
            document.getElementById('display_name_' + id).style.display = 'none';
            document.getElementById('edit_name_' + id).style.display = 'block';
            document.getElementById('display_cena_' + id).style.display = 'none';
            document.getElementById('edit_cena_' + id).style.display = 'block';
            document.getElementById('display_how_long_' + id).style.display = 'none';
            document.getElementById('edit_how_long_' + id).style.display = 'block';
            document.querySelector(`button[onclick="editDostawa(${id})"]`).style.display = 'none';
            document.querySelector(`button[onclick="updateDostawa(${id})"]`).style.display = 'block';
            document.querySelector(`button[onclick="cancelEditDostawa(${id})"]`).style.display = 'block';
        }

        function updateDostawa(id) {
            const newName = document.getElementById('edit_name_' + id).value;
            const newCena = document.getElementById('edit_cena_' + id).value;
            const newHowLong = document.getElementById('edit_how_long_' + id).value;
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // Przygotuj dane do wysłania na serwer
            const data = {
                name: newName,
                cena: newCena,
                how_long: newHowLong
            };

            fetch(`/dostawy/update/${id}`, {
                method: 'PUT', // Zakładam, że używasz metody PUT do aktualizacji
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data),
            })
                .then(response => {
                    if (response.ok) {
                        return response.json();
                    } else {
                        throw new Error('Network response was not ok');
                    }
                })
                .then(data => {
                    if (data.success) {
                        // Zaktualizuj widok na stronie
                        document.getElementById('display_name_' + id).textContent = newName;
                        document.getElementById('display_cena_' + id).textContent = newCena;
                        document.getElementById('display_how_long_' + id).textContent = newHowLong;

                        // Schowaj pola edycji i pokaż przycisk "Edytuj" ponownie
                        hideAllEditFields();
                    } else {
                        alert('Wystąpił błąd podczas aktualizacji rekordu.');
                    }
                })
                .catch(error => {
                    alert('Wystąpił błąd podczas aktualizacji rekordu: ' + error.message);
                });
        }

        function cancelEditDostawa(id) {
            hideAllEditFields();
        }
        function deleteDostawa(id) {
            if (confirm('Czy na pewno chcesz usunąć tę dostawę?')) {
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                fetch(`/dostawy/delete/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                    },
                })
                    .then(response => {
                        if (response.ok) {
                            // Usunięcie dostawy powiodło się, usuń wiersz z tabeli
                            const row = document.getElementById('row_' + id);
                            row.remove();
                        } else {
                            alert('Wystąpił błąd podczas usuwania dostawy.');
                        }
                    })
                    .catch(error => {
                        alert('Wystąpił błąd podczas usuwania dostawy: ' + error.message);
                    });
            }
        }



        function hideAllEditFields() {
            const editFields = document.querySelectorAll('[id^="edit_"]');
            editFields.forEach(field => field.style.display = 'none');
            const displayFields = document.querySelectorAll('[id^="display_"]');
            displayFields.forEach(field => field.style.display = 'block');
            const editButtons = document.querySelectorAll(`button[onclick^="editDostawa("]`);
            editButtons.forEach(button => button.style.display = 'block');
            const updateButtons = document.querySelectorAll(`button[onclick^="updateDostawa("]`);
            updateButtons.forEach(button => button.style.display = 'none');
            const cancelButtons = document.querySelectorAll(`button[onclick^="cancelEditDostawa("]`);
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
