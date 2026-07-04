@extends('layouts.app')

@section('content')
    <style>
        .product-details-page {
            padding: 54px 40px;
            background: #f5f7ff;
        }

        .product-details-card {
            display: grid;
            grid-template-columns: minmax(280px, 0.8fr) minmax(0, 1.2fr);
            gap: 34px;
            padding: 28px;
            border-radius: 24px;
            background: #fff;
            box-shadow: 0 18px 45px rgba(36, 103, 255, 0.14);
        }

        .product-details-image {
            width: 100%;
            height: 360px;
            box-sizing: border-box;
            padding: 12px;
            border-radius: 18px;
            object-fit: contain;
            background: #eef3ff;
        }

        .product-details-title {
            margin: 0 0 12px;
            color: #2467FF;
            font-size: clamp(30px, 4vw, 44px);
        }

        .product-details-code {
            display: inline-block;
            padding: 8px 14px;
            margin-bottom: 22px;
            border-radius: 999px;
            background: #eef3ff;
            color: #2467FF;
            font-weight: 900;
        }

        .product-price-row {
            display: flex;
            align-items: baseline;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 22px;
        }

        .product-price-original {
            color: #9aa3b2;
            font-size: 22px;
            font-weight: 700;
            text-decoration: line-through;
        }

        .product-price-current {
            color: #FF823B;
            font-size: 34px;
            font-weight: 900;
        }

        .product-price-single {
            color: #2467FF;
            font-size: 34px;
            font-weight: 900;
        }

        .product-price-badge {
            padding: 6px 10px;
            border-radius: 999px;
            background: #ffe8dc;
            color: #FF823B;
            font-size: 13px;
            font-weight: 800;
        }

        .detail-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 14px;
            margin-bottom: 24px;
        }

        .detail-box {
            padding: 14px;
            border-left: 5px solid #FF823B;
            border-radius: 12px;
            background: #f8faff;
        }

        .detail-box span {
            display: block;
            margin-bottom: 6px;
            color: #6c757d;
            font-size: 12px;
            font-weight: 800;
            text-transform: uppercase;
        }

        .detail-box strong {
            color: #222;
        }

        .detail-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .detail-tag {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 999px;
            background: #eef3ff;
            color: #2467FF;
            font-size: 13px;
            font-weight: 800;
        }

        .detail-tag-empty {
            color: #6c757d;
            font-weight: 700;
        }

        .product-description {
            color: #6c757d;
            line-height: 1.7;
        }

        .product-action-row {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 24px;
        }

        .back-button,
        .cart-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 140px;
            padding: 12px 20px;
            border: 2px solid transparent;
            border-radius: 12px;
            font: inherit;
            font-weight: 800;
            letter-spacing: 0.02em;
            text-decoration: none;
            cursor: pointer;
            transition: transform 0.2s ease, box-shadow 0.2s ease, background 0.2s ease, color 0.2s ease, border-color 0.2s ease;
        }

        .back-button {
            background: linear-gradient(135deg, #FF823B 0%, #ff9a5c 100%);
            color: #fff;
            box-shadow: 0 10px 22px rgba(255, 130, 59, 0.28);
        }

        .back-button:hover {
            transform: translateY(-2px);
            background: linear-gradient(135deg, #ff6f1a 0%, #FF823B 100%);
            box-shadow: 0 14px 28px rgba(255, 130, 59, 0.38);
        }

        .cart-button {
            background: #fff;
            color: #2467FF;
            border-color: #2467FF;
            box-shadow: 0 8px 18px rgba(36, 103, 255, 0.12);
        }

        .cart-button:hover {
            transform: translateY(-2px);
            background: #2467FF;
            color: #fff;
            box-shadow: 0 14px 28px rgba(36, 103, 255, 0.28);
        }

        .back-button:active,
        .cart-button:active {
            transform: translateY(0);
        }

        .back-button:focus-visible,
        .cart-button:focus-visible {
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

        @media (max-width: 768px) {
            .product-details-page {
                padding: 36px 16px;
            }

            .product-details-card {
                grid-template-columns: 1fr;
                padding: 18px;
            }

            .product-details-image {
                height: 260px;
            }
        }
    </style>

    <main class="product-details-page">
        @if (session('success'))
            <p style="color: #198754; font-weight: 800;">{{ session('success') }}</p>
        @endif

        <section class="product-details-card">
            <img src="{{ asset($product->image_path) }}" alt="{{ $product->name }}" class="product-details-image">

            <div>
                <h1 class="product-details-title">{{ $product->name }}</h1>
                <span class="product-details-code">Item Code: {{ $product->item_code ?? 'N/A' }}</span>

                @if ($product->unit_price !== null)
                    <div class="product-price-row">
                        @if ($product->hasActiveDiscount())
                            <span class="product-price-original">Rs. {{ number_format($product->unit_price, 2) }}</span>
                            <span class="product-price-current">Rs. {{ number_format($product->discountedPrice(), 2) }}</span>
                            <span class="product-price-badge">{{ rtrim(rtrim(number_format($product->discount_percentage, 2, '.', ''), '0'), '.') }}% OFF</span>
                        @else
                            <span class="product-price-single">Rs. {{ number_format($product->unit_price, 2) }}</span>
                        @endif
                    </div>
                @endif

                <div class="detail-grid">
                    <div class="detail-box">
                        <span>Product</span>
                        <div class="detail-tags">
                            @if ($product->categoryProduct?->name)
                                <span class="detail-tag">{{ $product->categoryProduct->name }}</span>
                            @else
                                <span class="detail-tag-empty">Not provided</span>
                            @endif
                        </div>
                    </div>

                    <div class="detail-box">
                        <span>Vehicle Brand</span>
                        <div class="detail-tags">
                            @forelse ($product->vehicleBrands() as $vehicleBrand)
                                <span class="detail-tag">{{ $vehicleBrand->name }}</span>
                            @empty
                                <span class="detail-tag-empty">Not provided</span>
                            @endforelse
                        </div>
                    </div>

                    <div class="detail-box">
                        <span>Vehicle Type</span>
                        <div class="detail-tags">
                            @forelse ($product->vehicleTypes() as $vehicleType)
                                <span class="detail-tag">{{ $vehicleType->name }}</span>
                            @empty
                                <span class="detail-tag-empty">Not provided</span>
                            @endforelse
                        </div>
                    </div>

                    @if ($product->hasSize())
                        <div class="detail-box">
                            <span>Size</span>
                            <strong>{{ $product->formattedSize() }}</strong>
                        </div>
                    @endif

                    @if ($product->formattedWeight() !== null)
                        <div class="detail-box">
                            <span>Weight</span>
                            <strong>{{ $product->formattedWeight() }}</strong>
                        </div>
                    @endif
                </div>

                <h2>Description</h2>
                <p class="product-description">
                    {{ $product->description ?: 'Contact us for more details and wholesale availability.' }}
                </p>

                <div class="product-action-row">
                    <button type="button" class="cart-button" id="open-cart-modal">Add to Cart</button>
                    <a href="{{ route('product') }}" class="back-button">Back to Products</a>
                </div>
            </div>
        </section>

        <div class="cart-modal" id="cart-modal" aria-hidden="true">
            <form method="POST" action="{{ route('cart.add') }}" class="cart-modal-card">
                @csrf

                <h2>Add to Cart</h2>
                <input type="hidden" name="product_id" value="{{ $product->id }}">

                <div class="cart-field">
                    <label for="cart_product_name">Product Name</label>
                    <input type="text" id="cart_product_name" value="{{ $product->name }}" readonly>
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
        const openCartModal = document.getElementById('open-cart-modal');
        const closeCartModal = document.getElementById('close-cart-modal');
        const cartQuantity = document.getElementById('cart_quantity');
        const cartSubmit = document.getElementById('cart-submit');

        openCartModal.addEventListener('click', function () {
            cartModal.classList.add('show');
            cartQuantity.focus();
        });

        closeCartModal.addEventListener('click', function () {
            cartModal.classList.remove('show');
        });

        cartModal.addEventListener('click', function (event) {
            if (event.target === cartModal) {
                cartModal.classList.remove('show');
            }
        });

        cartQuantity.addEventListener('input', function () {
            cartSubmit.disabled = Number(cartQuantity.value) < 1;
        });
    </script>
@endsection
