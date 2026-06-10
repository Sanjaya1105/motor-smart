<style>
    .category-tabs {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 28px;
        padding: 14px;
        border-radius: 16px;
        background: #fff;
        box-shadow: 0 14px 32px rgba(36, 103, 255, 0.1);
    }

    .category-tab-link {
        padding: 12px 18px;
        border-radius: 10px;
        background: #eef3ff;
        color: #2467FF;
        font-weight: 800;
        text-decoration: none;
        transition: background 0.2s ease, color 0.2s ease, transform 0.2s ease;
    }

    .category-tab-link:hover,
    .category-tab-link.active {
        background: #FF823B;
        color: #fff;
        transform: translateY(-2px);
    }
</style>

<nav class="category-tabs">
    <a href="{{ route('admin.categories.vehicle-brand') }}" class="category-tab-link {{ request()->routeIs('admin.categories.vehicle-brand') ? 'active' : '' }}">Vehicle Brand</a>
    <a href="{{ route('admin.categories.vehicle-type') }}" class="category-tab-link {{ request()->routeIs('admin.categories.vehicle-type') ? 'active' : '' }}">Vehicle Type</a>
    <a href="{{ route('admin.categories.product') }}" class="category-tab-link {{ request()->routeIs('admin.categories.product') ? 'active' : '' }}">Product</a>
</nav>
