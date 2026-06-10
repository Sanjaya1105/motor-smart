<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'username' => ['required', 'string'],
        'password' => ['required', 'string'],
    ]);

    if (Auth::attempt(['name' => $credentials['username'], 'password' => $credentials['password']])) {
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

    Route::get('/product', function () {
        return view('product');
    })->name('product');

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
            'username' => ['required', 'string', 'max:255', 'not_in:TestAdmin', 'unique:users,name'],
            'password' => ['required', 'string'],
        ]);

        User::create([
            'name' => $validated['username'],
            'merchant_name' => $validated['merchant_name'] ?? null,
            'phone_number' => $validated['phone_number'] ?? null,
            'address' => $validated['address'] ?? null,
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
            'username' => ['required', 'string', 'max:255', 'not_in:TestAdmin', 'unique:users,name,'.$user->id],
            'password' => ['nullable', 'string'],
        ]);

        $user->name = $validated['username'];
        $user->merchant_name = $validated['merchant_name'] ?? null;
        $user->phone_number = $validated['phone_number'] ?? null;
        $user->address = $validated['address'] ?? null;

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

    Route::get('/admin/products', function () {
        abort_unless(Auth::user()?->name === 'TestAdmin', 403);

        return view('admin-products');
    })->name('admin.products');
});

Route::post('/logout', function (Request $request) {
    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('login');
})->middleware('auth')->name('logout');
