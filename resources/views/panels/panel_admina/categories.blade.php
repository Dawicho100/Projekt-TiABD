<x-layout>
    <x-admin>
    <h1 class="text-3xl font-semibold">Lista Kategorii</h1>

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
            <th class="px-4 py-2">Akcje</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($categories as $category)
            <tr id="row_{{ $category->id }}" class="border-b border-gray-200 hover:bg-gray-100">
                <td class="px-4 py-2">{{ $category->id }}</td>
                <td>
                    <span id="display_name_{{ $category->id }}" class="mr-2">{{ $category->name }}</span>
                    <input type="text" class="form-input hidden" id="edit_name_{{ $category->id }}" value="{{ $category->name }}">
                </td>
                <td>
                    <button class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded" onclick="editCategory({{ $category->id }})">Edytuj</button>
                    <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded" onclick="deleteCategory({{ $category->id }})">Usuń</button>
                    <button class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded hidden" onclick="updateCategory({{ $category->id }})">Zapisz</button>
                    <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded hidden" onclick="cancelEditCategory({{ $category->id }})">Anuluj</button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <h2 class="text-xl font-semibold mt-6">Dodaj nową kategorię</h2>
    <form id="dodajCategoryForm" action="{{ route('categories.store') }}" method="POST" class="mt-4">
        @csrf
        <div class="mb-4">
            <input type="text" name="name" class="form-input w-64" placeholder="Nazwa" required>
        </div>
        <button class="bg-green-500 hover.bg-green-600 text-white px-3 py-1 rounded">Dodaj</button>
    </form>

    <script>
        function editCategory(id) {
            hideAllEditFields();
            document.getElementById('display_name_' + id).style.display = 'none';
            document.getElementById('edit_name_' + id).style.display = 'block';
            document.querySelector(`button[onclick="editCategory(${id})"]`).style.display = 'none';
            document.querySelector(`button[onclick="updateCategory(${id})"]`).style.display = 'block';
            document.querySelector(`button[onclick="cancelEditCategory(${id})"]`).style.display = 'block';
        }

        function updateCategory(id) {
            const newName = document.getElementById('edit_name_' + id).value;
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // Przygotuj dane do wysłania na serwer
            const data = {
                name: newName
            };

            fetch(`/categories/update/${id}`, {
                method: 'PUT',
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

        function cancelEditCategory(id) {
            hideAllEditFields();
        }

        function deleteCategory(id) {
            if (confirm('Czy na pewno chcesz usunąć tę kategorię?')) {
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                fetch(`/categories/delete/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                    },
                })
                    .then(response => {
                        if (response.ok) {
                            // Usunięcie kategorii powiodło się, usuń wiersz z tabeli
                            const row = document.getElementById('row_' + id);
                            row.remove();
                        } else {
                            alert('Wystąpił błąd podczas usuwania kategorii.');
                        }
                    })
                    .catch(error => {
                        alert('Wystąpił błąd podczas usuwania kategorii: ' + error.message);
                    });
            }
        }

        function hideAllEditFields() {
            const editFields = document.querySelectorAll('[id^="edit_"]');
            editFields.forEach(field => field.style.display = 'none');
            const displayFields = document.querySelectorAll('[id^="display_"]');
            displayFields.forEach(field => field.style.display = 'block');
            const editButtons = document.querySelectorAll(`button[onclick^="editCategory("]`);
            editButtons.forEach(button => button.style.display = 'block');
            const updateButtons = document.querySelectorAll(`button[onclick^="updateCategory("]`);
            updateButtons.forEach(button => button.style.display = 'none');
            const cancelButtons = document.querySelectorAll(`button[onclick^="cancelEditCategory("]`);
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
