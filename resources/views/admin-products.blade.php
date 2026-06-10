@extends('layouts.admin')

@section('title', 'Products')

@section('content')
    <style>
        .product-list {
            display: grid;
            gap: 14px;
            margin-top: 28px;
        }

        .product-list-item {
            display: grid;
            grid-template-columns: 90px 1fr auto;
            align-items: center;
            gap: 18px;
            padding: 16px;
            border-left: 5px solid #FF823B;
            border-radius: 14px;
            background: #fff;
            box-shadow: 0 10px 24px rgba(36, 103, 255, 0.08);
        }

        .product-list-image {
            width: 90px;
            height: 70px;
            object-fit: cover;
            border-radius: 10px;
            background: #eef3ff;
        }

        .product-list-name {
            margin: 0;
            color: #222;
            font-size: 18px;
        }

        .product-list-code {
            display: inline-block;
            margin-top: 10px;
            padding: 6px 10px;
            border-radius: 999px;
            background: #eef3ff;
            color: #2467FF;
            font-size: 12px;
            font-weight: 800;
        }

        .product-actions {
            display: flex;
            gap: 8px;
            align-items: center;
            flex-wrap: wrap;
            justify-content: flex-end;
        }

        .product-action-link,
        .product-delete-button {
            padding: 9px 13px;
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

        .product-search-form {
            display: flex;
            gap: 10px;
            max-width: 680px;
            margin-bottom: 24px;
        }

        .product-search-input {
            flex: 1;
            padding: 12px 14px;
            border: 1px solid #d5dcff;
            border-radius: 8px;
            font-size: 15px;
        }

        .product-search-button,
        .product-search-clear {
            padding: 12px 18px;
            border: none;
            border-radius: 8px;
            font-weight: 800;
            text-decoration: none;
            cursor: pointer;
        }

        .product-search-button {
            background: #2467FF;
            color: #fff;
        }

        .product-search-clear {
            background: #fff;
            color: #FF823B;
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

        @media (max-width: 640px) {
            .product-search-form {
                flex-direction: column;
            }

            .product-list-item {
                grid-template-columns: 1fr;
            }

            .product-list-image {
                width: 100%;
                height: 180px;
            }
        }
    </style>

    <section class="admin-page-header">
        <div>
            <h1>Products</h1>
            <p>Add and manage uploaded products.</p>
        </div>

        <a href="{{ route('admin.products.add') }}" class="admin-badge" style="text-decoration: none;">Add Products</a>
    </section>

    @if (session('success'))
        <p style="color: #198754; font-weight: 700;">{{ session('success') }}</p>
    @endif

    <form method="GET" action="{{ route('admin.products') }}" class="product-search-form">
        <input
            type="search"
            name="search"
            value="{{ $search }}"
            class="product-search-input"
            placeholder="Search by product name, item code, or search keys"
        >
        <button type="submit" class="product-search-button">Search</button>

        @if ($search !== '')
            <a href="{{ route('admin.products') }}" class="product-search-clear">Clear</a>
        @endif
    </form>

    <section class="product-list">
        @forelse ($products as $product)
            <div class="product-list-item">
                <img src="{{ asset($product->image_path) }}" alt="{{ $product->name }}" class="product-list-image">

                <div>
                    <h2 class="product-list-name">{{ $product->name }}</h2>
                    <span class="product-list-code">Code: {{ $product->item_code ?? 'N/A' }}</span>
                </div>

                <div class="product-actions">
                    <a href="{{ route('admin.products.edit', $product) }}" class="product-action-link">Update</a>

                    <form method="POST" action="{{ route('admin.products.destroy', $product) }}" onsubmit="return confirm('Are you sure you want to delete this product?');">
                        @csrf
                        @method('DELETE')

                        <button type="submit" class="product-delete-button">Delete</button>
                    </form>
                </div>
            </div>
        @empty
            <p style="padding: 18px; border-radius: 10px; background: #fff; color: #6c757d;">
                {{ $search !== '' ? 'No products found for this search.' : 'No products added yet.' }}
            </p>
        @endforelse

        {{ $products->links() }}
    </section>
@endsection
