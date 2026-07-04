@extends('layouts.app')

@section('content')
    <style>
        .user-products-page {
            padding: 54px 40px;
            background: #f5f7ff;
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

        .product-list-price {
            display: flex;
            align-items: baseline;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 8px;
        }

        .product-list-price-original {
            color: #9aa3b2;
            font-size: 14px;
            font-weight: 700;
            text-decoration: line-through;
        }

        .product-list-price-current {
            color: #FF823B;
            font-size: 18px;
            font-weight: 900;
        }

        .product-list-price-single {
            color: #2467FF;
            font-size: 18px;
            font-weight: 900;
        }

        .product-meta-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            margin-top: 10px;
        }

        .product-meta-tag {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 999px;
            background: #eef3ff;
            color: #2467FF;
            font-size: 12px;
            font-weight: 800;
        }

        .product-meta-info {
            margin-top: 8px;
            color: #6c757d;
            font-size: 13px;
            font-weight: 700;
        }

        .product-card-actions {
            justify-self: end;
            align-self: center;
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            justify-content: flex-end;
        }

        .product-details-button,
        .product-cart-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 118px;
            padding: 11px 18px;
            border: 2px solid transparent;
            border-radius: 12px;
            font-size: 13px;
            font-family: inherit;
            font-weight: 800;
            letter-spacing: 0.02em;
            text-decoration: none;
            cursor: pointer;
            transition: transform 0.2s ease, box-shadow 0.2s ease, background 0.2s ease, color 0.2s ease, border-color 0.2s ease;
        }

        .product-details-button {
            background: linear-gradient(135deg, #FF823B 0%, #ff9a5c 100%);
            color: #fff;
            box-shadow: 0 10px 22px rgba(255, 130, 59, 0.28);
        }

        .product-details-button:hover {
            transform: translateY(-2px);
            background: linear-gradient(135deg, #ff6f1a 0%, #FF823B 100%);
            box-shadow: 0 14px 28px rgba(255, 130, 59, 0.38);
        }

        .product-cart-button {
            background: #fff;
            color: #2467FF;
            border-color: #2467FF;
            box-shadow: 0 8px 18px rgba(36, 103, 255, 0.12);
        }

        .product-cart-button:hover {
            transform: translateY(-2px);
            background: #2467FF;
            color: #fff;
            box-shadow: 0 14px 28px rgba(36, 103, 255, 0.28);
        }

        .product-details-button:active,
        .product-cart-button:active {
            transform: translateY(0);
        }

        .product-details-button:focus-visible,
        .product-cart-button:focus-visible {
            outline: 3px solid rgba(36, 103, 255, 0.25);
            outline-offset: 2px;
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

        .product-page-title {
            margin: 0 0 18px;
            color: #2467FF;
            font-size: clamp(30px, 4vw, 44px);
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

            .user-product-card {
                grid-template-columns: 1fr;
            }

            .user-product-image {
                width: 100%;
                height: 120px;
            }

            .product-card-actions {
                justify-self: stretch;
                width: 100%;
            }

            .product-details-button,
            .product-cart-button {
                flex: 1;
                min-width: 0;
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

        <h1 class="product-page-title">Products</h1>

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

                        @if ($product->unit_price !== null)
                            <div class="product-list-price">
                                @if ($product->hasActiveDiscount())
                                    <span class="product-list-price-original">Rs. {{ number_format($product->unit_price, 2) }}</span>
                                    <span class="product-list-price-current">Rs. {{ number_format($product->discountedPrice(), 2) }}</span>
                                @else
                                    <span class="product-list-price-single">Rs. {{ number_format($product->unit_price, 2) }}</span>
                                @endif
                            </div>
                        @endif

                        @if ($product->categoryProduct?->name || $product->vehicleBrands()->isNotEmpty() || $product->vehicleTypes()->isNotEmpty())
                            <div class="product-meta-tags">
                                @if ($product->categoryProduct?->name)
                                    <span class="product-meta-tag">{{ $product->categoryProduct->name }}</span>
                                @endif

                                @foreach ($product->vehicleBrands() as $vehicleBrand)
                                    <span class="product-meta-tag">{{ $vehicleBrand->name }}</span>
                                @endforeach

                                @foreach ($product->vehicleTypes() as $vehicleType)
                                    <span class="product-meta-tag">{{ $vehicleType->name }}</span>
                                @endforeach
                            </div>
                        @endif

                        @if ($product->hasSize() || $product->formattedWeight() !== null)
                            <div class="product-meta-info">
                                @if ($product->hasSize())
                                    <span>Size: {{ $product->formattedSize() }}</span>
                                @endif

                                @if ($product->hasSize() && $product->formattedWeight() !== null)
                                    <span> | </span>
                                @endif

                                @if ($product->formattedWeight() !== null)
                                    <span>Weight: {{ $product->formattedWeight() }}</span>
                                @endif
                            </div>
                        @endif
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
