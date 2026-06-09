<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Motor Smart') }}</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .navbar {
            display: flex;
            justify-content: flex-end;
            gap: 24px;
            padding: 20px 40px;
            border-bottom: 1px solid #e5e5e5;
        }

        .navbar a {
            color: #222;
            font-weight: 600;
            text-decoration: none;
        }

        .navbar a:hover {
            color: #0d6efd;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <a href="{{ route('home') }}">Home Page</a>
        <a href="{{ route('product') }}">Product Page</a>
        <a href="{{ route('about-us') }}">About Us Page</a>
        <a href="{{ route('contact-us') }}">Contact Us Page</a>
    </nav>

    @yield('content')
</body>
</html>
