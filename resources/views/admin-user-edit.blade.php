@extends('layouts.admin')

@section('title', 'Update User')

@section('content')
    <section class="admin-page-header">
        <div>
            <h1>Update User</h1>
            <p>Edit merchant details. Leave password empty to keep the current password.</p>
        </div>

        <a href="{{ route('admin.users') }}" class="admin-badge" style="text-decoration: none;">Back to Users</a>
    </section>

    @if ($errors->any())
        <p style="color: #dc3545; font-weight: 700;">{{ $errors->first() }}</p>
    @endif

    <form method="POST" action="{{ route('admin.users.update', $user) }}" style="width: 100%; max-width: 640px; box-sizing: border-box; padding: 28px; border-radius: 18px; background: #fff; box-shadow: 0 14px 32px rgba(36, 103, 255, 0.1);">
        @csrf
        @method('PUT')

        <div style="margin-bottom: 16px;">
            <label for="merchant_name" style="display: block; margin-bottom: 8px; font-weight: 700;">Merchant Name</label>
            <input
                type="text"
                id="merchant_name"
                name="merchant_name"
                value="{{ old('merchant_name', $user->merchant_name) }}"
                style="width: 100%; box-sizing: border-box; padding: 12px; border: 1px solid #d5dcff; border-radius: 8px;"
            >
        </div>

        <div style="margin-bottom: 16px;">
            <label for="phone_number" style="display: block; margin-bottom: 8px; font-weight: 700;">Phone Number</label>
            <input
                type="tel"
                id="phone_number"
                name="phone_number"
                value="{{ old('phone_number', $user->phone_number) }}"
                style="width: 100%; box-sizing: border-box; padding: 12px; border: 1px solid #d5dcff; border-radius: 8px;"
            >
        </div>

        <div style="margin-bottom: 16px;">
            <label for="address" style="display: block; margin-bottom: 8px; font-weight: 700;">Address</label>
            <textarea
                id="address"
                name="address"
                rows="3"
                style="width: 100%; box-sizing: border-box; padding: 12px; border: 1px solid #d5dcff; border-radius: 8px;"
            >{{ old('address', $user->address) }}</textarea>
        </div>

        <div style="margin-bottom: 16px;">
            <label for="username" style="display: block; margin-bottom: 8px; font-weight: 700;">User Name</label>
            <input
                type="text"
                id="username"
                name="username"
                value="{{ old('username', $user->name) }}"
                style="width: 100%; box-sizing: border-box; padding: 12px; border: 1px solid #d5dcff; border-radius: 8px;"
                required
            >
        </div>

        <div style="margin-bottom: 24px;">
            <label for="password" style="display: block; margin-bottom: 8px; font-weight: 700;">New Password</label>
            <input
                type="password"
                id="password"
                name="password"
                placeholder="Leave empty to keep current password"
                style="width: 100%; box-sizing: border-box; padding: 12px; border: 1px solid #d5dcff; border-radius: 8px;"
            >
        </div>

        <button
            type="submit"
            style="padding: 12px 20px; border: none; border-radius: 8px; background: #FF823B; color: #fff; font-weight: 800; cursor: pointer;"
        >
            Update User
        </button>
    </form>
@endsection
