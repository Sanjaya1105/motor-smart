@extends('layouts.admin')

@section('title', 'Users')

@section('content')
    <style>
        .user-table {
            overflow-x: auto;
            border-radius: 14px;
            background: #fff;
            box-shadow: 0 10px 24px rgba(36, 103, 255, 0.08);
        }

        .user-table-header,
        .user-list-row {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 16px;
            min-width: 760px;
        }

        .user-table-header {
            padding: 16px 18px;
            background: #2467FF;
            color: #fff;
            font-size: 12px;
            font-weight: 800;
            letter-spacing: 0.04em;
            text-transform: uppercase;
        }

        .user-list-row {
            padding: 18px;
            border-bottom: 1px solid #edf0ff;
            align-items: center;
        }

        .user-list-row:last-child {
            border-bottom: none;
        }

        .user-actions {
            display: flex;
            gap: 8px;
            align-items: center;
            flex-wrap: wrap;
        }

        .user-action-link,
        .user-action-button {
            display: inline-block;
            padding: 9px 13px;
            border: none;
            border-radius: 8px;
            font: inherit;
            font-weight: 700;
            text-decoration: none;
            cursor: pointer;
        }

        .user-action-link {
            background: #2467FF;
            color: #fff;
        }

        .user-action-button {
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

        .user-search-form {
            display: flex;
            gap: 10px;
            max-width: 640px;
            margin-bottom: 20px;
        }

        .user-search-input {
            flex: 1;
            padding: 12px 14px;
            border: 1px solid #d5dcff;
            border-radius: 8px;
            font-size: 15px;
        }

        .user-search-button,
        .user-search-clear {
            padding: 12px 18px;
            border: none;
            border-radius: 8px;
            font-weight: 700;
            text-decoration: none;
            cursor: pointer;
        }

        .user-search-button {
            background: #2467FF;
            color: #fff;
        }

        .user-search-clear {
            background: #fff;
            color: #FF823B;
        }

        @media (max-width: 640px) {
            .user-search-form {
                flex-direction: column;
            }
        }
    </style>

    <h1>Users</h1>

    @if (session('success'))
        <p style="color: #198754; font-weight: 600;">{{ session('success') }}</p>
    @endif

    @if ($errors->any())
        <p style="color: #dc3545; font-weight: 600;">{{ $errors->first() }}</p>
    @endif

    <button
        type="button"
        id="show-register-form"
        style="padding: 10px 18px; border: none; border-radius: 4px; background: #2467FF; color: #fff; font-weight: 600; cursor: pointer;"
    >
        {{ $errors->any() ? 'Hide Register Form' : 'Register' }}
    </button>

    <form
        method="POST"
        action="{{ route('admin.users.store') }}"
        id="register-form"
        style="display: {{ $errors->any() ? 'block' : 'none' }}; width: 100%; max-width: 500px; box-sizing: border-box; margin-top: 30px; padding: 24px; border: 1px solid #e5e5e5; border-radius: 8px;"
    >
        @csrf

        <div style="margin-bottom: 16px;">
            <label for="merchant_name" style="display: block; margin-bottom: 8px; font-weight: 600;">Merchant Name</label>
            <input
                type="text"
                id="merchant_name"
                name="merchant_name"
                value="{{ old('merchant_name') }}"
                style="width: 100%; box-sizing: border-box; padding: 10px; border: 1px solid #ccc; border-radius: 4px;"
            >
        </div>

        <div style="margin-bottom: 16px;">
            <label for="phone_number" style="display: block; margin-bottom: 8px; font-weight: 600;">Phone Number</label>
            <input
                type="tel"
                id="phone_number"
                name="phone_number"
                value="{{ old('phone_number') }}"
                style="width: 100%; box-sizing: border-box; padding: 10px; border: 1px solid #ccc; border-radius: 4px;"
            >
        </div>

        <div style="margin-bottom: 16px;">
            <label for="address" style="display: block; margin-bottom: 8px; font-weight: 600;">Address</label>
            <textarea
                id="address"
                name="address"
                rows="3"
                style="width: 100%; box-sizing: border-box; padding: 10px; border: 1px solid #ccc; border-radius: 4px;"
            >{{ old('address') }}</textarea>
        </div>

        <div style="margin-bottom: 16px;">
            <label for="customer_name" style="display: block; margin-bottom: 8px; font-weight: 600;">Customer Name</label>
            <input
                type="text"
                id="customer_name"
                name="customer_name"
                value="{{ old('customer_name') }}"
                style="width: 100%; box-sizing: border-box; padding: 10px; border: 1px solid #ccc; border-radius: 4px;"
            >
        </div>

        <div style="margin-bottom: 16px;">
            <label for="id_number" style="display: block; margin-bottom: 8px; font-weight: 600;">ID Number</label>
            <input
                type="text"
                id="id_number"
                name="id_number"
                value="{{ old('id_number') }}"
                style="width: 100%; box-sizing: border-box; padding: 10px; border: 1px solid #ccc; border-radius: 4px;"
            >
        </div>

        <div style="margin-bottom: 16px;">
            <label for="br_number" style="display: block; margin-bottom: 8px; font-weight: 600;">BR Number</label>
            <input
                type="text"
                id="br_number"
                name="br_number"
                value="{{ old('br_number') }}"
                style="width: 100%; box-sizing: border-box; padding: 10px; border: 1px solid #ccc; border-radius: 4px;"
            >
        </div>

        <div style="margin-bottom: 16px;">
            <label for="bank" style="display: block; margin-bottom: 8px; font-weight: 600;">Bank</label>
            <input
                type="text"
                id="bank"
                name="bank"
                value="{{ old('bank') }}"
                style="width: 100%; box-sizing: border-box; padding: 10px; border: 1px solid #ccc; border-radius: 4px;"
            >
        </div>

        <div style="margin-bottom: 16px;">
            <label for="branch" style="display: block; margin-bottom: 8px; font-weight: 600;">Branch</label>
            <input
                type="text"
                id="branch"
                name="branch"
                value="{{ old('branch') }}"
                style="width: 100%; box-sizing: border-box; padding: 10px; border: 1px solid #ccc; border-radius: 4px;"
            >
        </div>

        <div style="margin-bottom: 16px;">
            <label for="account_number" style="display: block; margin-bottom: 8px; font-weight: 600;">Account Number</label>
            <input
                type="text"
                id="account_number"
                name="account_number"
                value="{{ old('account_number') }}"
                style="width: 100%; box-sizing: border-box; padding: 10px; border: 1px solid #ccc; border-radius: 4px;"
            >
        </div>

        <div style="margin-bottom: 16px;">
            <label for="payment_method" style="display: block; margin-bottom: 8px; font-weight: 600;">Payment Method</label>
            <select
                id="payment_method"
                name="payment_method"
                style="width: 100%; box-sizing: border-box; padding: 10px; border: 1px solid #ccc; border-radius: 4px;"
            >
                <option value="">Select payment method</option>
                <option value="Credit" @selected(old('payment_method') === 'Credit')>Credit</option>
                <option value="Cash" @selected(old('payment_method') === 'Cash')>Cash</option>
            </select>
        </div>

        <div style="margin-bottom: 16px;">
            <label for="username" style="display: block; margin-bottom: 8px; font-weight: 600;">User Name</label>
            <input
                type="text"
                id="username"
                name="username"
                value="{{ old('username') }}"
                style="width: 100%; box-sizing: border-box; padding: 10px; border: 1px solid #ccc; border-radius: 4px;"
                required
            >
        </div>

        <div style="margin-bottom: 24px;">
            <label for="password" style="display: block; margin-bottom: 8px; font-weight: 600;">Password</label>
            <input
                type="text"
                id="password"
                name="password"
                style="width: 100%; box-sizing: border-box; padding: 10px; border: 1px solid #ccc; border-radius: 4px;"
                required
            >
        </div>

        <button
            type="submit"
            style="padding: 10px 18px; border: none; border-radius: 4px; background: #FF823B; color: #fff; font-weight: 600; cursor: pointer;"
        >
            Submit
        </button>
    </form>

    <section style="margin-top: 36px;">
        <h2 style="color: #2467FF;">Registered Users</h2>

        <form method="GET" action="{{ route('admin.users') }}" class="user-search-form">
            <input
                type="search"
                name="search"
                value="{{ $search }}"
                class="user-search-input"
                placeholder="Search merchant name, user name, or phone number"
            >
            <button type="submit" class="user-search-button">Search</button>

            @if ($search !== '')
                <a href="{{ route('admin.users') }}" class="user-search-clear">Clear</a>
            @endif
        </form>

        @if ($users->count() === 0)
            <p style="padding: 18px; border-radius: 10px; background: #fff; color: #6c757d;">
                {{ $search !== '' ? 'No users found for this search.' : 'No users registered yet.' }}
            </p>
        @else
            <div class="user-table">
                <div class="user-table-header">
                    <span>Merchant Name</span>
                    <span>User Name</span>
                    <span>Phone Number</span>
                    <span>Actions</span>
                </div>

                @foreach ($users as $user)
                    <div class="user-list-row">
                        <div>
                            <strong>{{ $user->merchant_name ?? 'Not provided' }}</strong>
                        </div>

                        <div>
                            <strong>{{ $user->name }}</strong>
                        </div>

                        <div>
                            <strong>{{ $user->phone_number ?? 'Not provided' }}</strong>
                        </div>

                        <div>
                            <div class="user-actions">
                                <a href="{{ route('admin.users.edit', $user) }}" class="user-action-link">Update</a>

                                <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="user-action-button">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{ $users->links() }}
        @endif
    </section>

    <script>
        const registerButton = document.getElementById('show-register-form');
        const registerForm = document.getElementById('register-form');

        registerButton.addEventListener('click', function () {
            const isOpen = registerForm.style.display === 'block';

            registerForm.style.display = isOpen ? 'none' : 'block';
            registerButton.textContent = isOpen ? 'Register' : 'Hide Register Form';
        });
    </script>
@endsection
