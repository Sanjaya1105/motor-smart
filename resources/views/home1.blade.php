@extends('layouts.app')

@section('content')
    <style>
        .home-page {
            background: #f5f7ff;
        }

        .hero-section {
            display: grid;
            grid-template-columns: minmax(0, 1.2fr) minmax(280px, 0.8fr);
            gap: 32px;
            align-items: center;
            padding: 70px 40px;
            background: linear-gradient(135deg, #2467FF, #174fd4);
            color: #fff;
        }

        .hero-kicker {
            display: inline-block;
            padding: 8px 14px;
            margin-bottom: 18px;
            border-radius: 999px;
            background: rgba(255, 130, 59, 0.18);
            color: #fff;
            font-weight: 800;
            letter-spacing: 0.04em;
            text-transform: uppercase;
        }

        .hero-title {
            max-width: 760px;
            margin: 0;
            font-size: clamp(34px, 5vw, 60px);
            line-height: 1.05;
        }

        .hero-text {
            max-width: 680px;
            margin: 18px 0 28px;
            color: rgba(255, 255, 255, 0.88);
            font-size: 18px;
            line-height: 1.7;
        }

        .hero-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 14px;
        }

        .hero-button {
            padding: 13px 20px;
            border-radius: 10px;
            background: #FF823B;
            color: #fff;
            font-weight: 800;
            text-decoration: none;
        }

        .hero-button.secondary {
            background: #fff;
            color: #2467FF;
        }

        .hero-card {
            padding: 28px;
            border-radius: 24px;
            background: #fff;
            color: #222;
            box-shadow: 0 24px 60px rgba(0, 0, 0, 0.18);
        }

        .hero-card h2 {
            margin: 0 0 16px;
            color: #2467FF;
        }

        .hero-card ul {
            display: grid;
            gap: 12px;
            padding: 0;
            margin: 0;
            list-style: none;
        }

        .hero-card li {
            padding: 12px;
            border-left: 5px solid #FF823B;
            border-radius: 10px;
            background: #f5f7ff;
            font-weight: 700;
        }

        .home-section {
            padding: 56px 40px;
        }

        .section-heading {
            max-width: 760px;
            margin-bottom: 28px;
        }

        .section-heading h2 {
            margin: 0 0 10px;
            color: #2467FF;
            font-size: 34px;
        }

        .section-heading p {
            margin: 0;
            color: #6c757d;
            line-height: 1.6;
        }

        .product-card-grid,
        .process-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
            gap: 22px;
        }

        .product-card,
        .process-card {
            padding: 26px;
            border-radius: 20px;
            background: #fff;
            box-shadow: 0 14px 32px rgba(36, 103, 255, 0.1);
        }

        .product-card {
            position: relative;
            overflow: hidden;
            border-top: 6px solid #2467FF;
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }

        .product-card:nth-child(even) {
            border-top-color: #FF823B;
        }

        .product-card::after {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(36, 103, 255, 0.08), rgba(255, 130, 59, 0.08));
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.25s ease;
        }

        .product-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 24px 48px rgba(36, 103, 255, 0.18);
        }

        .product-card:hover::after {
            opacity: 1;
        }

        .product-image {
            width: 100%;
            height: 190px;
            margin-bottom: 20px;
            border-radius: 16px;
            object-fit: cover;
            background: #eef3ff;
            transition: transform 0.3s ease, filter 0.3s ease;
        }

        .product-card:hover .product-image {
            transform: scale(1.04);
            filter: saturate(1.15);
        }

        .product-card h3,
        .process-card h3 {
            margin: 0 0 10px;
            color: #222;
            transition: color 0.25s ease;
        }

        .product-card:hover h3 {
            color: #2467FF;
        }

        .product-card p,
        .process-card p {
            margin: 0;
            color: #6c757d;
            line-height: 1.6;
        }

        .process-card {
            border-left: 5px solid #FF823B;
        }

        .cta-section {
            margin: 0 40px 56px;
            padding: 34px;
            border-radius: 24px;
            background: #fff;
            box-shadow: 0 16px 36px rgba(36, 103, 255, 0.12);
            text-align: center;
        }

        .cta-section h2 {
            margin: 0 0 10px;
            color: #2467FF;
        }

        .cta-section p {
            margin: 0 0 22px;
            color: #6c757d;
        }

        @media (max-width: 768px) {
            .hero-section {
                grid-template-columns: 1fr;
                padding: 44px 18px;
            }

            .home-section {
                padding: 40px 18px;
            }

            .cta-section {
                margin: 0 18px 40px;
                padding: 24px;
            }
        }
    </style>

    <main class="home-page">
        <section class="hero-section">
            <div>
                <span class="hero-kicker">Wholesale Spare Parts Supply</span>
                <h1 class="hero-title">Reliable parts for businesses that keep vehicles moving.</h1>
                <p class="hero-text">
                    Motor Smart helps wholesale customers source fast-moving spare parts including bearings,
                    oil seals, and lower arms with a simple ordering process and dependable support.
                </p>
                <div class="hero-actions">
                    <a href="{{ route('product') }}" class="hero-button">Browse Products</a>
                    <a href="{{ route('contact-us') }}" class="hero-button secondary">Contact Sales</a>
                </div>
            </div>

            <aside class="hero-card">
                <h2>Built for wholesale buyers</h2>
                <ul>
                    <li>Bulk spare parts supply</li>
                    <li>Fast product lookup by item code</li>
                    <li>Business-focused customer support</li>
                    <li>Parts for workshops and resellers</li>
                </ul>
            </aside>
        </section>

        <section class="home-section">
            <div class="section-heading">
                <h2>Main Product Range</h2>
                <p>Popular product groups for wholesale customers who need consistent stock and easy reordering.</p>
            </div>

            <div class="product-card-grid">
                <article class="product-card">
                    <img src="{{ asset('img/home/bring.jpeg') }}" alt="Bearings" class="product-image">
                    <h3>Bearings</h3>
                    <p>Quality bearings for vehicle maintenance, repairs, workshops, and spare parts resellers.</p>
                </article>

                <article class="product-card">
                    <img src="{{ asset('img/home/oils.jpg') }}" alt="Oil Seals" class="product-image">
                    <h3>Oil Seals</h3>
                    <p>Oil seals for keeping engines, gear systems, and rotating components protected and reliable.</p>
                </article>

                <article class="product-card">
                    <img src="{{ asset('img/home/larms.png') }}" alt="Lower Arms" class="product-image">
                    <h3>Lower Arms</h3>
                    <p>Frequently requested lower arm parts supplied for wholesale buyers and regular business orders.</p>
                </article>
            </div>
        </section>

        <section class="home-section">
            <div class="section-heading">
                <h2>Simple Wholesale Process</h2>
                <p>Designed to help merchants find products, confirm availability, and place orders with less delay.</p>
            </div>

            <div class="process-grid">
                <article class="process-card">
                    <h3>Search Products</h3>
                    <p>Use product names, item codes, and keywords to quickly find spare parts.</p>
                </article>

                <article class="process-card">
                    <h3>Check Details</h3>
                    <p>Review product information and confirm the right part before ordering.</p>
                </article>

                <article class="process-card">
                    <h3>Contact Sales</h3>
                    <p>Reach out for wholesale pricing, stock availability, and order support.</p>
                </article>
            </div>
        </section>

        <section class="cta-section">
            <h2>Need regular spare parts supply?</h2>
            <p>Contact Motor Smart for wholesale support on bearings, oil seals, lower arms, and other fast-moving parts.</p>
            <a href="{{ route('contact-us') }}" class="hero-button">Get In Touch</a>
        </section>
    </main>
@endsection
