@extends('layouts.admin')

@section('title', 'Update Vehicle Type')

@section('content')
    <section class="admin-page-header">
        <div>
            <h1>Update Vehicle Type</h1>
            <p>Edit the selected vehicle type name.</p>
        </div>

        <a href="{{ route('admin.categories.vehicle-type') }}" class="admin-badge" style="text-decoration: none;">Back to Vehicle Types</a>
    </section>

    @include('partials.admin-category-nav')

    @if ($errors->any())
        <p style="color: #dc3545; font-weight: 700;">{{ $errors->first() }}</p>
    @endif

    <form method="POST" action="{{ route('admin.categories.vehicle-type.update', $vehicleType) }}" style="width: 100%; max-width: 520px; box-sizing: border-box; padding: 24px; border-radius: 16px; background: #fff; box-shadow: 0 14px 32px rgba(36, 103, 255, 0.1);">
        @csrf
        @method('PUT')

        <label for="name" style="display: block; margin-bottom: 8px; font-weight: 700;">Vehicle Type Name</label>
        <input
            type="text"
            id="name"
            name="name"
            value="{{ old('name', $vehicleType->name) }}"
            style="width: 100%; box-sizing: border-box; padding: 12px; border: 1px solid #d5dcff; border-radius: 8px;"
            required
        >

        <button
            type="submit"
            style="margin-top: 16px; padding: 12px 18px; border: none; border-radius: 8px; background: #FF823B; color: #fff; font-weight: 800; cursor: pointer;"
        >
            Update Vehicle Type
        </button>
    </form>
@endsection
