<x-layout>
    <h1 class="text-2xl font-semibold mb-4">Panel admina {{ auth()->user()->name }}</h1>

    <nav class="mb-4">
        <ul>
            <li>
                <a href="{{ route('usersindex') }}" class="text-blue-500 hover:underline">Klienci</a>
            </li>
        </ul>
    </nav>

    <h1 class="text-2xl font-semibold mb-4">Lista użytkowników</h1>

    <div class="overflow-x-auto">
        <table class="min-w-full border border-collapse border-gray-300 rounded-lg">
            <thead class="bg-gray-100 border-b">
            <tr>
                <th class="px-4 py-2 border-r border-gray-500">Name</th>
                <th class="px-4 py-2 border-r border-gray-500">Email</th>
                <th class="px-4 py-2 border-r border-gray-500">User Type</th>
                <th class="px-4 py-2">Opis</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($users as $user)
                <tr class="border-b border-gray-500">
                    <td class="px-4 py-2 border-r border-gray-500">{{ $user->name }}</td>
                    <td class="px-4 py-2 border-r border-gray-500">{{ $user->email }}</td>
                    <td class="px-4 py-2 border-r border-gray-500">{{ $user->user_type }}</td>
                    <td class="px-4 py-2">
                        <form method="POST" action="{{ route('updateUserDescription', ['id' => $user->id]) }}">
                            @csrf
                            @method('PATCH')
                            <label for="opis">Opis:</label>
                            <textarea class="w-full max-w-sm border border-gray-500 rounded-lg p-2" name="opis" id="opis-{{ $user->id }}" rows="3" readonly>{{ $user->opis }}</textarea>
                            <button type="button" class="bg-blue-500 text-white p-1 rounded hover:bg-blue-600 hover:text-white editButton" data-userid="{{ $user->id }}">Edytuj</button>
                            <button type="submit" class="bg-green-500 text-white p-1 rounded hover:bg-green-600 hover:text-white saveButton hidden" data-userid="{{ $user->id }}">Zapisz</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    @if(session('success'))
        <div class="bg-green-200 text-green-800 p-2 my-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const editButtons = document.querySelectorAll('.editButton');
            const saveButtons = document.querySelectorAll('.saveButton');

            editButtons.forEach(editButton => {
                editButton.addEventListener('click', function() {
                    const userid = this.getAttribute('data-userid');
                    const opisInput = document.getElementById('opis-' + userid);
                    const saveButton = document.querySelector('.saveButton[data-userid="' + userid + '"]');

                    opisInput.removeAttribute('readonly');
                    opisInput.focus();
                    this.style.display = 'none';
                    saveButton.style.display = 'block';
                });
            });

            saveButtons.forEach(saveButton => {
                saveButton.addEventListener('click', function() {
                    const userid = this.getAttribute('data-userid');
                    const opisInput = document.getElementById('opis-' + userid);

                    const updatedOpis = opisInput.value;

                    fetch("{{ route('updateUserDescription', ['id' => 0]) }}".replace('0', userid), {
                        method: 'PATCH',
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}",
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({ opis: updatedOpis })
                    })
                        .then(response => {
                            if (response.ok) {
                                return response.json();
                            } else {
                                throw new Error('Błąd sieci. Status: ' + response.status + ' ' + response.statusText);
                            }
                        })
                        .then(data => {
                            if (data.success) {
                                opisInput.setAttribute('readonly', 'readonly');
                                this.style.display = 'none';
                                const editButton = document.querySelector('.editButton[data-userid="' + userid + '"]');
                                editButton.style.display = 'block';
                            } else {
                                alert('Wystąpił błąd podczas aktualizacji opisu: ' + data.error); // Wyświetl komunikat o błędzie po stronie serwera.
                            }
                        })
                        .catch(error => {
                            alert('Wystąpił błąd podczas aktualizacji opisu: ' + error.message);
                        });
                });
            });
        });
    </script>
</x-layout>
