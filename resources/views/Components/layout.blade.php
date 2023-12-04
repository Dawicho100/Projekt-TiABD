<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        laravel: "#ef3b2d",
                    },
                },
            },
        };
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        .carousel-container {
            max-height: 500px; /* Dostosuj wysokość według własnych preferencji */
            overflow: hidden;
            align-items: center;
            justify-content: center;
        }

        .carousel img {
            max-height: 100%; /* Spraw, aby obrazy w karuzeli zajmowały maksymalną dostępną wysokość */
            width: auto; /* Zapobiegaj przycinaniu obrazów */
            align-self: center;
        }
        body {

            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            min-height: 100vh; /* Zapewnia, że cała strona zostanie wypełniona */
        }

        header {
            background-color: #eeebeb;
            padding: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .tytul-podstrony{
            font-size: 50px;
            text-align: center;
        }
        .tresc-podstrony{

            text-align: center;
        }
        h1 {
            margin: 0;
            font-size: 24px;
            font-weight: bold;
        }

        ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
            gap: 20px;
        }

        ul li {
            display: inline;
        }

        .header-link {
            text-decoration: none;
            color: inherit;
            font-weight: bold;
            font-size: 16px;
        }

        .bg-lightgray {
            background-color: lightgray;
        }

        .p-4 {
            padding: 1rem;
        }
        .produkt {
            border-style: solid;
            border-color: black;
            padding: 5px;
            margin: 5px;
            align-self: center;


        }
        footer {
            background-color: #eeebeb;
            padding: 10px;
            margin-top: auto; /* Przymocowanie stopki do dołu strony */
        }

        footer ul {
            display: flex;
        }

        footer ul li {
            margin-right: 20px;
        }
        table {
            border-color: lightgrey;
            border-style: solid;
        }
        .dropbtn {
            color: black;
            padding: 16px;
            font-size: 16px;
            border: none;
        }

        .dropdown {
            position: relative;
            display: inline-block;

        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f1f1f1;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
        }

        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }
        .dropdown-content a:hover {background-color: #ddd;}

        .dropdown:hover .dropdown-content {display: block;}

        .dropdown:hover .dropbtn {color: red;}

    </style>
    <title>Sklepex</title>
    </head>
    <body>
    <header>
        <h1><a href="/" class="header-link hover:text-laravel">Sklepex</a> </h1>
        <div class="dropdown">
            <button class="dropbtn">Kategorie</button>
            <div class="dropdown-content">
                @foreach ($categories as $category)


                    <a href="{{ route('products.index1', ['category' => $category->id]) }}"> {{ $category->name }}</a>



                @endforeach

            </div>
        </div>
        @auth()
            <ul class="text-lg">

                <li>
                    @if (auth()->user()->user_type === 'admin')
                        <a href="/admin/dashboard"><i class="fa-solid fa-gear"></i> Profil</a>
                    @elseif (auth()->user()->user_type === 'klient')
                        <a href="/dashboard"><i class="fa-solid fa-gear"></i> {{auth()->user()->name}}</a>
                    @endif

                </li>
                <li>
                    <form class="inline" method="post" action="/logout">
                        @csrf
                        <button type="submit" class="header-link">
                            <i class="fa-solid fa-door-closed"></i> Logout
                        </button>
                    </form>
                </li>

            </ul>
        @else
            <a class="header-link hover:text-laravel" href="/logowanie">Zaloguj się</a>
        @endauth

        <div id="app">
            <!-- ... reszta layoutu ... -->

            <!-- Ikona koszyka -->
            <a href="{{ route('cart.show') }}" class="text-red-500 hover:text-red-600 ml-4">
                <i class="fas fa-shopping-cart fa-2x"></i>
            </a>
        </div>
    </header>

{{--View Output--}}
{{$slot}}
<!-- resources/views/layouts/app.blade.php -->

<footer class="bg-lightgray p-4">
    <ul class="flex">
        @foreach($pages as $page)
            <li><a href="{{ route('pages.show', ['slug' => $page->slug]) }}">{{ $page->name }}</a></li>
        @endforeach
    </ul>
</footer>



</body>
</html>
