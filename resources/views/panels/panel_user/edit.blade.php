<!-- resources/views/users/edit.blade.php -->

<x-layout>
    <x-user>

    <div class="flex justify-between">
        <div class="w-2/3">
            <h1 class="text-3xl font-semibold mb-4">Edytuj użytkownika</h1>


            <form method="POST" action="{{ route('users.update', $user->id) }}" class="mt-4">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-600">Imię:</label>
                    <input type="text" class="form-input mt-1 block w-full rounded-md border-gray-300 shadow-sm" name="name" value="{{ $user->name }}">
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-600">Email:</label>
                    <input type="email" class="form-input mt-1 block w-full rounded-md border-gray-300 shadow-sm" name="email" value="{{ $user->email }}">
                </div>
                <div class="mb-4">
                    <label for="nrtel" class="block text-sm font-medium text-gray-600">Nr. telefonu:</label>
                    <input type="tel" class="form-input mt-1 block w-full rounded-md border-gray-300 shadow-sm" name="nrtel" value="{{ $user->nrtel }}">
                </div>

                <div class="mb-4">
                    <label for="adres" class="block text-sm font-medium text-gray-600">Adres:</label>
                    <input type="text" class="form-input mt-1 block w-full rounded-md border-gray-300 shadow-sm" name="adres" value="{{ $user->adres }}">
                </div>

                <div class="mb-4">
                    <label for="miasto" class="block text-sm font-medium text-gray-600">Miasto:</label>
                    <input type="text" class="form-input mt-1 block w-full rounded-md border-gray-300 shadow-sm" name="miasto" value="{{ $user->miasto }}">
                </div>

                <button class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">Zaktualizuj</button>
                <br><br>
                <div class="w-1/3 p-4 border border-gray-300 rounded">
                    <h2 class="text-xl font-semibold mb-2">Edytuj hasło</h2>


                    <div class="mb-4">
                        <label for="password" class="block text-sm font-medium text-gray-600">Nowe hasło:</label>
                        <input type="password" class="form-input mt-1 block w-full rounded-md border-gray-300 shadow-sm" name="password">
                    </div>

                    <div class="mb-4">
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-600">Powtórz hasło:</label>
                        <input type="password" class="form-input mt-1 block w-full rounded-md border-gray-300 shadow-sm" name="password_confirmation">
                    </div>

                    <button class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded" type="submit">Zaktualizuj hasło</button>
                </div>
            </form>

        </div>


    </div>
    @if (session('success'))
        <div class="bg-green-200 text-green-800 p-2 my-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="bg-red-200 text-red-800 p-2 my-4 rounded">
            @foreach ($errors->all() as $error)
                {{ $error }}<br>
            @endforeach
        </div>
    @endif
    </x-user>
</x-layout>
