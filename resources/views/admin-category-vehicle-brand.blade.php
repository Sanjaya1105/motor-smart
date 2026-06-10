@extends('layouts.admin')

@section('title', 'Vehicle Brand')

@section('content')
    <style>
        .brand-form {
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

        .brand-input {
            width: 100%;
            box-sizing: border-box;
            padding: 12px;
            border: 1px solid #d5dcff;
            border-radius: 8px;
        }

        .brand-button {
            padding: 12px 18px;
            border: none;
            border-radius: 8px;
            background: #2467FF;
            color: #fff;
            font-weight: 800;
            cursor: pointer;
        }

        .brand-submit {
            margin-top: 16px;
            background: #FF823B;
        }

        .brand-list {
            display: grid;
            gap: 10px;
            max-width: 520px;
            margin-top: 24px;
        }

        .brand-list-item {
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

        .brand-actions {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .brand-action-link,
        .brand-delete-button {
            padding: 8px 12px;
            border: none;
            border-radius: 8px;
            font: inherit;
            font-weight: 800;
            text-decoration: none;
            cursor: pointer;
        }

        .brand-action-link {
            background: #2467FF;
            color: #fff;
        }

        .brand-delete-button {
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
            .brand-list-item {
                align-items: flex-start;
                flex-direction: column;
            }
        }
    </style>

    <section class="admin-page-header">
        <div>
            <h1>Vehicle Brand</h1>
            <p>Manage vehicle brand categories.</p>
        </div>
    </section>

    @include('partials.admin-category-nav')

    @if (session('success'))
        <p style="color: #198754; font-weight: 700;">{{ session('success') }}</p>
    @endif

    @if ($errors->any())
        <p style="color: #dc3545; font-weight: 700;">{{ $errors->first() }}</p>
    @endif

    <button type="button" id="toggle-brand-form" class="brand-button">
        {{ $errors->any() ? 'Hide Add Vehicle Brand' : 'Add Vehicle Brand' }}
    </button>

    <form
        method="POST"
        action="{{ route('admin.categories.vehicle-brand.store') }}"
        id="brand-form"
        class="brand-form"
        style="display: {{ $errors->any() ? 'block' : 'none' }};"
    >
        @csrf

        <label for="name" style="display: block; margin-bottom: 8px; font-weight: 700;">Vehicle Brand Name</label>
        <input
            type="text"
            id="name"
            name="name"
            value="{{ old('name') }}"
            class="brand-input"
            required
        >

        <button type="submit" class="brand-button brand-submit">Submit</button>
    </form>

    <section class="brand-list">
        @forelse ($vehicleBrands as $vehicleBrand)
            <div class="brand-list-item">
                <span>{{ $vehicleBrand->name }}</span>

                <div class="brand-actions">
                    <a href="{{ route('admin.categories.vehicle-brand.edit', $vehicleBrand) }}" class="brand-action-link">Update</a>

                    <form method="POST" action="{{ route('admin.categories.vehicle-brand.destroy', $vehicleBrand) }}" onsubmit="return confirm('Are you sure you want to delete this vehicle brand?');">
                        @csrf
                        @method('DELETE')

                        <button type="submit" class="brand-delete-button">Delete</button>
                    </form>
                </div>
            </div>
        @empty
            <p style="color: #6c757d;">No vehicle brands added yet.</p>
        @endforelse

        {{ $vehicleBrands->links() }}
    </section>

    <script>
        const toggleBrandFormButton = document.getElementById('toggle-brand-form');
        const brandForm = document.getElementById('brand-form');

        toggleBrandFormButton.addEventListener('click', function () {
            const isOpen = brandForm.style.display === 'block';

            brandForm.style.display = isOpen ? 'none' : 'block';
            toggleBrandFormButton.textContent = isOpen ? 'Add Vehicle Brand' : 'Hide Add Vehicle Brand';
        });
    </script>
@endsection
