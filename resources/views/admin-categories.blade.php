@extends('layouts.admin')

@section('title', 'Categories')

@section('content')
    <section class="admin-page-header">
        <div>
            <h1>Categories</h1>
            <p>Manage vehicle brands, vehicle types, and product categories.</p>
        </div>
    </section>

    @include('partials.admin-category-nav')
@endsection
