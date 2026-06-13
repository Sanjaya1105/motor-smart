@extends('layouts.app')

@section('content')
    <style>
        .about-page {
            background: #f5f7ff;
        }

        .about-hero {
            display: grid;
            grid-template-columns: minmax(0, 1.15fr) minmax(280px, 0.85fr);
            gap: 34px;
            align-items: center;
            padding: 70px 40px;
            background:
                radial-gradient(circle at top right, rgba(255, 130, 59, 0.28), transparent 34%),
                linear-gradient(135deg, #2467FF, #174fd4);
            color: #fff;
        }

        .about-kicker {
            display: inline-block;
            padding: 8px 14px;
            margin-bottom: 18px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.16);
            font-weight: 900;
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }

        .about-hero h1 {
            max-width: 760px;
            margin: 0;
            font-size: clamp(34px, 5vw, 58px);
            line-height: 1.06;
        }

        .about-hero p {
            max-width: 680px;
            margin: 20px 0 0;
            color: rgba(255, 255, 255, 0.9);
            font-size: 18px;
            line-height: 1.7;
        }

        .about-highlight-card {
            padding: 28px;
            border-radius: 24px;
            background: #fff;
            color: #222;
            box-shadow: 0 24px 60px rgba(0, 0, 0, 0.18);
        }

        .about-highlight-card h2 {
            margin: 0 0 16px;
            color: #2467FF;
        }

        .about-highlight-card ul {
            display: grid;
            gap: 12px;
            padding: 0;
            margin: 0;
            list-style: none;
        }

        .about-highlight-card li {
            padding: 13px;
            border-left: 5px solid #FF823B;
            border-radius: 12px;
            background: #f5f7ff;
            font-weight: 800;
        }

        .about-section {
            padding: 58px 40px;
        }

        .about-heading {
            max-width: 780px;
            margin-bottom: 28px;
        }

        .about-heading h2 {
            margin: 0 0 10px;
            color: #2467FF;
            font-size: clamp(28px, 4vw, 40px);
        }

        .about-heading p {
            margin: 0;
            color: #6c757d;
            line-height: 1.7;
        }

        .about-story-grid {
            display: grid;
            grid-template-columns: minmax(0, 1fr) minmax(260px, 0.75fr);
            gap: 24px;
            align-items: stretch;
        }

        .about-story,
        .about-stat-card,
        .about-value-card {
            border-radius: 22px;
            background: #fff;
            box-shadow: 0 14px 34px rgba(36, 103, 255, 0.1);
        }

        .about-story {
            padding: 30px;
            border-top: 6px solid #FF823B;
        }

        .about-story p {
            color: #555;
            line-height: 1.8;
        }

        .about-story p:first-child {
            margin-top: 0;
        }

        .about-stat-stack {
            display: grid;
            gap: 16px;
        }

        .about-stat-card {
            padding: 24px;
            border-left: 6px solid #2467FF;
        }

        .about-stat-card strong {
            display: block;
            margin-bottom: 6px;
            color: #FF823B;
            font-size: 34px;
        }

        .about-stat-card span {
            color: #555;
            font-weight: 800;
        }

        .about-values-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 22px;
        }

        .about-value-card {
            position: relative;
            overflow: hidden;
            padding: 26px;
            border-top: 6px solid #2467FF;
        }

        .about-value-card:nth-child(even) {
            border-top-color: #FF823B;
        }

        .about-value-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 54px;
            height: 54px;
            margin-bottom: 16px;
            border-radius: 16px;
            background: #eef3ff;
            color: #2467FF;
            font-size: 26px;
            font-weight: 900;
        }

        .about-value-card h3 {
            margin: 0 0 10px;
            color: #222;
        }

        .about-value-card p {
            margin: 0;
            color: #6c757d;
            line-height: 1.7;
        }

        .about-cta {
            margin: 0 40px 58px;
            padding: 34px;
            border-radius: 24px;
            background: linear-gradient(135deg, #FF823B, #ff9b63);
            color: #fff;
            text-align: center;
            box-shadow: 0 18px 42px rgba(255, 130, 59, 0.24);
        }

        .about-cta h2 {
            margin: 0 0 10px;
            font-size: clamp(26px, 4vw, 38px);
        }

        .about-cta p {
            max-width: 680px;
            margin: 0 auto 22px;
            line-height: 1.7;
        }

        .about-cta a {
            display: inline-block;
            padding: 13px 20px;
            border-radius: 10px;
            background: #2467FF;
            color: #fff;
            font-weight: 900;
            text-decoration: none;
        }

        @media (max-width: 768px) {
            .about-hero,
            .about-story-grid {
                grid-template-columns: 1fr;
            }

            .about-hero,
            .about-section {
                padding: 42px 18px;
            }

            .about-cta {
                margin: 0 18px 42px;
                padding: 26px 18px;
            }
        }
    </style>

    <main class="about-page">
        <section class="about-hero">
            <div>
                <span class="about-kicker">About Motor Smart</span>
                <h1>Wholesale spare parts supply built around trust, speed, and the right item code.</h1>
                <p>
                    Motor Smart supports merchants and wholesale buyers with reliable spare parts sourcing for fast-moving vehicle products.
                    We keep the buying process simple: identify the product, confirm the quantity, and send the order quickly.
                </p>
            </div>

            <div class="about-highlight-card">
                <h2>What We Focus On</h2>
                <ul>
                    <li>Clear product names and item codes</li>
                    <li>Wholesale-friendly order handling</li>
                    <li>Fast communication through WhatsApp</li>
                    <li>Reliable product category organization</li>
                </ul>
            </div>
        </section>

        <section class="about-section">
            <div class="about-heading">
                <h2>Our Story</h2>
                <p>
                    We built this platform to make product selection easier for repeat wholesale customers.
                </p>
            </div>

            <div class="about-story-grid">
                <div class="about-story">
                    <p>
                        Spare parts buying can become slow when product names, codes, quantities, and contact details are shared in many different ways.
                        Motor Smart brings those details into one clear flow so merchants can browse products, add quantities, and send a complete order message.
                    </p>
                    <p>
                        Our goal is to reduce back-and-forth communication and help customers choose the correct product with confidence.
                        Every product is presented with the important details buyers need before placing an order.
                    </p>
                </div>

                <div class="about-stat-stack">
                    <div class="about-stat-card">
                        <strong>01</strong>
                        <span>Browse products by category and item code.</span>
                    </div>
                    <div class="about-stat-card">
                        <strong>02</strong>
                        <span>Add the required quantity to the cart.</span>
                    </div>
                    <div class="about-stat-card">
                        <strong>03</strong>
                        <span>Send the full order details through WhatsApp.</span>
                    </div>
                </div>
            </div>
        </section>

        <section class="about-section">
            <div class="about-heading">
                <h2>Why Customers Choose Us</h2>
                <p>
                    We keep the experience direct, practical, and matched to how wholesale customers actually place orders.
                </p>
            </div>

            <div class="about-values-grid">
                <article class="about-value-card">
                    <span class="about-value-icon">Q</span>
                    <h3>Quality Attention</h3>
                    <p>Products are organized with names, images, descriptions, and item codes to help customers identify what they need.</p>
                </article>

                <article class="about-value-card">
                    <span class="about-value-icon">S</span>
                    <h3>Simple Ordering</h3>
                    <p>The cart prepares a clean WhatsApp message with merchant details, products, item codes, and quantities.</p>
                </article>

                <article class="about-value-card">
                    <span class="about-value-icon">F</span>
                    <h3>Fast Communication</h3>
                    <p>Customers can reach us quickly by phone, email, or WhatsApp for availability and order confirmation.</p>
                </article>
            </div>
        </section>

        <section class="about-cta">
            <h2>Ready to find the right spare parts?</h2>
            <p>Browse the product list and send your wholesale order details directly to our team.</p>
            <a href="{{ route('product') }}">Browse Products</a>
        </section>
    </main>
@endsection
