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
            background: #FF823B;
        }

        .navbar a {
            color: #fff;
            font-weight: 600;
            text-decoration: none;
        }

        .navbar > a:not(.cart-link) {
            position: relative;
            padding: 9px 12px;
            border-radius: 999px;
            overflow: hidden;
            transition: color 0.25s ease, transform 0.25s ease, background 0.25s ease, box-shadow 0.25s ease;
        }

        .navbar > a:not(.cart-link)::after {
            content: "";
            position: absolute;
            left: 14px;
            right: 14px;
            bottom: 5px;
            height: 3px;
            border-radius: 999px;
            background: #2467FF;
            transform: scaleX(0);
            transform-origin: center;
            transition: transform 0.25s ease;
        }

        .navbar > a:not(.cart-link):hover {
            background: #fff;
            color: #2467FF;
            transform: translateY(-3px);
            box-shadow: 0 10px 22px rgba(36, 103, 255, 0.22);
        }

        .navbar > a:not(.cart-link):hover::after {
            transform: scaleX(1);
        }

        .user-menu {
            position: relative;
        }

        .cart-link {
            position: relative;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: #2467FF;
            color: #fff;
            font-size: 18px;
            text-decoration: none;
            transition: transform 0.25s ease, box-shadow 0.25s ease, background 0.25s ease;
        }

        .cart-link:hover {
            background: #174fd4;
            color: #fff;
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 10px 22px rgba(36, 103, 255, 0.28);
        }

        .cart-count {
            position: absolute;
            top: -8px;
            right: -8px;
            min-width: 20px;
            height: 20px;
            padding: 0 5px;
            border-radius: 999px;
            background: #fff;
            color: #2467FF;
            font-size: 12px;
            font-weight: 900;
            line-height: 20px;
            text-align: center;
        }

        .mini-cart-box {
            position: fixed;
            top: 210px;
            right: 18px;
            width: 280px;
            max-height: 360px;
            overflow: auto;
            border-top: 5px solid #FF823B;
            border-radius: 16px;
            background: #fff;
            box-shadow: 0 18px 45px rgba(36, 103, 255, 0.2);
            z-index: 45;
        }

        .mini-cart-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            gap: 12px;
            padding: 14px 16px;
            border: none;
            background: #eef3ff;
            cursor: pointer;
            font: inherit;
            text-align: left;
        }

        .mini-cart-header strong {
            color: #2467FF;
        }

        .mini-cart-header-right {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .mini-cart-toggle-icon {
            display: inline-block;
            color: #2467FF;
            font-size: 15px;
            transition: transform 0.2s ease;
        }

        .mini-cart-box.is-collapsed .mini-cart-items {
            display: none;
        }

        .mini-cart-box.is-collapsed .mini-cart-toggle-icon {
            transform: rotate(-90deg);
        }

        .mini-cart-total {
            padding: 4px 9px;
            border-radius: 999px;
            background: #FF823B;
            color: #fff;
            font-size: 12px;
            font-weight: 900;
        }

        .mini-cart-items {
            display: grid;
            gap: 8px;
            padding: 12px;
        }

        .mini-cart-item {
            display: grid;
            grid-template-columns: 44px 1fr auto auto;
            align-items: center;
            gap: 10px;
            padding-bottom: 8px;
            border-bottom: 1px solid #eef3ff;
        }

        .mini-cart-item:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .mini-cart-item img {
            width: 44px;
            height: 38px;
            border-radius: 8px;
            object-fit: cover;
            background: #eef3ff;
        }

        .mini-cart-item-name {
            display: block;
            color: #222;
            font-size: 13px;
            font-weight: 800;
        }

        .mini-cart-item-code {
            display: block;
            color: #6c757d;
            font-size: 11px;
            margin-top: 3px;
        }

        .mini-cart-qty {
            padding: 4px 8px;
            border-radius: 999px;
            background: #fff1e9;
            color: #FF823B;
            font-size: 12px;
            font-weight: 900;
        }

        .mini-cart-remove-form {
            margin: 0;
        }

        .mini-cart-delete-button {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 28px;
            height: 28px;
            border: none;
            border-radius: 50%;
            background: #dc3545;
            color: #fff;
            cursor: pointer;
            font-size: 15px;
            line-height: 1;
        }

        .mini-cart-delete-button:hover {
            background: #b02a37;
        }

        .mini-cart-link {
            display: block;
            width: calc(100% - 24px);
            box-sizing: border-box;
            margin: 0 12px 12px;
            padding: 10px;
            border: none;
            border-radius: 10px;
            background: #25D366;
            color: #fff;
            cursor: pointer;
            font: inherit;
            font-weight: 800;
            text-align: center;
            text-decoration: none;
        }

        .mini-cart-link:hover {
            background: #1da851;
        }

        .user-menu-button {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 38px;
            height: 38px;
            border: none;
            border-radius: 50%;
            background: #2467FF;
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

        .whatsapp-float {
            position: fixed;
            right: 22px;
            bottom: 22px;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 58px;
            height: 58px;
            border-radius: 50%;
            background: #25D366;
            color: #fff;
            text-decoration: none;
            box-shadow: 0 12px 28px rgba(37, 211, 102, 0.35);
            z-index: 50;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .whatsapp-float:hover {
            transform: translateY(-4px);
            box-shadow: 0 16px 36px rgba(37, 211, 102, 0.45);
        }

        .whatsapp-float svg {
            width: 30px;
            height: 30px;
            fill: currentColor;
        }

        .site-footer {
            padding: 48px 40px 20px;
            background: linear-gradient(135deg, #174fd4, #2467FF);
            color: #fff;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 1.2fr repeat(3, minmax(160px, 1fr));
            gap: 28px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .footer-logo {
            display: inline-block;
            padding: 12px;
            margin-bottom: 16px;
            border-radius: 14px;
            background: #fff;
        }

        .footer-logo img {
            display: block;
            max-width: 190px;
            height: auto;
        }

        .site-footer h3 {
            margin: 0 0 14px;
            color: #fff;
        }

        .site-footer p,
        .site-footer a {
            color: rgba(255, 255, 255, 0.86);
            line-height: 1.7;
            text-decoration: none;
        }

        .site-footer a:hover {
            color: #FF823B;
        }

        .footer-links {
            display: grid;
            gap: 8px;
        }

        .footer-highlight {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 999px;
            background: #FF823B;
            color: #fff;
            font-weight: 800;
        }

        .footer-bottom {
            max-width: 1200px;
            margin: 34px auto 0;
            padding-top: 18px;
            border-top: 1px solid rgba(255, 255, 255, 0.2);
            color: rgba(255, 255, 255, 0.75);
            text-align: center;
            font-size: 14px;
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

            .mini-cart-box {
                position: static;
                width: auto;
                max-height: none;
                margin: 16px;
            }

            .site-footer {
                padding: 38px 18px 18px;
            }

            .footer-grid {
                grid-template-columns: 1fr;
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

            .whatsapp-float {
                right: 16px;
                bottom: 16px;
                width: 52px;
                height: 52px;
            }
        }
    </style>
</head>
<body>
    <div class="contact-bar">
        <span>Telephone: 011 2244445 / 071 796 9685</span>
        <span>Email: motorsmart@gmail.com</span>
    </div>

    <header class="top-header">
        <a href="{{ route('home1') }}" class="site-logo">
            <img src="{{ asset('img/logo_motorSmart.png') }}" alt="Motor Smart logo">
        </a>

        <form class="search-form" action="{{ route('product') }}" method="GET">
            <input
                type="search"
                name="search"
                class="search-input"
                value="{{ request('search') }}"
                placeholder="Search products, item codes, keywords..."
            >
            <button type="submit" class="search-button">Search</button>
        </form>

        <div class="top-header-spacer"></div>
    </header>

    @php
        $cartItems = session('cart', []);
        $cartCount = array_sum(array_column($cartItems, 'quantity'));
        $showMiniCartBeforeContent = request()->routeIs('product');
        $loggedUser = auth()->user();
        $orderLines = [
            'Merchant name: ' . ($loggedUser?->merchant_name ?: $loggedUser?->name ?: 'Not provided')
                . ' | Phone: ' . ($loggedUser?->phone_number ?: 'Not provided')
                . ' | Address: ' . ($loggedUser?->address ?: 'Not provided'),
            '',
        ];

        foreach (array_values($cartItems) as $index => $cartItem) {
            $orderLines[] = '**PRODUCT ' . str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT)
                . '** ' . ($cartItem['name'] ?? 'Product')
                . ' | Item code: ' . ($cartItem['item_code'] ?? 'N/A');
            $orderLines[] = 'quantity - ' . ($cartItem['quantity'] ?? 0);
            $orderLines[] = '';
        }

        $whatsappOrderUrl = 'https://wa.me/94717969685?text=' . rawurlencode(implode("\n", $orderLines));
    @endphp

    <nav class="navbar">
        <a href="{{ route('home1') }}">Home</a>
        <a href="{{ route('product') }}">Product</a>
        <a href="{{ route('about-us') }}">About Us</a>
        <a href="{{ route('contact-us') }}">Contact Us</a>
        <a href="{{ route('cart') }}" class="cart-link" aria-label="View cart">
            🛒
            <span class="cart-count">{{ $cartCount }}</span>
        </a>
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

    @if ($cartCount > 0 && $showMiniCartBeforeContent)
        @include('partials.mini-cart-summary')
    @endif

    @yield('content')

    @if ($cartCount > 0 && ! $showMiniCartBeforeContent)
        @include('partials.mini-cart-summary')
    @endif

    <footer class="site-footer">
        <div class="footer-grid">
            <div>
                <a href="{{ route('home1') }}" class="footer-logo">
                    <img src="{{ asset('img/logo_motorSmart.png') }}" alt="Motor Smart logo">
                </a>
                <p>
                    Wholesale spare parts supply for bearings, oil seals, lower arms, and other fast-moving vehicle parts.
                </p>
                <span class="footer-highlight">Trusted by wholesale buyers</span>
            </div>

            <div>
                <h3>Quick Links</h3>
                <div class="footer-links">
                    <a href="{{ route('home1') }}">Home</a>
                    <a href="{{ route('product') }}">Product</a>
                    <a href="{{ route('about-us') }}">About Us</a>
                    <a href="{{ route('contact-us') }}">Contact Us</a>
                </div>
            </div>

            <div>
                <h3>Contact</h3>
                <p>Telephone: 011 2244445 / 071 796 9685</p>
                <p>Email: motorsmart@gmail.com</p>
                <p>WhatsApp: 071 796 9685</p>
            </div>

            <div>
                <h3>Address</h3>
                <p>334/C/3,<br>Batagama South,<br>Kandana</p>
            </div>
        </div>

        <div class="footer-bottom">
            © {{ date('Y') }} Motor Smart. Developed by <a href="https://prixmalabs.com" target="_blank" rel="noopener">Prixma Labs</a>.
        </div>
    </footer>

    <a
        href="https://wa.me/94717969685"
        class="whatsapp-float"
        target="_blank"
        rel="noopener"
        aria-label="Chat with us on WhatsApp"
    >
        <svg viewBox="0 0 32 32" aria-hidden="true">
            <path d="M16.01 3.2c-7.05 0-12.78 5.72-12.78 12.76 0 2.25.59 4.45 1.72 6.39L3.12 29l6.82-1.79a12.74 12.74 0 0 0 6.07 1.55h.01c7.04 0 12.77-5.72 12.77-12.76S23.06 3.2 16.01 3.2Zm0 23.4h-.01a10.6 10.6 0 0 1-5.39-1.48l-.39-.23-4.04 1.06 1.08-3.94-.25-.4a10.55 10.55 0 0 1-1.62-5.65c0-5.85 4.76-10.6 10.62-10.6 2.84 0 5.51 1.1 7.52 3.11a10.53 10.53 0 0 1 3.11 7.5c0 5.85-4.77 10.61-10.63 10.61Zm5.82-7.94c-.32-.16-1.89-.93-2.18-1.04-.29-.11-.5-.16-.71.16-.21.32-.82 1.04-1.01 1.25-.19.21-.37.24-.69.08-.32-.16-1.34-.49-2.55-1.57-.94-.84-1.58-1.88-1.77-2.2-.19-.32-.02-.49.14-.65.14-.14.32-.37.48-.56.16-.19.21-.32.32-.53.11-.21.05-.4-.03-.56-.08-.16-.71-1.71-.98-2.34-.26-.62-.52-.53-.71-.54h-.61c-.21 0-.56.08-.85.4-.29.32-1.11 1.09-1.11 2.65s1.14 3.08 1.3 3.29c.16.21 2.24 3.43 5.43 4.8.76.33 1.35.52 1.81.67.76.24 1.45.21 2 .13.61-.09 1.89-.77 2.15-1.52.27-.75.27-1.39.19-1.52-.08-.13-.29-.21-.61-.37Z"/>
        </svg>
    </a>

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

        const sendOrderLink = document.getElementById('send-order-link');

        if (sendOrderLink) {
            sendOrderLink.addEventListener('click', function () {
                fetch(sendOrderLink.dataset.clearUrl, {
                    method: 'POST',
                    keepalive: true,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                }).then(function () {
                    const miniCartBox = document.querySelector('.mini-cart-box');

                    if (miniCartBox) {
                        miniCartBox.remove();
                    }

                    document.querySelectorAll('.cart-count').forEach(function (cartCount) {
                        cartCount.textContent = '0';
                    });
                });
            });
        }

        const miniCartBox = document.querySelector('.mini-cart-box');
        const miniCartToggle = document.getElementById('mini-cart-toggle');

        if (miniCartBox && miniCartToggle) {
            miniCartToggle.addEventListener('click', function () {
                const isCollapsed = miniCartBox.classList.toggle('is-collapsed');

                miniCartToggle.setAttribute('aria-expanded', String(!isCollapsed));
            });
        }
    </script>
</body>
</html>
