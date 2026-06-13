<?php

use App\Models\CategoryProduct;
use App\Models\Prod;
use App\Models\SiteSetting;
use App\Models\User;
use App\Models\VehicleBrand;
use App\Models\VehicleType;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', function () {
    if (Auth::check()) {
        return Auth::user()?->name === 'TestAdmin'
            ? redirect()->route('admin')
            : redirect()->route('home1');
    }

    return view('login');
})->name('login');

Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'username' => ['required', 'string'],
        'password' => ['required', 'string'],
    ]);

    if (Auth::attempt(['name' => $credentials['username'], 'password' => $credentials['password']], true)) {
        $request->session()->regenerate();

        if ($credentials['username'] === 'TestAdmin') {
            return redirect()->route('admin');
        }

        return redirect()->route('home1');
    }

    return back()
        ->withErrors(['username' => 'The provided login details are incorrect.'])
        ->onlyInput('username');
})->name('login.submit');

Route::middleware('auth')->group(function () {
    Route::get('/home1', function () {
        return view('home1');
    })->name('home1');

    Route::get('/product', function (Request $request) {
        $search = trim((string) $request->query('search', ''));
        $perPage = 10;

        if ($search !== '') {
            $products = Prod::with(['vehicleBrand', 'vehicleType', 'categoryProduct'])
                ->where(function ($query) use ($search) {
                    $query
                        ->where('name', 'like', "%{$search}%")
                        ->orWhere('item_code', 'like', "%{$search}%")
                        ->orWhere('search_keys', 'like', "%{$search}%");
                })
                ->latest()
                ->paginate($perPage)
                ->withQueryString();
        } else {
            if (! $request->query->has('page') || ! $request->session()->has('product_random_ids')) {
                $request->session()->put(
                    'product_random_ids',
                    Prod::query()->inRandomOrder()->limit(20)->pluck('id')->all()
                );
            }

            $randomProductIds = $request->session()->get('product_random_ids', []);
            $randomProducts = Prod::with(['vehicleBrand', 'vehicleType', 'categoryProduct'])
                ->whereIn('id', $randomProductIds)
                ->get()
                ->sortBy(fn ($product) => array_search($product->id, $randomProductIds, true))
                ->values();

            $currentPage = LengthAwarePaginator::resolveCurrentPage();
            $products = new LengthAwarePaginator(
                $randomProducts->forPage($currentPage, $perPage)->values(),
                $randomProducts->count(),
                $perPage,
                $currentPage,
                [
                    'path' => route('product'),
                    'query' => $request->query(),
                ]
            );
        }

        return view('product', [
            'products' => $products,
            'search' => $search,
        ]);
    })->name('product');

    Route::get('/product/{product}', function (Prod $product) {
        $product->load(['vehicleBrand', 'vehicleType', 'categoryProduct']);

        return view('product-details', ['product' => $product]);
    })->name('product.details');

    Route::post('/cart', function (Request $request) {
        $validated = $request->validate([
            'product_id' => ['required', 'exists:prod,id'],
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $product = Prod::findOrFail($validated['product_id']);
        $cart = session()->get('cart', []);
        $isFirstCartItem = empty($cart);
        $productId = (string) $product->id;

        $cart[$productId] = [
            'product_id' => $product->id,
            'name' => $product->name,
            'item_code' => $product->item_code,
            'image_path' => $product->image_path,
            'quantity' => ($cart[$productId]['quantity'] ?? 0) + $validated['quantity'],
        ];

        session(['cart' => $cart]);

        if ($isFirstCartItem) {
            return redirect()->route('cart')->with('success', 'Product added to cart successfully.');
        }

        return back()->with('success', 'Product added to cart successfully.');
    })->name('cart.add');

    Route::get('/cart', function () {
        return view('cart', ['cartItems' => session('cart', [])]);
    })->name('cart');

    Route::get('/cart/product-search', function (Request $request) {
        $search = trim((string) $request->query('search', ''));

        if ($search === '') {
            return response()->json([]);
        }

        $products = Prod::query()
            ->where(function ($query) use ($search) {
                $query
                    ->where('name', 'like', "%{$search}%")
                    ->orWhere('item_code', 'like', "%{$search}%")
                    ->orWhere('search_keys', 'like', "%{$search}%");
            })
            ->latest()
            ->limit(10)
            ->get(['id', 'name', 'item_code', 'image_path'])
            ->map(fn ($product) => [
                'id' => $product->id,
                'name' => $product->name,
                'item_code' => $product->item_code,
                'image_url' => asset($product->image_path),
            ]);

        return response()->json($products);
    })->name('cart.product-search');

    Route::post('/cart/{productId}', function (Request $request, string $productId) {
        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] = $validated['quantity'];
            session(['cart' => $cart]);
        }

        return back()->with('success', 'Cart updated successfully.');
    })->whereNumber('productId')->name('cart.update');

    Route::delete('/cart/{productId}', function (string $productId) {
        $cart = session()->get('cart', []);

        unset($cart[$productId]);
        session(['cart' => $cart]);

        return back()->with('success', 'Product removed from cart.');
    })->whereNumber('productId')->name('cart.remove');

    Route::post('/cart/clear', function () {
        session()->forget('cart');

        return response()->noContent();
    })->name('cart.clear');

    Route::get('/about-us', function () {
        return view('about-us');
    })->name('about-us');

    Route::get('/contact-us', function () {
        return view('contact-us');
    })->name('contact-us');

    Route::get('/profile', function () {
        return view('profile');
    })->name('profile');

    Route::get('/admin', function () {
        abort_unless(Auth::user()?->name === 'TestAdmin', 403);

        return view('admin');
    })->name('admin');

    Route::get('/admin/configurations', function () {
        abort_unless(Auth::user()?->name === 'TestAdmin', 403);

        return view('admin-configurations', [
            'whatsappNumber' => SiteSetting::getValue('whatsapp_number', '071 796 9685'),
        ]);
    })->name('admin.configurations');

    Route::post('/admin/configurations/whatsapp-number', function (Request $request) {
        abort_unless(Auth::user()?->name === 'TestAdmin', 403);

        $validated = $request->validate([
            'whatsapp_number' => ['required', 'string', 'max:30', 'regex:/^[0-9+\s()-]+$/'],
        ]);

        SiteSetting::setValue('whatsapp_number', $validated['whatsapp_number']);

        return back()->with('success', 'WhatsApp number updated successfully.');
    })->name('admin.configurations.whatsapp-number.update');

    Route::get('/admin/users', function (Request $request) {
        abort_unless(Auth::user()?->name === 'TestAdmin', 403);

        $search = $request->string('search')->trim()->toString();

        $users = User::where('name', '!=', 'TestAdmin')
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('merchant_name', 'like', "%{$search}%")
                        ->orWhere('name', 'like', "%{$search}%")
                        ->orWhere('phone_number', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin-users', [
            'users' => $users,
            'search' => $search,
        ]);
    })->name('admin.users');

    Route::post('/admin/users', function (Request $request) {
        abort_unless(Auth::user()?->name === 'TestAdmin', 403);

        $validated = $request->validate([
            'merchant_name' => ['nullable', 'string', 'max:255'],
            'phone_number' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string'],
            'customer_name' => ['nullable', 'string', 'max:255'],
            'id_number' => ['nullable', 'string', 'max:255'],
            'br_number' => ['nullable', 'string', 'max:255'],
            'bank' => ['nullable', 'string', 'max:255'],
            'branch' => ['nullable', 'string', 'max:255'],
            'account_number' => ['nullable', 'string', 'max:255'],
            'payment_method' => ['nullable', 'in:Credit,Cash'],
            'username' => ['required', 'string', 'max:255', 'not_in:TestAdmin', 'unique:users,name'],
            'password' => ['required', 'string'],
        ]);

        User::create([
            'name' => $validated['username'],
            'merchant_name' => $validated['merchant_name'] ?? null,
            'phone_number' => $validated['phone_number'] ?? null,
            'address' => $validated['address'] ?? null,
            'customer_name' => $validated['customer_name'] ?? null,
            'id_number' => $validated['id_number'] ?? null,
            'br_number' => $validated['br_number'] ?? null,
            'bank' => $validated['bank'] ?? null,
            'branch' => $validated['branch'] ?? null,
            'account_number' => $validated['account_number'] ?? null,
            'payment_method' => $validated['payment_method'] ?? null,
            'email' => Str::slug($validated['username']).'-'.Str::random(8).'@motor-smart.local',
            'password' => $validated['password'],
        ]);

        return back()->with('success', 'User registered successfully.');
    })->name('admin.users.store');

    Route::get('/admin/users/{user}/edit', function (User $user) {
        abort_unless(Auth::user()?->name === 'TestAdmin', 403);
        abort_if($user->name === 'TestAdmin', 403);

        return view('admin-user-edit', ['user' => $user]);
    })->name('admin.users.edit');

    Route::put('/admin/users/{user}', function (Request $request, User $user) {
        abort_unless(Auth::user()?->name === 'TestAdmin', 403);
        abort_if($user->name === 'TestAdmin', 403);

        $validated = $request->validate([
            'merchant_name' => ['nullable', 'string', 'max:255'],
            'phone_number' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string'],
            'customer_name' => ['nullable', 'string', 'max:255'],
            'id_number' => ['nullable', 'string', 'max:255'],
            'br_number' => ['nullable', 'string', 'max:255'],
            'bank' => ['nullable', 'string', 'max:255'],
            'branch' => ['nullable', 'string', 'max:255'],
            'account_number' => ['nullable', 'string', 'max:255'],
            'payment_method' => ['nullable', 'in:Credit,Cash'],
            'username' => ['required', 'string', 'max:255', 'not_in:TestAdmin', 'unique:users,name,'.$user->id],
            'password' => ['nullable', 'string'],
        ]);

        $user->name = $validated['username'];
        $user->merchant_name = $validated['merchant_name'] ?? null;
        $user->phone_number = $validated['phone_number'] ?? null;
        $user->address = $validated['address'] ?? null;
        $user->customer_name = $validated['customer_name'] ?? null;
        $user->id_number = $validated['id_number'] ?? null;
        $user->br_number = $validated['br_number'] ?? null;
        $user->bank = $validated['bank'] ?? null;
        $user->branch = $validated['branch'] ?? null;
        $user->account_number = $validated['account_number'] ?? null;
        $user->payment_method = $validated['payment_method'] ?? null;

        if (! empty($validated['password'])) {
            $user->password = $validated['password'];
        }

        $user->save();

        return redirect()->route('admin.users')->with('success', 'User updated successfully.');
    })->name('admin.users.update');

    Route::delete('/admin/users/{user}', function (User $user) {
        abort_unless(Auth::user()?->name === 'TestAdmin', 403);
        abort_if($user->name === 'TestAdmin', 403);

        $user->delete();

        return redirect()->route('admin.users')->with('success', 'User deleted successfully.');
    })->name('admin.users.destroy');

    Route::get('/admin/categories', function () {
        abort_unless(Auth::user()?->name === 'TestAdmin', 403);

        return view('admin-categories');
    })->name('admin.categories');

    Route::get('/admin/categories/vehicle-brand', function () {
        abort_unless(Auth::user()?->name === 'TestAdmin', 403);

        $vehicleBrands = VehicleBrand::latest()->paginate(10);

        return view('admin-category-vehicle-brand', ['vehicleBrands' => $vehicleBrands]);
    })->name('admin.categories.vehicle-brand');

    Route::post('/admin/categories/vehicle-brand', function (Request $request) {
        abort_unless(Auth::user()?->name === 'TestAdmin', 403);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:vehcle_brands,name'],
        ]);

        VehicleBrand::create($validated);

        return back()->with('success', 'Vehicle brand added successfully.');
    })->name('admin.categories.vehicle-brand.store');

    Route::get('/admin/categories/vehicle-brand/{vehicleBrand}/edit', function (VehicleBrand $vehicleBrand) {
        abort_unless(Auth::user()?->name === 'TestAdmin', 403);

        return view('admin-category-vehicle-brand-edit', ['vehicleBrand' => $vehicleBrand]);
    })->name('admin.categories.vehicle-brand.edit');

    Route::put('/admin/categories/vehicle-brand/{vehicleBrand}', function (Request $request, VehicleBrand $vehicleBrand) {
        abort_unless(Auth::user()?->name === 'TestAdmin', 403);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:vehcle_brands,name,'.$vehicleBrand->id],
        ]);

        $vehicleBrand->update($validated);

        return redirect()
            ->route('admin.categories.vehicle-brand')
            ->with('success', 'Vehicle brand updated successfully.');
    })->name('admin.categories.vehicle-brand.update');

    Route::delete('/admin/categories/vehicle-brand/{vehicleBrand}', function (VehicleBrand $vehicleBrand) {
        abort_unless(Auth::user()?->name === 'TestAdmin', 403);

        $vehicleBrand->delete();

        return back()->with('success', 'Vehicle brand deleted successfully.');
    })->name('admin.categories.vehicle-brand.destroy');

    Route::get('/admin/categories/vehicle-type', function () {
        abort_unless(Auth::user()?->name === 'TestAdmin', 403);

        $vehicleTypes = VehicleType::latest()->paginate(10);

        return view('admin-category-vehicle-type', ['vehicleTypes' => $vehicleTypes]);
    })->name('admin.categories.vehicle-type');

    Route::post('/admin/categories/vehicle-type', function (Request $request) {
        abort_unless(Auth::user()?->name === 'TestAdmin', 403);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:vehicle_types,name'],
        ]);

        VehicleType::create($validated);

        return back()->with('success', 'Vehicle type added successfully.');
    })->name('admin.categories.vehicle-type.store');

    Route::get('/admin/categories/vehicle-type/{vehicleType}/edit', function (VehicleType $vehicleType) {
        abort_unless(Auth::user()?->name === 'TestAdmin', 403);

        return view('admin-category-vehicle-type-edit', ['vehicleType' => $vehicleType]);
    })->name('admin.categories.vehicle-type.edit');

    Route::put('/admin/categories/vehicle-type/{vehicleType}', function (Request $request, VehicleType $vehicleType) {
        abort_unless(Auth::user()?->name === 'TestAdmin', 403);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:vehicle_types,name,'.$vehicleType->id],
        ]);

        $vehicleType->update($validated);

        return redirect()
            ->route('admin.categories.vehicle-type')
            ->with('success', 'Vehicle type updated successfully.');
    })->name('admin.categories.vehicle-type.update');

    Route::delete('/admin/categories/vehicle-type/{vehicleType}', function (VehicleType $vehicleType) {
        abort_unless(Auth::user()?->name === 'TestAdmin', 403);

        $vehicleType->delete();

        return back()->with('success', 'Vehicle type deleted successfully.');
    })->name('admin.categories.vehicle-type.destroy');

    Route::get('/admin/categories/product', function () {
        abort_unless(Auth::user()?->name === 'TestAdmin', 403);

        $categoryProducts = CategoryProduct::latest()->paginate(10);

        return view('admin-category-product', ['categoryProducts' => $categoryProducts]);
    })->name('admin.categories.product');

    Route::post('/admin/categories/product', function (Request $request) {
        abort_unless(Auth::user()?->name === 'TestAdmin', 403);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:category_products,name'],
        ]);

        CategoryProduct::create($validated);

        return back()->with('success', 'Product category added successfully.');
    })->name('admin.categories.product.store');

    Route::get('/admin/categories/product/{categoryProduct}/edit', function (CategoryProduct $categoryProduct) {
        abort_unless(Auth::user()?->name === 'TestAdmin', 403);

        return view('admin-category-product-edit', ['categoryProduct' => $categoryProduct]);
    })->name('admin.categories.product.edit');

    Route::put('/admin/categories/product/{categoryProduct}', function (Request $request, CategoryProduct $categoryProduct) {
        abort_unless(Auth::user()?->name === 'TestAdmin', 403);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:category_products,name,'.$categoryProduct->id],
        ]);

        $categoryProduct->update($validated);

        return redirect()
            ->route('admin.categories.product')
            ->with('success', 'Product category updated successfully.');
    })->name('admin.categories.product.update');

    Route::delete('/admin/categories/product/{categoryProduct}', function (CategoryProduct $categoryProduct) {
        abort_unless(Auth::user()?->name === 'TestAdmin', 403);

        $categoryProduct->delete();

        return back()->with('success', 'Product category deleted successfully.');
    })->name('admin.categories.product.destroy');

    Route::get('/admin/products', function (Request $request) {
        abort_unless(Auth::user()?->name === 'TestAdmin', 403);

        $search = $request->string('search')->trim()->toString();

        $products = Prod::when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('item_code', 'like', "%{$search}%")
                        ->orWhere('search_keys', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin-products', [
            'products' => $products,
            'search' => $search,
        ]);
    })->name('admin.products');

    Route::get('/product-add', function () {
        abort_unless(Auth::user()?->name === 'TestAdmin', 403);

        return view('product-add', [
            'vehicleBrands' => VehicleBrand::orderBy('name')->get(),
            'vehicleTypes' => VehicleType::orderBy('name')->get(),
            'categoryProducts' => CategoryProduct::orderBy('name')->get(),
        ]);
    })->name('admin.products.add');

    Route::get('/product-add/{product}/edit', function (Prod $product) {
        abort_unless(Auth::user()?->name === 'TestAdmin', 403);

        return view('product-add', [
            'product' => $product,
            'vehicleBrands' => VehicleBrand::orderBy('name')->get(),
            'vehicleTypes' => VehicleType::orderBy('name')->get(),
            'categoryProducts' => CategoryProduct::orderBy('name')->get(),
        ]);
    })->name('admin.products.edit');

    Route::post('/product-add', function (Request $request) {
        abort_unless(Auth::user()?->name === 'TestAdmin', 403);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'item_code' => ['nullable', 'string', 'max:255'],
            'vehicle_brand_id' => ['required', 'exists:vehcle_brands,id'],
            'vehicle_type_id' => ['required', 'exists:vehicle_types,id'],
            'category_product_id' => ['required', 'exists:category_products,id'],
            'description' => ['nullable', 'string'],
            'search_keys' => ['nullable', 'string'],
            'image' => ['required', 'image', 'max:2048'],
        ]);

        $imageDirectory = public_path('img/products');

        if (! is_dir($imageDirectory)) {
            mkdir($imageDirectory, 0755, true);
        }

        $image = $request->file('image');
        $imageName = Str::slug(pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME))
            .'-'.Str::random(8)
            .'-'.now()->format('YmdHis')
            .'.'.$image->getClientOriginalExtension();

        $image->move($imageDirectory, $imageName);

        Prod::create([
            'name' => $validated['name'],
            'item_code' => $validated['item_code'] ?? null,
            'image_path' => 'img/products/'.$imageName,
            'description' => $validated['description'] ?? null,
            'search_keys' => $validated['search_keys'] ?? null,
            'vehicle_brand_id' => $validated['vehicle_brand_id'],
            'vehicle_type_id' => $validated['vehicle_type_id'],
            'category_product_id' => $validated['category_product_id'],
        ]);

        return redirect()->route('admin.products')->with('success', 'Product added successfully.');
    })->name('admin.products.store');

    Route::put('/product-add/{product}', function (Request $request, Prod $product) {
        abort_unless(Auth::user()?->name === 'TestAdmin', 403);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'item_code' => ['nullable', 'string', 'max:255'],
            'vehicle_brand_id' => ['required', 'exists:vehcle_brands,id'],
            'vehicle_type_id' => ['required', 'exists:vehicle_types,id'],
            'category_product_id' => ['required', 'exists:category_products,id'],
            'description' => ['nullable', 'string'],
            'search_keys' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'max:2048'],
        ]);

        $imagePath = $product->image_path;

        if ($request->hasFile('image')) {
            $imageDirectory = public_path('img/products');

            if (! is_dir($imageDirectory)) {
                mkdir($imageDirectory, 0755, true);
            }

            if ($product->image_path && file_exists(public_path($product->image_path))) {
                unlink(public_path($product->image_path));
            }

            $image = $request->file('image');
            $imageName = Str::slug(pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME))
                .'-'.Str::random(8)
                .'-'.now()->format('YmdHis')
                .'.'.$image->getClientOriginalExtension();

            $image->move($imageDirectory, $imageName);
            $imagePath = 'img/products/'.$imageName;
        }

        $product->update([
            'name' => $validated['name'],
            'item_code' => $validated['item_code'] ?? null,
            'image_path' => $imagePath,
            'description' => $validated['description'] ?? null,
            'search_keys' => $validated['search_keys'] ?? null,
            'vehicle_brand_id' => $validated['vehicle_brand_id'],
            'vehicle_type_id' => $validated['vehicle_type_id'],
            'category_product_id' => $validated['category_product_id'],
        ]);

        return redirect()->route('admin.products')->with('success', 'Product updated successfully.');
    })->name('admin.products.update');

    Route::delete('/admin/products/{product}', function (Prod $product) {
        abort_unless(Auth::user()?->name === 'TestAdmin', 403);

        if ($product->image_path && file_exists(public_path($product->image_path))) {
            unlink(public_path($product->image_path));
        }

        $product->delete();

        return back()->with('success', 'Product deleted successfully.');
    })->name('admin.products.destroy');
});

Route::post('/logout', function (Request $request) {
    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('login');
})->middleware('auth')->name('logout');
