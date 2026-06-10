@extends('layouts.admin')

@section('title', 'Product')

@section('content')
    <style>
        .product-form {
            display: none;
            width: 100%;
            max-width: 520px;
            box-sizing: border-box;
            margin: 24px 0;
            padding: 24px;
            border-radius: 16px;
            background: #fff;
            box-shadow: 0 14px 32px rgba(36, 103, 255, 0.1);
        }

        .product-input {
            width: 100%;
            box-sizing: border-box;
            padding: 12px;
            border: 1px solid #d5dcff;
            border-radius: 8px;
        }

        .product-button {
            padding: 12px 18px;
            border: none;
            border-radius: 8px;
            background: #2467FF;
            color: #fff;
            font-weight: 800;
            cursor: pointer;
        }

        .product-submit {
            margin-top: 16px;
            background: #FF823B;
        }

        .product-list {
            display: grid;
            gap: 10px;
            max-width: 520px;
            margin-top: 24px;
        }

        .product-list-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            padding: 14px 16px;
            border-left: 5px solid #FF823B;
            border-radius: 10px;
            background: #fff;
            box-shadow: 0 10px 24px rgba(36, 103, 255, 0.08);
            font-weight: 700;
        }

        .product-actions {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .product-action-link,
        .product-delete-button {
            padding: 8px 12px;
            border: none;
            border-radius: 8px;
            font: inherit;
            font-weight: 800;
            text-decoration: none;
            cursor: pointer;
        }

        .product-action-link {
            background: #2467FF;
            color: #fff;
        }

        .product-delete-button {
            background: #dc3545;
            color: #fff;
        }

        .pagination {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 22px;
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

        @media (max-width: 480px) {
            .product-list-item {
                align-items: flex-start;
                flex-direction: column;
            }
        }
    </style>

    <section class="admin-page-header">
        <div>
            <h1>Product</h1>
            <p>Manage product categories.</p>
        </div>
    </section>

    @include('partials.admin-category-nav')

    @if (session('success'))
        <p style="color: #198754; font-weight: 700;">{{ session('success') }}</p>
    @endif

    @if ($errors->any())
        <p style="color: #dc3545; font-weight: 700;">{{ $errors->first() }}</p>
    @endif

    <button type="button" id="toggle-product-form" class="product-button">
        {{ $errors->any() ? 'Hide Add Product' : 'Add Product' }}
    </button>

    <form
        method="POST"
        action="{{ route('admin.categories.product.store') }}"
        id="product-form"
        class="product-form"
        style="display: {{ $errors->any() ? 'block' : 'none' }};"
    >
        @csrf

        <label for="name" style="display: block; margin-bottom: 8px; font-weight: 700;">Product Name</label>
        <input
            type="text"
            id="name"
            name="name"
            value="{{ old('name') }}"
            class="product-input"
            required
        >

        <button type="submit" class="product-button product-submit">Submit</button>
    </form>

    <section class="product-list">
        @forelse ($categoryProducts as $categoryProduct)
            <div class="product-list-item">
                <span>{{ $categoryProduct->name }}</span>

                <div class="product-actions">
                    <a href="{{ route('admin.categories.product.edit', $categoryProduct) }}" class="product-action-link">Update</a>

                    <form method="POST" action="{{ route('admin.categories.product.destroy', $categoryProduct) }}" onsubmit="return confirm('Are you sure you want to delete this product category?');">
                        @csrf
                        @method('DELETE')

                        <button type="submit" class="product-delete-button">Delete</button>
                    </form>
                </div>
            </div>
        @empty
            <p style="color: #6c757d;">No products added yet.</p>
        @endforelse

        {{ $categoryProducts->links() }}
    </section>

    <script>
        const toggleProductFormButton = document.getElementById('toggle-product-form');
        const productForm = document.getElementById('product-form');

        toggleProductFormButton.addEventListener('click', function () {
            const isOpen = productForm.style.display === 'block';

            productForm.style.display = isOpen ? 'none' : 'block';
            toggleProductFormButton.textContent = isOpen ? 'Add Product' : 'Hide Add Product';
        });
    </script>
@endsection
