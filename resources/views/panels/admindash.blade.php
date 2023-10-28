<x-layout>


    <h1>panel admina  {{auth()->user()->name}} </h1>
    <li>
        <ul><a href="/klienci">klienci</a> </ul>
        <ul><a href="/dostawy">dostawy</a></ul>
        <ul><a href="/platnosci">platności</a></ul>
        <ul><a href="/pages">Strony</a></ul>
    </li>
</x-layout>





