@extends('layouts.admin')

@section('title', 'Admin page')

@section('content')
    <section class="admin-page-header">
        <div>
            <h1>Admin Dashboard</h1>
            <p>Manage Motor Smart users, categories, and products from one place.</p>
        </div>

        <span class="admin-badge">Welcome, TestAdmin</span>
    </section>

    <section class="admin-card-grid">
        <div class="admin-card">
            <h2>Users</h2>
            <p>Register merchants and manage the user accounts that can access the customer pages.</p>
        </div>

        <div class="admin-card">
            <h2>Categories</h2>
            <p>Prepare and organize product categories for spare parts and accessories.</p>
        </div>

        <div class="admin-card">
            <h2>Products</h2>
            <p>Use this section to manage products that will appear in the store pages.</p>
        </div>
    </section>
@endsection
