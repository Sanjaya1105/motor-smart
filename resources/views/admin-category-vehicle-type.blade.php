@extends('layouts.admin')

@section('title', 'Vehicle Type')

@section('content')
    <style>
        .type-form {
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

        .type-input {
            width: 100%;
            box-sizing: border-box;
            padding: 12px;
            border: 1px solid #d5dcff;
            border-radius: 8px;
        }

        .type-button {
            padding: 12px 18px;
            border: none;
            border-radius: 8px;
            background: #2467FF;
            color: #fff;
            font-weight: 800;
            cursor: pointer;
        }

        .type-submit {
            margin-top: 16px;
            background: #FF823B;
        }

        .type-list {
            display: grid;
            gap: 10px;
            max-width: 520px;
            margin-top: 24px;
        }

        .type-list-item {
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

        .type-actions {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .type-action-link,
        .type-delete-button {
            padding: 8px 12px;
            border: none;
            border-radius: 8px;
            font: inherit;
            font-weight: 800;
            text-decoration: none;
            cursor: pointer;
        }

        .type-action-link {
            background: #2467FF;
            color: #fff;
        }

        .type-delete-button {
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
            .type-list-item {
                align-items: flex-start;
                flex-direction: column;
            }
        }
    </style>

    <section class="admin-page-header">
        <div>
            <h1>Vehicle Type</h1>
            <p>Manage vehicle type categories.</p>
        </div>
    </section>

    @include('partials.admin-category-nav')

    @if (session('success'))
        <p style="color: #198754; font-weight: 700;">{{ session('success') }}</p>
    @endif

    @if ($errors->any())
        <p style="color: #dc3545; font-weight: 700;">{{ $errors->first() }}</p>
    @endif

    <button type="button" id="toggle-type-form" class="type-button">
        {{ $errors->any() ? 'Hide Add Vehicle Type' : 'Add Vehicle Type' }}
    </button>

    <form
        method="POST"
        action="{{ route('admin.categories.vehicle-type.store') }}"
        id="type-form"
        class="type-form"
        style="display: {{ $errors->any() ? 'block' : 'none' }};"
    >
        @csrf

        <label for="name" style="display: block; margin-bottom: 8px; font-weight: 700;">Vehicle Type Name</label>
        <input
            type="text"
            id="name"
            name="name"
            value="{{ old('name') }}"
            class="type-input"
            required
        >

        <button type="submit" class="type-button type-submit">Submit</button>
    </form>

    <section class="type-list">
        @forelse ($vehicleTypes as $vehicleType)
            <div class="type-list-item">
                <span>{{ $vehicleType->name }}</span>

                <div class="type-actions">
                    <a href="{{ route('admin.categories.vehicle-type.edit', $vehicleType) }}" class="type-action-link">Update</a>

                    <form method="POST" action="{{ route('admin.categories.vehicle-type.destroy', $vehicleType) }}" onsubmit="return confirm('Are you sure you want to delete this vehicle type?');">
                        @csrf
                        @method('DELETE')

                        <button type="submit" class="type-delete-button">Delete</button>
                    </form>
                </div>
            </div>
        @empty
            <p style="color: #6c757d;">No vehicle types added yet.</p>
        @endforelse

        {{ $vehicleTypes->links() }}
    </section>

    <script>
        const toggleTypeFormButton = document.getElementById('toggle-type-form');
        const typeForm = document.getElementById('type-form');

        toggleTypeFormButton.addEventListener('click', function () {
            const isOpen = typeForm.style.display === 'block';

            typeForm.style.display = isOpen ? 'none' : 'block';
            toggleTypeFormButton.textContent = isOpen ? 'Add Vehicle Type' : 'Hide Add Vehicle Type';
        });
    </script>
@endsection
