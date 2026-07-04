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

        .discounted-price-preview {
            display: flex;
            align-items: center;
            min-height: 46px;
            padding: 12px 14px;
            border: 1px solid #ffe0cc;
            border-radius: 8px;
            background: #fff7f2;
            color: #FF823B;
            font-size: 18px;
            font-weight: 900;
        }

        .discounted-price-preview.empty {
            color: #adb5bd;
            font-size: 15px;
            font-weight: 700;
            background: #f8faff;
            border-color: #d5dcff;
        }

        .discounted-price-preview .original-price {
            margin-right: 10px;
            color: #9aa3b2;
            font-size: 15px;
            font-weight: 700;
            text-decoration: line-through;
        }

        @media (max-width: 768px) {
            .category-select-row {
                grid-template-columns: 1fr;
            }
        }

        .vehicle-brand-section,
        .vehicle-type-section {
            margin-bottom: 18px;
        }

        .vehicle-brand-list,
        .vehicle-type-list {
            display: grid;
            gap: 10px;
        }

        .vehicle-brand-row,
        .vehicle-type-row {
            display: grid;
            grid-template-columns: 1fr auto auto;
            gap: 10px;
            align-items: center;
        }

        .vehicle-brand-add-button,
        .vehicle-type-add-button,
        .vehicle-brand-remove-button,
        .vehicle-type-remove-button {
            width: 42px;
            height: 42px;
            border: none;
            border-radius: 8px;
            font-size: 22px;
            font-weight: 800;
            line-height: 1;
            cursor: pointer;
        }

        .vehicle-brand-add-button,
        .vehicle-type-add-button {
            margin-top: 10px;
            padding: 0 16px;
            width: auto;
            height: auto;
            background: #2467FF;
            color: #fff;
            font-size: 14px;
        }

        .vehicle-brand-remove-button,
        .vehicle-type-remove-button {
            background: #eef3ff;
            color: #2467FF;
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

    @php
        $selectedBrandIds = old('vehicle_brand_ids', isset($product) ? $product->vehicleBrandIdList() : ['']);
        $selectedTypeIds = old('vehicle_type_ids', isset($product) ? $product->vehicleTypeIdList() : ['']);

        if ($selectedBrandIds === []) {
            $selectedBrandIds = [''];
        }

        if ($selectedTypeIds === []) {
            $selectedTypeIds = [''];
        }
    @endphp

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

            <div>
                <label for="discounted_price_preview" style="display: block; margin-bottom: 8px; font-weight: 700;">Discounted Price</label>
                <div id="discounted_price_preview" class="discounted-price-preview empty" aria-live="polite">
                    Enter unit price
                </div>
            </div>
        </div>

        <div style="margin-bottom: 8px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 700;">Size</label>
        </div>

        <div class="category-select-row">
            <div>
                <label for="height" style="display: block; margin-bottom: 8px; font-weight: 700;">Height</label>
                <input
                    type="number"
                    id="height"
                    name="height"
                    value="{{ old('height', $product->height ?? '') }}"
                    class="form-control"
                    step="0.01"
                    min="0"
                    placeholder="0.00"
                >
            </div>

            <div>
                <label for="width" style="display: block; margin-bottom: 8px; font-weight: 700;">Width</label>
                <input
                    type="number"
                    id="width"
                    name="width"
                    value="{{ old('width', $product->width ?? '') }}"
                    class="form-control"
                    step="0.01"
                    min="0"
                    placeholder="0.00"
                >
            </div>

            <div>
                <label for="length" style="display: block; margin-bottom: 8px; font-weight: 700;">Length</label>
                <input
                    type="number"
                    id="length"
                    name="length"
                    value="{{ old('length', $product->length ?? '') }}"
                    class="form-control"
                    step="0.01"
                    min="0"
                    placeholder="0.00"
                >
            </div>
        </div>

        <div style="margin-bottom: 18px;">
            <label for="weight" style="display: block; margin-bottom: 8px; font-weight: 700;">Weight</label>
            <input
                type="number"
                id="weight"
                name="weight"
                value="{{ old('weight', $product->weight ?? '') }}"
                class="form-control"
                step="0.01"
                min="0"
                placeholder="0.00"
            >
        </div>

        <div style="margin-bottom: 18px;">
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

        <div class="vehicle-type-section">
            <label style="display: block; margin-bottom: 8px; font-weight: 700;">Vehicle Type</label>

            <div id="vehicle-type-list" class="vehicle-type-list">
                @foreach ($selectedTypeIds as $index => $selectedTypeId)
                    <div class="vehicle-type-row">
                        <select name="vehicle_type_ids[]" class="form-control vehicle-type-select" required>
                            <option value="">Select type</option>
                            @foreach ($vehicleTypes as $vehicleType)
                                <option value="{{ $vehicleType->id }}" @selected((string) $selectedTypeId === (string) $vehicleType->id)>
                                    {{ $vehicleType->name }}
                                </option>
                            @endforeach
                        </select>

                        @if ($index === 0)
                            <button type="button" class="vehicle-type-add-button" id="add-vehicle-type" aria-label="Add vehicle type">+ Add Type</button>
                        @else
                            <button type="button" class="vehicle-type-remove-button" aria-label="Remove vehicle type">&times;</button>
                        @endif
                    </div>
                @endforeach
            </div>

            <small style="display: block; margin-top: 8px; color: #6c757d;">Use + Add Type to attach this product to multiple vehicle types.</small>
        </div>

        <template id="vehicle-type-row-template">
            <div class="vehicle-type-row">
                <select name="vehicle_type_ids[]" class="form-control vehicle-type-select" required>
                    <option value="">Select type</option>
                    @foreach ($vehicleTypes as $vehicleType)
                        <option value="{{ $vehicleType->id }}">{{ $vehicleType->name }}</option>
                    @endforeach
                </select>
                <button type="button" class="vehicle-type-remove-button" aria-label="Remove vehicle type">&times;</button>
            </div>
        </template>

        <div class="vehicle-brand-section">
            <label style="display: block; margin-bottom: 8px; font-weight: 700;">Vehicle Brand</label>

            <div id="vehicle-brand-list" class="vehicle-brand-list">
                @foreach ($selectedBrandIds as $index => $selectedBrandId)
                    <div class="vehicle-brand-row">
                        <select name="vehicle_brand_ids[]" class="form-control vehicle-brand-select" required>
                            <option value="">Select brand</option>
                            @foreach ($vehicleBrands as $vehicleBrand)
                                <option value="{{ $vehicleBrand->id }}" @selected((string) $selectedBrandId === (string) $vehicleBrand->id)>
                                    {{ $vehicleBrand->name }}
                                </option>
                            @endforeach
                        </select>

                        @if ($index === 0)
                            <button type="button" class="vehicle-brand-add-button" id="add-vehicle-brand" aria-label="Add vehicle brand">+ Add Brand</button>
                        @else
                            <button type="button" class="vehicle-brand-remove-button" aria-label="Remove vehicle brand">&times;</button>
                        @endif
                    </div>
                @endforeach
            </div>

            <small style="display: block; margin-top: 8px; color: #6c757d;">Use + Add Brand to attach this product to multiple vehicle brands.</small>
        </div>

        <template id="vehicle-brand-row-template">
            <div class="vehicle-brand-row">
                <select name="vehicle_brand_ids[]" class="form-control vehicle-brand-select" required>
                    <option value="">Select brand</option>
                    @foreach ($vehicleBrands as $vehicleBrand)
                        <option value="{{ $vehicleBrand->id }}">{{ $vehicleBrand->name }}</option>
                    @endforeach
                </select>
                <button type="button" class="vehicle-brand-remove-button" aria-label="Remove vehicle brand">&times;</button>
            </div>
        </template>

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

    <script>
        const unitPriceInput = document.getElementById('unit_price');
        const discountInput = document.getElementById('discount_percentage');
        const discountedPreview = document.getElementById('discounted_price_preview');

        function parseDiscount(value) {
            if (value === null || String(value).trim() === '') {
                return 0;
            }

            const numeric = String(value).replace(/[^0-9.]/g, '');

            if (numeric === '' || Number.isNaN(Number(numeric))) {
                return 0;
            }

            return Math.min(100, Math.max(0, parseFloat(numeric)));
        }

        function formatPrice(amount) {
            return 'Rs. ' + amount.toLocaleString('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2,
            });
        }

        function updateDiscountedPricePreview() {
            const unitPrice = parseFloat(unitPriceInput.value);
            const discount = parseDiscount(discountInput.value);

            if (Number.isNaN(unitPrice) || unitPriceInput.value.trim() === '') {
                discountedPreview.className = 'discounted-price-preview empty';
                discountedPreview.textContent = 'Enter unit price';
                return;
            }

            const discounted = discount > 0
                ? Math.round(unitPrice * (1 - (discount / 100)) * 100) / 100
                : unitPrice;

            discountedPreview.className = 'discounted-price-preview';

            if (discount > 0) {
                discountedPreview.innerHTML =
                    '<span class="original-price">' + formatPrice(unitPrice) + '</span>' +
                    formatPrice(discounted);
            } else {
                discountedPreview.textContent = formatPrice(discounted);
            }
        }

        unitPriceInput.addEventListener('input', updateDiscountedPricePreview);
        discountInput.addEventListener('input', updateDiscountedPricePreview);
        updateDiscountedPricePreview();

        function initMultiSelect(listId, addButtonId, templateId, selectClass, removeClass, rowClass) {
            const list = document.getElementById(listId);
            const addButton = document.getElementById(addButtonId);
            const template = document.getElementById(templateId);

            addButton.addEventListener('click', function () {
                list.appendChild(template.content.cloneNode(true));
            });

            list.addEventListener('click', function (event) {
                const removeButton = event.target.closest('.' + removeClass);

                if (! removeButton) {
                    return;
                }

                const rows = list.querySelectorAll('.' + rowClass);

                if (rows.length <= 1) {
                    rows[0].querySelector('.' + selectClass).value = '';
                    return;
                }

                removeButton.closest('.' + rowClass).remove();
            });
        }

        initMultiSelect(
            'vehicle-brand-list',
            'add-vehicle-brand',
            'vehicle-brand-row-template',
            'vehicle-brand-select',
            'vehicle-brand-remove-button',
            'vehicle-brand-row'
        );

        initMultiSelect(
            'vehicle-type-list',
            'add-vehicle-type',
            'vehicle-type-row-template',
            'vehicle-type-select',
            'vehicle-type-remove-button',
            'vehicle-type-row'
        );
    </script>
@endsection
