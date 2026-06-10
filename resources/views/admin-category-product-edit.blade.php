@extends('layouts.admin')

@section('title', 'Update Product')

@section('content')
    <section class="admin-page-header">
        <div>
            <h1>Update Product</h1>
            <p>Edit the selected product category name.</p>
        </div>

        <a href="{{ route('admin.categories.product') }}" class="admin-badge" style="text-decoration: none;">Back to Products</a>
    </section>

    @include('partials.admin-category-nav')

    @if ($errors->any())
        <p style="color: #dc3545; font-weight: 700;">{{ $errors->first() }}</p>
    @endif

    <form method="POST" action="{{ route('admin.categories.product.update', $categoryProduct) }}" style="width: 100%; max-width: 520px; box-sizing: border-box; padding: 24px; border-radius: 16px; background: #fff; box-shadow: 0 14px 32px rgba(36, 103, 255, 0.1);">
        @csrf
        @method('PUT')

        <label for="name" style="display: block; margin-bottom: 8px; font-weight: 700;">Product Name</label>
        <input
            type="text"
            id="name"
            name="name"
            value="{{ old('name', $categoryProduct->name) }}"
            style="width: 100%; box-sizing: border-box; padding: 12px; border: 1px solid #d5dcff; border-radius: 8px;"
            required
        >

        <button
            type="submit"
            style="margin-top: 16px; padding: 12px 18px; border: none; border-radius: 8px; background: #FF823B; color: #fff; font-weight: 800; cursor: pointer;"
        >
            Update Product
        </button>
    </form>
@endsection
