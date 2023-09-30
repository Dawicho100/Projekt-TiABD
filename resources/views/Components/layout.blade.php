<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        laravel: "#ef3b2d",
                    },
                },p
            },
        };
    </script>
    <style>
        header {
            background-color: lightgray;
            padding: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
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
                <a class="header-link hover:text-laravel" href="/konto">
                    <i class="fa-solid fa-gear"></i> Profil
                </a>
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
<footer>

</footer>
</body>
</html>
