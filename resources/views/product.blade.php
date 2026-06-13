@extends('layouts.app')

@section('content')
    <style>
        .user-products-page {
            padding: 54px 40px;
            background: #f5f7ff;
        }

        .products-hero {
            margin-bottom: 32px;
            padding: 34px;
            border-radius: 24px;
            background: linear-gradient(135deg, #2467FF, #174fd4);
            color: #fff;
            box-shadow: 0 18px 45px rgba(36, 103, 255, 0.18);
        }

        .products-hero h1 {
            margin: 0 0 10px;
            font-size: clamp(32px, 4vw, 48px);
        }

        .products-hero p {
            max-width: 720px;
            margin: 0;
            color: rgba(255, 255, 255, 0.88);
            line-height: 1.7;
        }

        .user-product-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
            width: 100%;
        }

        .user-product-card {
            display: grid;
            grid-template-columns: 78px 1fr auto;
            gap: 12px;
            width: 100%;
            box-sizing: border-box;
            padding: 8px 12px;
            border-left: 5px solid #FF823B;
            border-radius: 14px;
            background: #fff;
            box-shadow: 0 12px 30px rgba(36, 103, 255, 0.1);
        }

        .user-product-image {
            width: 78px;
            height: 58px;
            border-radius: 8px;
            object-fit: cover;
            background: #eef3ff;
        }

        .user-product-content {
            padding: 0;
        }

        .user-product-card h2 {
            margin: 0 0 4px;
            color: #222;
            font-size: 16px;
        }

        .product-code {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 999px;
            background: #eef3ff;
            color: #2467FF;
            font-size: 15px;
            font-weight: 800;
        }

        .product-card-actions {
            justify-self: end;
            align-self: center;
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            justify-content: flex-end;
        }

        .product-details-button,
        .product-cart-button {
            padding: 9px 14px;
            border: none;
            border-radius: 999px;
            color: #fff;
            font-size: 13px;
            font-family: inherit;
            font-weight: 800;
            text-decoration: none;
            cursor: pointer;
        }

        .product-details-button {
            background: #FF823B;
        }

        .product-cart-button {
            background: #2467FF;
        }

        .product-details-button:hover,
        .product-cart-button:hover {
            background: #2467FF;
        }

        .product-cart-button:hover {
            background: #FF823B;
        }

        .cart-modal {
            display: none;
            position: fixed;
            inset: 0;
            align-items: center;
            justify-content: center;
            padding: 18px;
            background: rgba(0, 0, 0, 0.48);
            z-index: 100;
        }

        .cart-modal.show {
            display: flex;
        }

        .cart-modal-card {
            width: 100%;
            max-width: 440px;
            padding: 26px;
            border-radius: 18px;
            background: #fff;
            box-shadow: 0 24px 60px rgba(0, 0, 0, 0.24);
        }

        .cart-modal-card h2 {
            margin-top: 0;
            color: #2467FF;
        }

        .cart-field {
            margin-bottom: 16px;
        }

        .cart-field label {
            display: block;
            margin-bottom: 8px;
            font-weight: 800;
        }

        .cart-field input {
            width: 100%;
            box-sizing: border-box;
            padding: 12px;
            border: 1px solid #d5dcff;
            border-radius: 8px;
        }

        .cart-modal-actions {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
        }

        .cart-submit,
        .cart-cancel {
            padding: 11px 16px;
            border: none;
            border-radius: 8px;
            font-weight: 800;
            cursor: pointer;
        }

        .cart-submit {
            background: #FF823B;
            color: #fff;
        }

        .cart-submit:disabled {
            background: #cfd6e6;
            cursor: not-allowed;
        }

        .cart-cancel {
            background: #eef3ff;
            color: #2467FF;
        }

        .pagination {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 28px;
            padding: 0;
            list-style: none;
        }

        .pagination a,
        .pagination span {
            display: inline-block;
            padding: 9px 13px;
            border-radius: 8px;
            background: #fff;
            color: #2467FF;
            font-weight: 700;
            text-decoration: none;
            box-shadow: 0 8px 18px rgba(36, 103, 255, 0.08);
        }

        .pagination .active span {
            background: #FF823B;
            color: #fff;
        }

        .pagination .disabled span {
            color: #adb5bd;
        }

        .product-page-search {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            padding: 16px;
            border-radius: 16px;
            background: #fff;
            box-shadow: 0 10px 24px rgba(36, 103, 255, 0.08);
        }

        .product-page-search input {
            flex: 1;
            min-width: 0;
            padding: 12px 14px;
            border: 1px solid #d5dcff;
            border-radius: 10px;
            font: inherit;
        }

        .product-page-search button,
        .product-page-search a {
            padding: 12px 16px;
            border: none;
            border-radius: 10px;
            font: inherit;
            font-weight: 800;
            text-decoration: none;
            cursor: pointer;
        }

        .product-page-search button {
            background: #2467FF;
            color: #fff;
        }

        .product-page-search a {
            background: #eef3ff;
            color: #2467FF;
        }

        .search-result-note {
            margin: 0 0 18px;
            padding: 14px 16px;
            border-left: 5px solid #FF823B;
            border-radius: 12px;
            background: #fff;
            color: #2467FF;
            font-weight: 800;
            box-shadow: 0 10px 24px rgba(36, 103, 255, 0.08);
        }

        .search-result-note a {
            color: #FF823B;
            font-weight: 900;
            text-decoration: none;
        }

        @media (max-width: 640px) {
            .user-products-page {
                padding: 36px 16px;
            }

            .products-hero {
                padding: 24px;
            }

            .user-product-card {
                grid-template-columns: 1fr;
            }

            .user-product-image {
                width: 100%;
                height: 120px;
            }

            .product-card-actions {
                justify-self: start;
                justify-content: flex-start;
            }

            .product-page-search {
                flex-direction: column;
            }
        }
    </style>

    <main class="user-products-page">
        @if (session('success'))
            <p style="color: #198754; font-weight: 800;">{{ session('success') }}</p>
        @endif

        <section class="products-hero">
            <h1>Products</h1>
            <p>Browse products added by the admin for wholesale customers. Use item codes and categories to identify the right spare parts for your business orders.</p>
        </section>

        <form class="product-page-search" action="{{ route('product') }}" method="GET">
            <input
                type="search"
                name="search"
                value="{{ $search }}"
                placeholder="Search by product name, item code, or keywords..."
            >
            <button type="submit">Search</button>
            @if ($search !== '')
                <a href="{{ route('product') }}">Clear</a>
            @endif
        </form>

        @if ($search !== '')
            <p class="search-result-note">
                Showing products for "{{ $search }}".
                <a href="{{ route('product') }}">Clear search</a>
            </p>
        @endif

        <section class="user-product-list">
            @forelse ($products as $product)
                <article class="user-product-card">
                    <img src="{{ asset($product->image_path) }}" alt="{{ $product->name }}" class="user-product-image">

                    <div class="user-product-content">
                        <h2>{{ $product->name }}</h2>
                        <span class="product-code">Code: {{ $product->item_code ?? 'N/A' }}</span>
                    </div>

                    <div class="product-card-actions">
                        <a href="{{ route('product.details', $product) }}" class="product-details-button">Details</a>
                        <button
                            type="button"
                            class="product-cart-button"
                            data-product-id="{{ $product->id }}"
                            data-product-name="{{ $product->name }}"
                        >
                            Add to Cart
                        </button>
                    </div>
                </article>
            @empty
                <p style="padding: 18px; border-radius: 10px; background: #fff; color: #6c757d;">
                    {{ $search !== '' ? 'No products matched your search.' : 'No products available yet.' }}
                </p>
            @endforelse
        </section>

        {{ $products->links() }}

        <div class="cart-modal" id="cart-modal" aria-hidden="true">
            <form method="POST" action="{{ route('cart.add') }}" class="cart-modal-card">
                @csrf

                <h2>Add to Cart</h2>
                <input type="hidden" name="product_id" id="cart_product_id">

                <div class="cart-field">
                    <label for="cart_product_name">Product Name</label>
                    <input type="text" id="cart_product_name" readonly>
                </div>

                <div class="cart-field">
                    <label for="cart_quantity">Quantity</label>
                    <input type="number" id="cart_quantity" name="quantity" min="1" required>
                </div>

                <div class="cart-modal-actions">
                    <button type="button" class="cart-cancel" id="close-cart-modal">Cancel</button>
                    <button type="submit" class="cart-submit" id="cart-submit" disabled>Submit</button>
                </div>
            </form>
        </div>
    </main>

    <script>
        const cartModal = document.getElementById('cart-modal');
        const closeCartModal = document.getElementById('close-cart-modal');
        const cartProductId = document.getElementById('cart_product_id');
        const cartProductName = document.getElementById('cart_product_name');
        const cartQuantity = document.getElementById('cart_quantity');
        const cartSubmit = document.getElementById('cart-submit');
        const cartButtons = document.querySelectorAll('.product-cart-button');

        function closeModal() {
            cartModal.classList.remove('show');
            cartProductId.value = '';
            cartProductName.value = '';
            cartQuantity.value = '';
            cartSubmit.disabled = true;
        }

        cartButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                cartProductId.value = button.dataset.productId;
                cartProductName.value = button.dataset.productName;
                cartModal.classList.add('show');
                cartQuantity.focus();
            });
        });

        closeCartModal.addEventListener('click', closeModal);

        cartModal.addEventListener('click', function (event) {
            if (event.target === cartModal) {
                closeModal();
            }
        });

        cartQuantity.addEventListener('input', function () {
            cartSubmit.disabled = Number(cartQuantity.value) < 1;
        });
    </script>
@endsection
