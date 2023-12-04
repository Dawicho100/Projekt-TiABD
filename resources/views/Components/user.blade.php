
<div class="bg-[#eeebeb] p-4">
    <h1 class="text-2xl font-semibold mb-4">Panel {{ auth()->user()->user_type = "klient" }}a {{ auth()->user()->name }}</h1>

    <ul class="space-y-2">
        <li></li>
        <li>  <a href="{{ route('users.edit', ['id' => auth()->user()->id]) }}">Edytuj użytkownika</a></li>
        <li><a href="/orders1">Zamowienia</a></li>  </li>
        <li><a href="/favorite-products">Ulubione</a></li>
    </ul>
</div>

{{$slot}}
