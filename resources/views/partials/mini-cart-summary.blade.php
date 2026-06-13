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
