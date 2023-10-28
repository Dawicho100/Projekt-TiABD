<x-layout>
    <h1 class="text-3xl font-semibold">Zarządzaj Treściami Stron</h1>

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
            <th class="px-4 py-2">Treść</th>
            <th class="px-4 py-2">Slug</th>
            <th class="px-4 py-2">Akcje</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($pages as $page)
            <tr id="row_{{ $page->id }}" class="border-b border-gray-200 hover:bg-gray-100">
                <td class="px-4 py-2">{{ $page->id }}</td>
                <td>
                    <span id="display_name_{{ $page->id }}" class="mr-2">{{ $page->name }}</span>
                    <input type="text" class="form-input hidden" id="edit_name_{{ $page->id }}" value="{{ $page->name }}">
                </td>
                <td>
                    <span id="display_text_{{ $page->id }}" class="mr-2">{{ $page->text }}</span>
                    <textarea class="form-input hidden" id="edit_text_{{ $page->id }}">{{ $page->text }}</textarea>
                </td>
                <td>
                    <span id="display_slug_{{ $page->id }}" class="mr-2">{{ $page->slug }}</span>
                    <input type="text" class="form-input hidden" id="edit_slug_{{ $page->id }}" value="{{ $page->slug }}">
                </td>
                <td>
                    <button class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded"
                            onclick="editPage({{ $page->id }})">Edytuj</button>
                    <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded"
                            onclick="deletePage({{ $page->id }})">Usuń</button>
                    <button class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded hidden"
                            onclick="updatePage({{ $page->id }})">Zapisz</button>
                    <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded hidden"
                            onclick="cancelEditPage({{ $page->id }})">Anuluj</button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <h2 class="text-xl font-semibold mt-6">Dodaj Nową Stronę</h2>
    <form id="dodajStroneForm" action="{{ route('pages.store') }}" method="POST" class="mt-4">
        @csrf
        <div class="mb-4">
            <input type="text" name="name" class="form-input w-64" placeholder="Nazwa" required>
        </div>
        <div class="mb-4">
            <textarea name="text" class="form-input w-64 h-40" placeholder="Treść" required></textarea>
        </div>
        <div class="mb-4">
            <input type="text" name="slug" class="form-input w-64" placeholder="Slug" required>
        </div>
        <button class="bg-green-500 hover.bg-green-600 text-white px-3 py-1 rounded">Dodaj</button>
    </form>
    <script>
        function editPage(id) {
            hideAllEditFields();
            document.getElementById('display_name_' + id).style.display = 'none';
            document.getElementById('edit_name_' + id).style.display = 'block';
            document.getElementById('display_text_' + id).style.display = 'none';
            document.getElementById('edit_text_' + id).style.display = 'block';
            document.getElementById('display_slug_' + id).style.display = 'none';
            document.getElementById('edit_slug_' + id).style.display = 'block';
            document.querySelector(`button[onclick="editPage(${id})"]`).style.display = 'none';
            document.querySelector(`button[onclick="updatePage(${id})"]`).style.display = 'block';
            document.querySelector(`button[onclick="cancelEditPage(${id})"]`).style.display = 'block';
        }

        function updatePage(id) {
            const newName = document.getElementById('edit_name_' + id).value;
            const newText = document.getElementById('edit_text_' + id).value;
            const newSlug = document.getElementById('edit_slug_' + id).value;
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            const data = {
                name: newName,
                text: newText,
                slug: newSlug
            };

            fetch(`/pages/update/${id}`, {
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
                        document.getElementById('display_name_' + id).textContent = newName;
                        document.getElementById('display_text_' + id).textContent = newText;
                        document.getElementById('display_slug_' + id).textContent = newSlug;
                        hideAllEditFields();
                    } else {
                        alert('Wystąpił błąd podczas aktualizacji strony.');
                    }
                })
                .catch(error => {
                    alert('Wystąpił błąd podczas aktualizacji strony: ' + error.message);
                });
        }

        function cancelEditPage(id) {
            hideAllEditFields();
        }

        function deletePage(id) {
            if (confirm('Czy na pewno chcesz usunąć tę stronę?')) {
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                fetch(`/pages/delete/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                    },
                })
                    .then(response => {
                        if (response.ok) {
                            const row = document.getElementById('row_' + id);
                            row.remove();
                        } else {
                            alert('Wystąpił błąd podczas usuwania strony.');
                        }
                    })
                    .catch(error => {
                        alert('Wystąpił błąd podczas usuwania strony: ' + error.message);
                    });
            }
        }

        function hideAllEditFields() {
            const editFields = document.querySelectorAll('[id^="edit_"]');
            editFields.forEach(field => field.style.display = 'none');
            const displayFields = document.querySelectorAll('[id^="display_"]');
            displayFields.forEach(field => field.style.display = 'block');
            const editButtons = document.querySelectorAll(`button[onclick^="editPage("]`);
            editButtons.forEach(button => button.style.display = 'block');
            const updateButtons = document.querySelectorAll(`button[onclick^="updatePage("]`);
            updateButtons.forEach(button => button.style.display = 'none');
            const cancelButtons = document.querySelectorAll(`button[onclick^="cancelEditPage("]`);
            cancelButtons.forEach(button => button.style.display = 'none');
        }
    </script>

    @if (session('error'))
        <div class="bg-red-200 text-red-800 p-2 my-4 rounded">
            {{ session('error') }}
        </div>
    @endif
</x-layout>
