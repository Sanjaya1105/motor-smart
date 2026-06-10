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

        .contact-bar {
            display: flex;
            gap: 28px;
            padding: 8px 40px;
            background: #FF823B;
            color: #fff;
            font-size: 14px;
            font-weight: 600;
        }

        .top-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 40px;
            padding: 24px 40px;
            background: #fff;
        }

        .site-logo img {
            display: block;
            max-height: 70px;
            width: auto;
        }

        .search-form {
            display: flex;
            width: 100%;
            max-width: 520px;
            margin: 0 auto;
        }

        .search-input {
            flex: 1;
            padding: 12px 14px;
            border: 1px solid #d9d9d9;
            border-radius: 4px 0 0 4px;
            font-size: 14px;
        }

        .search-button {
            padding: 12px 18px;
            border: none;
            border-radius: 0 4px 4px 0;
            background: #FF823B;
            color: #fff;
            font-weight: 700;
            cursor: pointer;
        }

        .navbar {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 24px;
            padding: 16px 40px;
            background: #2467FF;
        }

        .navbar a {
            color: #fff;
            font-weight: 600;
            text-decoration: none;
        }

        .navbar a:hover {
            color: #FF823B;
        }

        .user-menu {
            position: relative;
        }

        .user-menu-button {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 38px;
            height: 38px;
            border: none;
            border-radius: 50%;
            background: #FF823B;
            color: #fff;
            cursor: pointer;
            font-size: 18px;
            font-weight: 700;
        }

        .user-dropdown {
            display: none;
            position: absolute;
            top: 48px;
            right: 0;
            min-width: 150px;
            padding: 8px;
            border: 1px solid #e5e5e5;
            border-radius: 8px;
            background: #fff;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
            z-index: 10;
        }

        .user-dropdown.show {
            display: block;
        }

        .user-dropdown a,
        .user-dropdown button {
            display: block;
            width: 100%;
            box-sizing: border-box;
            padding: 10px 12px;
            border: none;
            border-radius: 6px;
            background: transparent;
            color: #222;
            font: inherit;
            font-weight: 600;
            text-align: left;
            text-decoration: none;
            cursor: pointer;
        }

        .user-dropdown a:hover,
        .user-dropdown button:hover {
            background: #FF823B;
            color: #fff;
        }

        .top-header-spacer {
            width: 180px;
        }

        @media (max-width: 768px) {
            .contact-bar {
                flex-direction: column;
                gap: 4px;
                padding: 10px 16px;
                text-align: center;
            }

            .top-header {
                flex-direction: column;
                gap: 18px;
                padding: 20px 16px;
            }

            .site-logo img {
                max-height: 56px;
            }

            .search-form {
                max-width: 100%;
            }

            .top-header-spacer {
                display: none;
            }

            .navbar {
                justify-content: center;
                flex-wrap: wrap;
                gap: 14px;
                padding: 14px 16px;
            }

            .navbar a {
                font-size: 14px;
            }

            .user-dropdown {
                right: 50%;
                transform: translateX(50%);
            }
        }

        @media (max-width: 480px) {
            .search-form {
                flex-direction: column;
                gap: 8px;
            }

            .search-input,
            .search-button {
                width: 100%;
                box-sizing: border-box;
                border-radius: 4px;
            }

            .navbar {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="contact-bar">
        <span>Telephone: +94 70 101 4000</span>
        <span>Email: lankaspareparts.lk@gmail.com</span>
    </div>

    <header class="top-header">
        <a href="{{ route('home1') }}" class="site-logo">
            <img src="{{ asset('img/logo_motorSmart.png') }}" alt="Motor Smart logo">
        </a>

        <form class="search-form" action="#" method="GET">
            <input
                type="search"
                name="search"
                class="search-input"
                placeholder="Search here..."
            >
            <button type="submit" class="search-button">Search</button>
        </form>

        <div class="top-header-spacer"></div>
    </header>

    <nav class="navbar">
        <a href="{{ route('home1') }}">Home Page</a>
        <a href="{{ route('product') }}">Product Page</a>
        <a href="{{ route('about-us') }}">About Us Page</a>
        <a href="{{ route('contact-us') }}">Contact Us Page</a>
        <div class="user-menu">
            <button type="button" class="user-menu-button" id="user-menu-button" aria-label="Open user menu">
                &#128100;
            </button>

            <div class="user-dropdown" id="user-dropdown">
                <a href="{{ route('profile') }}">Profile</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button type="submit">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    @yield('content')

    <script>
        const userMenuButton = document.getElementById('user-menu-button');
        const userDropdown = document.getElementById('user-dropdown');

        userMenuButton.addEventListener('click', function () {
            userDropdown.classList.toggle('show');
        });

        document.addEventListener('click', function (event) {
            if (!event.target.closest('.user-menu')) {
                userDropdown.classList.remove('show');
            }
        });
    </script>
</body>
</html>
