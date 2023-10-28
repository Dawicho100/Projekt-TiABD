<x-layout>
    <x-box>

        <header class="text-center">
            <h2 class="text-2xl font-bold uppercase mb-1 ">
                Reset
            </h2>

        </header>

        <form method ="POST" action="{{route('reset.password.post')}}">
            @csrf

            <input type="text" name="token" hidden value="{{$token}}">
            <div class="mb-6">
                <label for="email" class="inline-block text-lg mb-2"
                >Email</label
                >
                <input
                    type="email"
                    class="border border-gray-200 rounded p-2 w-full"
                    name="email"
                />
                @error('email')
                <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>
            <div class="mb-6">
                <label
                    for="password"
                    class="inline-block text-lg mb-2"
                >
                    Password
                </label>
                <input
                    type="password"
                    class="border border-gray-200 rounded p-2 w-full"
                    name="password"

                />
                @error('password')
                <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label
                    for="password2"
                    class="inline-block text-lg mb-2"
                >
                    Confirm Password
                </label>
                <input
                    type="password"
                    class="border border-gray-200 rounded p-2 w-full"
                    name="password_confirmation"
                />
                @error('password_confirmation')
                <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>
            <div class="mb-6">
                <button
                    type="submit"
                    class="bg-zinc-400 text-white rounded py-2 px-4 hover:bg-black"
                >
                    Wyślij
                </button>
            </div>

            <div class="mt-8">
                <p>
                    Nie masz jeszcze konta?
                    <a href="/rejestracja" class="text-zinc-400 hover:text-black"
                    >Załóż konto</a
                    >
                </p>
            </div>
        </form>
    </x-box>
</x-layout>
