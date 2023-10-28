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
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            min-height: 100vh; /* Zapewnia, że cała strona zostanie wypełniona */
        }

        header {
            background-color: lightgray;
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

        footer {
            background-color: lightgray;
            padding: 10px;
            margin-top: auto; /* Przymocowanie stopki do dołu strony */
        }

        footer ul {
            display: flex;
        }

        footer ul li {
            margin-right: 20px;
        }
    </style>
    <title>Sklepex</title>
</head>
<body>
<header>
    <h1><a href="/" class="header-link hover:text-laravel">Sklepex</a> </h1>
    @auth()
        <ul class="text-lg">
            <li>
                <span class="font-bold uppercase">Welcome {{auth()->user()->name}}</span>
            </li>
            <li>
                @if (auth()->user()->user_type === 'admin')
                    <a href="/admin/dashboard"><i class="fa-solid fa-gear"></i> Profil</a>
                @elseif (auth()->user()->user_type === 'klient')
                    <a href="/dashboard"><i class="fa-solid fa-gear"></i> Profil</a>
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
</header>

{{--View Output--}}
{{$slot}}
<!-- resources/views/layouts/app.blade.php -->

<footer class="bg-lightgray p-4">
    <ul class="flex">
        @foreach($pages as $page)
            <li><a href="{{ route('page.show', ['slug' => $page->slug]) }}">{{ $page->name }}</a></li>
        @endforeach
    </ul>
</footer>



</body>
</html>
