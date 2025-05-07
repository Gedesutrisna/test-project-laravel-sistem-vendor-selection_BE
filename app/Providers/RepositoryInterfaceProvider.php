<?php

namespace App\Providers;

use App\Interfaces\AuthInterface;
use App\Interfaces\ItemInterface;
use App\Interfaces\OrderInterface;
use App\Interfaces\VendorInterface;
use App\Repositories\AuthRepository;
use App\Repositories\ItemRepository;
use Illuminate\Support\Facades\Auth;
use App\Repositories\OrderRepository;
use App\Repositories\VendorRepository;
use App\Interfaces\VendorItemInterface;
use Illuminate\Support\ServiceProvider;
use App\Repositories\VendorItemRepository;

class RepositoryInterfaceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(VendorInterface::class, VendorRepository::class);
        $this->app->bind(AuthInterface::class, AuthRepository::class);
        $this->app->bind(ItemInterface::class, ItemRepository::class);
        $this->app->bind(VendorItemInterface::class, VendorItemRepository::class);
        $this->app->bind(OrderInterface::class, OrderRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
