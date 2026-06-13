@extends('layouts.admin')

@section('title', 'Configurations')

@section('content')
    <style>
        .config-card {
            max-width: 720px;
            padding: 28px;
            border-radius: 20px;
            background: #fff;
            box-shadow: 0 16px 36px rgba(36, 103, 255, 0.1);
            border-top: 6px solid #FF823B;
        }

        .config-current {
            display: inline-block;
            margin: 0 0 22px;
            padding: 10px 14px;
            border-radius: 999px;
            background: #eef3ff;
            color: #2467FF;
            font-weight: 900;
        }

        .config-field {
            display: grid;
            gap: 8px;
            margin-bottom: 18px;
        }

        .config-field label {
            color: #222;
            font-weight: 800;
        }

        .config-field input {
            padding: 13px 14px;
            border: 1px solid #d5dcff;
            border-radius: 10px;
            font: inherit;
        }

        .config-help {
            margin: 0;
            color: #6c757d;
            font-size: 14px;
            line-height: 1.6;
        }

        .config-button {
            padding: 12px 18px;
            border: none;
            border-radius: 10px;
            background: #2467FF;
            color: #fff;
            cursor: pointer;
            font-weight: 900;
        }

        .config-success {
            margin: 0 0 18px;
            padding: 12px 14px;
            border-radius: 10px;
            background: #d1e7dd;
            color: #0f5132;
            font-weight: 800;
        }

        .config-error {
            margin: 0 0 18px;
            padding: 12px 14px;
            border-radius: 10px;
            background: #f8d7da;
            color: #842029;
            font-weight: 800;
        }
    </style>

    <section class="admin-page-header">
        <div>
            <h1>Configurations</h1>
            <p>Manage website settings used by customer order flows.</p>
        </div>

        <span class="admin-badge">Settings</span>
    </section>

    <section class="config-card">
        @if (session('success'))
            <p class="config-success">{{ session('success') }}</p>
        @endif

        @error('whatsapp_number')
            <p class="config-error">{{ $message }}</p>
        @enderror

        <p class="config-current">Current WhatsApp Number: {{ $whatsappNumber }}</p>

        <form method="POST" action="{{ route('admin.configurations.whatsapp-number.update') }}">
            @csrf

            <div class="config-field">
                <label for="whatsapp_number">Change WhatsApp Number</label>
                <input
                    type="text"
                    id="whatsapp_number"
                    name="whatsapp_number"
                    value="{{ old('whatsapp_number', $whatsappNumber) }}"
                    placeholder="Example: 071 796 9685"
                    required
                >
                <p class="config-help">
                    This number will be used for Send Order, floating WhatsApp buttons, and WhatsApp links across the customer website.
                </p>
            </div>

            <button type="submit" class="config-button">Update WhatsApp Number</button>
        </form>
    </section>
@endsection
