<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\Product;
use App\Policies\ProductPolicy;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Gate::define('manage-product', function (User $user) {
            return $user->role === 'admin';
        });

        Gate::policy(Product::class, ProductPolicy::class);
    }
}