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

        .product-description {
            color: #6c757d;
            line-height: 1.7;
        }

        .back-button {
            display: inline-block;
            margin-top: 24px;
            padding: 12px 18px;
            border-radius: 10px;
            background: #FF823B;
            color: #fff;
            font-weight: 800;
            text-decoration: none;
        }

        .cart-button {
            display: inline-block;
            margin-top: 24px;
            margin-right: 10px;
            padding: 12px 18px;
            border: none;
            border-radius: 10px;
            background: #2467FF;
            color: #fff;
            font: inherit;
            font-weight: 800;
            cursor: pointer;
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

                <div class="detail-grid">
                    <div class="detail-box">
                        <span>Product</span>
                        <strong>{{ $product->categoryProduct?->name ?? 'Not provided' }}</strong>
                    </div>

                    <div class="detail-box">
                        <span>Vehicle Brand</span>
                        <strong>{{ $product->vehicleBrand?->name ?? 'Not provided' }}</strong>
                    </div>

                    <div class="detail-box">
                        <span>Vehicle Type</span>
                        <strong>{{ $product->vehicleType?->name ?? 'Not provided' }}</strong>
                    </div>
                </div>

                <h2>Description</h2>
                <p class="product-description">
                    {{ $product->description ?: 'Contact us for more details and wholesale availability.' }}
                </p>

                <button type="button" class="cart-button" id="open-cart-modal">Add to Cart</button>
                <a href="{{ route('product') }}" class="back-button">Back to Products</a>
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
