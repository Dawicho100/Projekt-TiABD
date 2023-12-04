
<div class="bg-[#eeebeb] p-4">
    <h1 class="text-2xl font-semibold mb-4">Panel {{ auth()->user()->user_type = "admin" }}a {{ auth()->user()->name }}</h1>

    <ul class="space-y-2">
        <li></li>
        <li><a href="/klienci" class=" hover:text-white">Klienci</a></li>
        <li><a href="/dostawy" class="hover:text-white">Dostawy</a></li>
        <li><a href="/pages" class="hover:text-white">Strony</a></li>
        <li><a href="/categories" class="hover:text-white">Kategorie</a></li>
        <li><a href="/parameters" class=" hover:text-white">Parametry</a></li>
        <li><a href="/products" class="hover:text-white">Produkty</a></li>
        <li><a href="/orders" class="hover:text-white">Zamówienia</a></li>
    </ul>
</div>

{{$slot}}
