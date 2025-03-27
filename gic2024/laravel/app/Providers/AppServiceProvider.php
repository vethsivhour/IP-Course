<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Cart;
use App\Models\Customer;
use App\Models\Wishlist;
use App\Models\OrderProduct;
use App\Observers\ModelActivityObserver;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Order::observe(ModelActivityObserver::class);
        Payment::observe(ModelActivityObserver::class);
        Cart::observe(ModelActivityObserver::class);
        Customer::observe(ModelActivityObserver::class);
        Wishlist::observe(ModelActivityObserver::class);
        OrderProduct::observe(ModelActivityObserver::class);
    }
}
