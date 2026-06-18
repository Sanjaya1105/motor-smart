@extends('layouts.admin')

@section('title', 'Product Add')

@section('content')
    @php
        $editing = isset($product);
    @endphp

    <style>
        .product-add-form {
            width: 100%;
            max-width: 900px;
            box-sizing: border-box;
            padding: 28px;
            border-radius: 18px;
            background: #fff;
            box-shadow: 0 14px 32px rgba(36, 103, 255, 0.1);
        }

        .category-select-row {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 16px;
            margin-bottom: 18px;
        }

        .form-control {
            width: 100%;
            box-sizing: border-box;
            padding: 12px;
            border: 1px solid #d5dcff;
            border-radius: 8px;
            background: #fff;
        }

        @media (max-width: 768px) {
            .category-select-row {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <section class="admin-page-header">
        <div>
            <h1>{{ $editing ? 'Update Product' : 'Product Add Page' }}</h1>
            <p>{{ $editing ? 'Update product details. Upload a new image only if you want to replace the current one.' : 'Add a product name and upload an image. Image size must be 2MB or less.' }}</p>
        </div>

        <a href="{{ route('admin.products') }}" class="admin-badge" style="text-decoration: none;">Back to Products</a>
    </section>

    @if ($errors->any())
        <p style="color: #dc3545; font-weight: 700;">{{ $errors->first() }}</p>
    @endif

    <form
        method="POST"
        action="{{ $editing ? route('admin.products.update', $product) : route('admin.products.store') }}"
        enctype="multipart/form-data"
        class="product-add-form"
    >
        @csrf
        @if ($editing)
            @method('PUT')
        @endif

        <div style="margin-bottom: 18px;">
            <label for="name" style="display: block; margin-bottom: 8px; font-weight: 700;">Name</label>
            <input
                type="text"
                id="name"
                name="name"
                value="{{ old('name', $product->name ?? '') }}"
                class="form-control"
                required
            >
        </div>

        <div style="margin-bottom: 18px;">
            <label for="item_code" style="display: block; margin-bottom: 8px; font-weight: 700;">Item Code</label>
            <input
                type="text"
                id="item_code"
                name="item_code"
                value="{{ old('item_code', $product->item_code ?? '') }}"
                class="form-control"
            >
        </div>

        <div class="category-select-row">
            <div>
                <label for="unit_price" style="display: block; margin-bottom: 8px; font-weight: 700;">Unit Price</label>
                <input
                    type="number"
                    id="unit_price"
                    name="unit_price"
                    value="{{ old('unit_price', $product->unit_price ?? '') }}"
                    class="form-control"
                    step="0.01"
                    min="0"
                    placeholder="0.00"
                >
            </div>

            <div>
                <label for="discount_percentage" style="display: block; margin-bottom: 8px; font-weight: 700;">Discount (%)</label>
                <input
                    type="text"
                    id="discount_percentage"
                    name="discount_percentage"
                    value="{{ old('discount_percentage', $product->discount_percentage ?? '') }}"
                    class="form-control"
                    placeholder="e.g. 20 or 20%"
                >
                <small style="display: block; margin-top: 8px; color: #6c757d;">Enter a number or percentage (e.g. 20 or 20%).</small>
            </div>
        </div>

        <div class="category-select-row">
            <div>
                <label for="category_product_id" style="display: block; margin-bottom: 8px; font-weight: 700;">Product</label>
                <select id="category_product_id" name="category_product_id" class="form-control" required>
                    <option value="">Select product</option>
                    @foreach ($categoryProducts as $categoryProduct)
                        <option value="{{ $categoryProduct->id }}" @selected(old('category_product_id', $product->category_product_id ?? '') == $categoryProduct->id)>
                            {{ $categoryProduct->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="vehicle_brand_id" style="display: block; margin-bottom: 8px; font-weight: 700;">Vehicle Brand</label>
                <select id="vehicle_brand_id" name="vehicle_brand_id" class="form-control" required>
                    <option value="">Select brand</option>
                    @foreach ($vehicleBrands as $vehicleBrand)
                        <option value="{{ $vehicleBrand->id }}" @selected(old('vehicle_brand_id', $product->vehicle_brand_id ?? '') == $vehicleBrand->id)>
                            {{ $vehicleBrand->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="vehicle_type_id" style="display: block; margin-bottom: 8px; font-weight: 700;">Vehicle Type</label>
                <select id="vehicle_type_id" name="vehicle_type_id" class="form-control" required>
                    <option value="">Select type</option>
                    @foreach ($vehicleTypes as $vehicleType)
                        <option value="{{ $vehicleType->id }}" @selected(old('vehicle_type_id', $product->vehicle_type_id ?? '') == $vehicleType->id)>
                            {{ $vehicleType->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div style="margin-bottom: 24px;">
            <label for="image" style="display: block; margin-bottom: 8px; font-weight: 700;">Image</label>
            <input
                type="file"
                id="image"
                name="image"
                accept="image/*"
                class="form-control"
                @required(! $editing)
            >
            <small style="display: block; margin-top: 8px; color: #6c757d;">
                Maximum image size: 2MB{{ $editing ? '. Leave empty to keep current image.' : '' }}
            </small>
            @if ($editing)
                <img src="{{ asset($product->image_path) }}" alt="{{ $product->name }}" style="display: block; width: 120px; height: 90px; object-fit: cover; margin-top: 12px; border-radius: 8px;">
            @endif
        </div>

        <div style="margin-bottom: 24px;">
            <label for="description" style="display: block; margin-bottom: 8px; font-weight: 700;">Description</label>
            <textarea
                id="description"
                name="description"
                rows="4"
                class="form-control"
            >{{ old('description', $product->description ?? '') }}</textarea>
        </div>

        <div style="margin-bottom: 24px;">
            <label for="search_keys" style="display: block; margin-bottom: 8px; font-weight: 700;">Search Keys</label>
            <input
                type="text"
                id="search_keys"
                name="search_keys"
                value="{{ old('search_keys', $product->search_keys ?? '') }}"
                class="form-control"
                placeholder="Example: nav,nav12,navb2"
            >
            <small style="display: block; margin-top: 8px; color: #6c757d;">Separate keywords with commas.</small>
        </div>

        <button
            type="submit"
            style="padding: 12px 20px; border: none; border-radius: 8px; background: #FF823B; color: #fff; font-weight: 800; cursor: pointer;"
        >
            {{ $editing ? 'Update Product' : 'Submit Product' }}
        </button>
    </form>
@endsection
