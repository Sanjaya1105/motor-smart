@extends('layouts.app')

@section('content')
    <style>
        .contact-page {
            background: #f5f7ff;
        }

        .contact-hero {
            display: grid;
            grid-template-columns: minmax(0, 1fr) minmax(280px, 0.8fr);
            gap: 32px;
            align-items: center;
            padding: 70px 40px;
            background:
                radial-gradient(circle at top left, rgba(255, 130, 59, 0.28), transparent 32%),
                linear-gradient(135deg, #174fd4, #2467FF);
            color: #fff;
        }

        .contact-kicker {
            display: inline-block;
            padding: 8px 14px;
            margin-bottom: 18px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.16);
            font-weight: 900;
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }

        .contact-hero h1 {
            max-width: 760px;
            margin: 0;
            font-size: clamp(34px, 5vw, 58px);
            line-height: 1.06;
        }

        .contact-hero p {
            max-width: 680px;
            margin: 20px 0 0;
            color: rgba(255, 255, 255, 0.9);
            font-size: 18px;
            line-height: 1.7;
        }

        .contact-quick-card {
            padding: 28px;
            border-radius: 24px;
            background: #fff;
            color: #222;
            box-shadow: 0 24px 60px rgba(0, 0, 0, 0.18);
        }

        .contact-quick-card h2 {
            margin: 0 0 16px;
            color: #2467FF;
        }

        .contact-quick-list {
            display: grid;
            gap: 12px;
            padding: 0;
            margin: 0;
            list-style: none;
        }

        .contact-quick-list a,
        .contact-quick-list span {
            display: block;
            padding: 13px;
            border-left: 5px solid #FF823B;
            border-radius: 12px;
            background: #f5f7ff;
            color: #222;
            font-weight: 800;
            text-decoration: none;
        }

        .contact-section {
            padding: 58px 40px;
        }

        .contact-heading {
            max-width: 760px;
            margin-bottom: 28px;
        }

        .contact-heading h2 {
            margin: 0 0 10px;
            color: #2467FF;
            font-size: clamp(28px, 4vw, 40px);
        }

        .contact-heading p {
            margin: 0;
            color: #6c757d;
            line-height: 1.7;
        }

        .contact-card-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
            gap: 22px;
        }

        .contact-card {
            padding: 26px;
            border-radius: 22px;
            background: #fff;
            box-shadow: 0 14px 34px rgba(36, 103, 255, 0.1);
            border-top: 6px solid #2467FF;
        }

        .contact-card:nth-child(even) {
            border-top-color: #FF823B;
        }

        .contact-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 54px;
            height: 54px;
            margin-bottom: 16px;
            border-radius: 16px;
            background: #eef3ff;
            color: #2467FF;
            font-size: 25px;
            font-weight: 900;
        }

        .contact-card h3 {
            margin: 0 0 10px;
            color: #222;
        }

        .contact-card p,
        .contact-card a {
            margin: 0;
            color: #6c757d;
            line-height: 1.7;
            text-decoration: none;
        }

        .contact-card a:hover {
            color: #FF823B;
        }

        .contact-panel {
            display: grid;
            grid-template-columns: minmax(0, 0.9fr) minmax(280px, 1.1fr);
            gap: 24px;
            align-items: stretch;
            padding: 0 40px 58px;
        }

        .contact-address,
        .contact-message-box {
            padding: 30px;
            border-radius: 24px;
            background: #fff;
            box-shadow: 0 14px 34px rgba(36, 103, 255, 0.1);
        }

        .contact-address {
            border-left: 7px solid #FF823B;
        }

        .contact-address h2,
        .contact-message-box h2 {
            margin: 0 0 14px;
            color: #2467FF;
        }

        .contact-address p {
            color: #555;
            line-height: 1.8;
        }

        .contact-message-box {
            background: linear-gradient(135deg, #2467FF, #174fd4);
            color: #fff;
        }

        .contact-message-box h2 {
            color: #fff;
        }

        .contact-message-box p {
            color: rgba(255, 255, 255, 0.9);
            line-height: 1.7;
        }

        .contact-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 22px;
        }

        .contact-action-button {
            display: inline-block;
            padding: 13px 18px;
            border-radius: 10px;
            background: #FF823B;
            color: #fff;
            font-weight: 900;
            text-decoration: none;
        }

        .contact-action-button.secondary {
            background: #fff;
            color: #2467FF;
        }

        .contact-note {
            margin-top: 18px;
            padding: 14px;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.14);
            color: #fff;
            font-weight: 800;
        }

        @media (max-width: 768px) {
            .contact-hero,
            .contact-panel {
                grid-template-columns: 1fr;
            }

            .contact-hero,
            .contact-section {
                padding: 42px 18px;
            }

            .contact-panel {
                padding: 0 18px 42px;
            }

            .contact-address,
            .contact-message-box {
                padding: 24px 18px;
            }
        }
    </style>

    @php
        $whatsappNumber = \App\Models\SiteSetting::getValue('whatsapp_number', '071 796 9685');
        $whatsappLinkNumber = \App\Models\SiteSetting::toWhatsappNumber($whatsappNumber);
    @endphp

    <main class="contact-page">
        <section class="contact-hero">
            <div>
                <span class="contact-kicker">Contact Us</span>
                <h1>Need spare parts support? Reach Motor Smart quickly.</h1>
                <p>
                    Contact our team for wholesale product availability, item code confirmation, quantity checking, and order support.
                    We are ready to help you place the right order with clear details.
                </p>
            </div>

            <div class="contact-quick-card">
                <h2>Quick Contact</h2>
                <ul class="contact-quick-list">
                    <li><a href="tel:0112244445">Telephone: 011 2244445</a></li>
                    <li><a href="tel:0717969685">Mobile: 071 796 9685</a></li>
                    <li><a href="mailto:motorsmart@gmail.com">Email: motorsmart@gmail.com</a></li>
                    <li><a href="https://wa.me/{{ $whatsappLinkNumber }}" target="_blank" rel="noopener">WhatsApp: {{ $whatsappNumber }}</a></li>
                    <li><span>Address: 334/C/3, Batagama South, Kandana</span></li>
                </ul>
            </div>
        </section>

        <section class="contact-section">
            <div class="contact-heading">
                <h2>Choose the easiest way to reach us</h2>
                <p>
                    Send product details through WhatsApp, call us for urgent support, or email us for order information.
                </p>
            </div>

            <div class="contact-card-grid">
                <article class="contact-card">
                    <span class="contact-icon">P</span>
                    <h3>Phone Support</h3>
                    <p><a href="tel:0112244445">011 2244445</a></p>
                    <p><a href="tel:0717969685">071 796 9685</a></p>
                    <p>Best for urgent product or quantity confirmation.</p>
                </article>

                <article class="contact-card">
                    <span class="contact-icon">W</span>
                    <h3>WhatsApp Orders</h3>
                    <p><a href="https://wa.me/{{ $whatsappLinkNumber }}" target="_blank" rel="noopener">Message us on WhatsApp</a></p>
                    <p>Send cart orders, item codes, and quantities directly.</p>
                </article>

                <article class="contact-card">
                    <span class="contact-icon">E</span>
                    <h3>Email Inquiries</h3>
                    <p><a href="mailto:motorsmart@gmail.com">motorsmart@gmail.com</a></p>
                    <p>Useful for longer product requests and order notes.</p>
                </article>
            </div>
        </section>

        <section class="contact-panel">
            <div class="contact-address">
                <h2>Visit or Contact</h2>
                <p>
                    Motor Smart<br>
                    334/C/3,<br>
                    Batagama South,<br>
                    Kandana
                </p>
                <p>
                    Please contact us before visiting so our team can prepare the relevant product information for you.
                </p>
            </div>

            <div class="contact-message-box">
                <h2>Send a complete order faster</h2>
                <p>
                    Add products to your cart, enter quantities, and use the Send Order button.
                    WhatsApp will open with your merchant details, product names, item codes, and quantities already prepared.
                </p>
                <div class="contact-actions">
                    <a href="{{ route('product') }}" class="contact-action-button">Browse Products</a>
                    <a href="https://wa.me/{{ $whatsappLinkNumber }}" target="_blank" rel="noopener" class="contact-action-button secondary">Open WhatsApp</a>
                </div>
                <div class="contact-note">
                    Tip: Include item codes when asking about product availability.
                </div>
            </div>
        </section>
    </main>
@endsection
