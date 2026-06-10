@extends('layouts.app')

@section('content')
    @php
        $user = Auth::user();
    @endphp

    <main style="padding: 40px 16px; background: #f5f7ff; min-height: 60vh;">
        <section style="width: 100%; max-width: 760px; margin: 0 auto; overflow: hidden; border-radius: 18px; background: #fff; box-shadow: 0 18px 40px rgba(36, 103, 255, 0.14);">
            <div style="padding: 34px 28px; background: linear-gradient(135deg, #2467FF, #4f85ff); color: #fff; text-align: center;">
                <div style="display: inline-flex; align-items: center; justify-content: center; width: 76px; height: 76px; margin-bottom: 14px; border-radius: 50%; background: #FF823B; font-size: 34px;">
                    &#128100;
                </div>
                <h1 style="margin: 0; font-size: 30px;">Profile</h1>
                <p style="margin: 8px 0 0; opacity: 0.9;">Your account details</p>
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 18px; padding: 28px;">
                <div style="padding: 18px; border: 1px solid #e8ecff; border-left: 5px solid #2467FF; border-radius: 12px; background: #fbfcff;">
                    <span style="display: block; margin-bottom: 8px; color: #6c757d; font-size: 13px; font-weight: 700; text-transform: uppercase;">User Name</span>
                    <strong style="color: #222; font-size: 18px;">{{ $user->name }}</strong>
                </div>

                <div style="padding: 18px; border: 1px solid #e8ecff; border-left: 5px solid #FF823B; border-radius: 12px; background: #fbfcff;">
                    <span style="display: block; margin-bottom: 8px; color: #6c757d; font-size: 13px; font-weight: 700; text-transform: uppercase;">Merchant Name</span>
                    <strong style="color: #222; font-size: 18px;">{{ $user->merchant_name ?? 'Not provided' }}</strong>
                </div>

                <div style="padding: 18px; border: 1px solid #e8ecff; border-left: 5px solid #2467FF; border-radius: 12px; background: #fbfcff;">
                    <span style="display: block; margin-bottom: 8px; color: #6c757d; font-size: 13px; font-weight: 700; text-transform: uppercase;">Phone</span>
                    <strong style="color: #222; font-size: 18px;">{{ $user->phone_number ?? 'Not provided' }}</strong>
                </div>

                <div style="padding: 18px; border: 1px solid #e8ecff; border-left: 5px solid #FF823B; border-radius: 12px; background: #fbfcff;">
                    <span style="display: block; margin-bottom: 8px; color: #6c757d; font-size: 13px; font-weight: 700; text-transform: uppercase;">Address</span>
                    <strong style="color: #222; font-size: 18px;">{{ $user->address ?? 'Not provided' }}</strong>
                </div>
            </div>
        </section>
    </main>
@endsection
