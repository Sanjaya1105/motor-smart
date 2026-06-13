@extends('layouts.app')

@section('content')
    <style>
        .cart-page {
            padding: 54px 40px;
            background: #f5f7ff;
        }

        .cart-header {
            margin-bottom: 28px;
            padding: 30px;
            border-radius: 22px;
            background: linear-gradient(135deg, #2467FF, #174fd4);
            color: #fff;
        }

        .cart-header h1 {
            margin: 0 0 8px;
        }

        .cart-list {
            display: grid;
            gap: 12px;
        }

        .cart-item {
            display: grid;
            grid-template-columns: 80px 1fr auto;
            align-items: center;
            gap: 16px;
            padding: 12px;
            border-left: 5px solid #FF823B;
            border-radius: 14px;
            background: #fff;
            box-shadow: 0 12px 30px rgba(36, 103, 255, 0.1);
        }

        .cart-item img {
            width: 80px;
            height: 62px;
            border-radius: 8px;
            object-fit: cover;
        }

        .cart-item h2 {
            margin: 0 0 6px;
            font-size: 17px;
        }

        .cart-code,
        .cart-quantity {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 999px;
            font-weight: 800;
        }

        .cart-code {
            background: #eef3ff;
            color: #2467FF;
        }

        .cart-quantity {
            background: #fff1e9;
            color: #FF823B;
        }

        .cart-actions {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
            justify-content: flex-end;
        }

        .cart-qty-input {
            width: 84px;
            box-sizing: border-box;
            padding: 9px;
            border: 1px solid #d5dcff;
            border-radius: 8px;
            font-weight: 800;
        }

        .cart-update-button,
        .cart-delete-button {
            padding: 9px 12px;
            border: none;
            border-radius: 8px;
            font-weight: 800;
            cursor: pointer;
        }

        .cart-update-button {
            background: #2467FF;
            color: #fff;
        }

        .cart-delete-button {
            background: #dc3545;
            color: #fff;
        }

        @media (max-width: 640px) {
            .cart-page {
                padding: 36px 16px;
            }

            .cart-item {
                grid-template-columns: 1fr;
            }

            .cart-item img {
                width: 100%;
                height: 150px;
            }
        }
    </style>

    <main class="cart-page">
        <section class="cart-header">
            <h1>Cart</h1>
            <p>Products you added for quantity confirmation.</p>
        </section>

        <section class="cart-list">
            @if (session('success'))
                <p style="color: #198754; font-weight: 800;">{{ session('success') }}</p>
            @endif

            @forelse ($cartItems as $item)
                <article class="cart-item">
                    <img src="{{ asset($item['image_path']) }}" alt="{{ $item['name'] }}">

                    <div>
                        <h2>{{ $item['name'] }}</h2>
                        <span class="cart-code">Code: {{ $item['item_code'] ?? 'N/A' }}</span>
                    </div>

                    <div class="cart-actions">
                        <form method="POST" action="{{ route('cart.update', $item['product_id']) }}" class="cart-actions">
                            @csrf

                            <input
                                type="number"
                                name="quantity"
                                value="{{ $item['quantity'] }}"
                                min="1"
                                class="cart-qty-input"
                                aria-label="Quantity for {{ $item['name'] }}"
                            >
                            <button type="submit" class="cart-update-button">Update</button>
                        </form>

                        <form method="POST" action="{{ route('cart.remove', $item['product_id']) }}" onsubmit="return confirm('Remove this product from cart?');">
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="cart-delete-button">Delete</button>
                        </form>
                    </div>
                </article>
            @empty
                <p style="padding: 18px; border-radius: 10px; background: #fff; color: #6c757d;">Your cart is empty.</p>
            @endforelse
        </section>
    </main>
@endsection
