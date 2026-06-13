<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin')</title>
    <link rel="icon" type="image/png" href="{{ asset('img/home/favicon.png') }}">
    <style>
        body {
            background: #f5f7ff;
        }

        .admin-sidebar {
            display: flex;
            flex-direction: column;
            width: 270px;
            box-sizing: border-box;
            padding: 28px 22px;
            background: linear-gradient(180deg, #2467FF, #174fd4);
            color: #fff;
            box-shadow: 8px 0 28px rgba(36, 103, 255, 0.18);
        }

        .admin-shell {
            display: flex;
            min-height: 100vh;
        }

        .admin-content {
            flex: 1;
            padding: 40px;
        }

        .admin-brand {
            display: block;
            padding: 16px;
            margin-bottom: 26px;
            border-radius: 18px;
            background: #fff;
            box-shadow: 0 12px 28px rgba(0, 0, 0, 0.12);
        }

        .admin-brand img {
            display: block;
            width: 100%;
            height: auto;
        }

        .admin-panel-title {
            margin: 0 0 16px;
            color: rgba(255, 255, 255, 0.78);
            font-size: 13px;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .admin-nav {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .admin-nav-link {
            color: #fff;
            font-weight: 700;
            padding: 14px 16px;
            border: 1px solid rgba(255, 255, 255, 0.16);
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.1);
            text-decoration: none;
            transition: background 0.2s ease, color 0.2s ease, transform 0.2s ease, padding-left 0.2s ease;
        }

        .admin-nav-link:hover {
            background: #FF823B;
            color: #fff;
            padding-left: 22px;
            transform: translateX(4px);
        }

        .logout-form {
            margin-top: auto;
        }

        .logout-button {
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 12px;
            background: #FF823B;
            color: #fff;
            font-weight: 800;
            cursor: pointer;
            box-shadow: 0 10px 24px rgba(255, 130, 59, 0.26);
            transition: background 0.2s ease, transform 0.2s ease;
        }

        .logout-button:hover {
            background: #e96f29;
            transform: translateY(-2px);
        }

        .admin-page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 28px;
            padding: 28px;
            border-radius: 22px;
            background: #fff;
            box-shadow: 0 16px 36px rgba(36, 103, 255, 0.1);
        }

        .admin-page-header h1 {
            margin: 0;
            color: #2467FF;
            font-size: 32px;
        }

        .admin-page-header p {
            margin: 8px 0 0;
            color: #6c757d;
        }

        .admin-badge {
            padding: 10px 16px;
            border-radius: 999px;
            background: #fff1e9;
            color: #FF823B;
            font-weight: 800;
            white-space: nowrap;
        }

        .admin-card-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
        }

        .admin-card {
            padding: 24px;
            border-radius: 18px;
            background: #fff;
            box-shadow: 0 14px 32px rgba(36, 103, 255, 0.1);
            border-top: 5px solid #2467FF;
        }

        .admin-card:nth-child(even) {
            border-top-color: #FF823B;
        }

        .admin-card h2 {
            margin: 0 0 10px;
            color: #222;
        }

        .admin-card p {
            margin: 0;
            color: #6c757d;
            line-height: 1.5;
        }

        @media (max-width: 768px) {
            .admin-shell {
                flex-direction: column;
            }

            .admin-sidebar {
                width: 100%;
                min-height: auto;
            }

            .admin-brand {
                max-width: 220px;
            }

            .admin-nav {
                flex-direction: row;
                flex-wrap: wrap;
            }

            .admin-nav-link {
                flex: 1;
                min-width: 120px;
                text-align: center;
            }

            .admin-nav-link:hover {
                padding-left: 14px;
                transform: none;
            }

            .logout-form {
                margin-top: 20px;
            }

            .admin-content {
                padding: 24px 16px;
            }

            .admin-page-header {
                align-items: flex-start;
                flex-direction: column;
                padding: 22px;
            }
        }

        @media (max-width: 480px) {
            .admin-nav {
                flex-direction: column;
            }

            .admin-nav-link {
                min-width: 0;
            }
        }
    </style>
</head>
<body style="margin: 0; font-family: Arial, sans-serif;">
    <div class="admin-shell">
        <aside class="admin-sidebar">
            <a href="{{ route('admin') }}" class="admin-brand">
                <img src="{{ asset('img/logo_motorSmart.png') }}" alt="Motor Smart logo">
            </a>

            <p class="admin-panel-title">Admin Panel</p>

            <nav class="admin-nav">
                <a href="{{ route('admin.users') }}" class="admin-nav-link">Users</a>
                <a href="{{ route('admin.categories') }}" class="admin-nav-link">Categories</a>
                <a href="{{ route('admin.products') }}" class="admin-nav-link">Products</a>
                <a href="{{ route('admin.configurations') }}" class="admin-nav-link">Configurations</a>
            </nav>

            <form method="POST" action="{{ route('logout') }}" class="logout-form">
                @csrf

                <button type="submit" class="logout-button">
                    Logout
                </button>
            </form>
        </aside>

        <main class="admin-content">
            @yield('content')
        </main>
    </div>
</body>
</html>
