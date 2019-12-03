<?php

namespace App\Providers;

use App\Http\ViewComposers\MenuComposer;
use Illuminate\Support\ServiceProvider;
use View;

class ViewComposerServiceProvider extends ServiceProvider
{

    public function boot()
    {
        View::composer('partials.menu', MenuComposer::class);
    }
}