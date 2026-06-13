<aside class="mini-cart-box" aria-label="Cart summary">
    <button type="button" class="mini-cart-header" id="mini-cart-toggle" aria-expanded="true" aria-controls="mini-cart-items">
        <strong>Cart Summary</strong>
        <span class="mini-cart-header-right">
            <span class="mini-cart-total">{{ $cartCount }} items</span>
            <span class="mini-cart-toggle-icon" aria-hidden="true">&#9662;</span>
        </span>
    </button>

    <div class="mini-cart-items" id="mini-cart-items">
        @foreach ($cartItems as $cartItem)
            <div class="mini-cart-item">
                <img src="{{ asset($cartItem['image_path']) }}" alt="{{ $cartItem['name'] }}">
                <div>
                    <span class="mini-cart-item-name">{{ $cartItem['name'] }}</span>
                    <span class="mini-cart-item-code">Code: {{ $cartItem['item_code'] ?? 'N/A' }}</span>
                </div>
                <span class="mini-cart-qty">x{{ $cartItem['quantity'] }}</span>
                <form method="POST" action="{{ route('cart.remove', $cartItem['product_id']) }}" class="mini-cart-remove-form" onsubmit="return confirm('Remove this product from cart?');">
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="mini-cart-delete-button" aria-label="Remove {{ $cartItem['name'] }} from cart">
                        &#128465;
                    </button>
                </form>
            </div>
        @endforeach
    </div>

    <button
        type="button"
        class="mini-cart-order-more-button"
        id="order-more-toggle"
        aria-expanded="false"
        aria-controls="order-more-panel"
    >
        Order More Products
    </button>

    <div class="mini-cart-more-panel" id="order-more-panel" hidden>
        <div class="mini-cart-more-card" role="dialog" aria-modal="true" aria-labelledby="order-more-title">
            <div class="mini-cart-more-header">
                <h2 id="order-more-title">Order More Products</h2>
                <button type="button" class="mini-cart-more-close" id="order-more-close" aria-label="Close order more products popup">
                    &times;
                </button>
            </div>

            <div class="mini-cart-search-row">
                <input
                    type="search"
                    id="mini-cart-product-search"
                    placeholder="Search product, item code, keywords..."
                    data-search-url="{{ route('cart.product-search') }}"
                    data-add-url="{{ route('cart.add') }}"
                >
                <button type="button" id="mini-cart-product-search-button">Search</button>
            </div>

            <div class="mini-cart-search-results" id="mini-cart-search-results">
                <p class="mini-cart-search-note">Search products to add more items.</p>
            </div>
        </div>
    </div>

    <a
        href="{{ $whatsappOrderUrl }}"
        class="mini-cart-link"
        id="send-order-link"
        target="_blank"
        rel="noopener"
        data-clear-url="{{ route('cart.clear') }}"
    >
        Send Order
    </a>
</aside>
