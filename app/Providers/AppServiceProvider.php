<?php

namespace App\Providers;

use App\Models\Company;
use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //$viewShare = [];
        //if (auth()->guard('admin')->check() && auth()->guard('admin')->user()->status == 'Active') {
        //    $sideMenus = (session()->has('sideMenus')) ? session()->get('sideMenus') : getSideMenus();
        //    $viewShare['sideMenus'] = $sideMenus;
        //}
        //$sideMenus = (session()->has('sideMenus')) ? session()->get('sideMenus') : getSideMenus();
        //$viewShare['sideMenus'] = $sideMenus;
        //$companyInfo = (session()->has('companyInfo')) ? session()->get('companyInfo') : Company::first();
        //$viewShare['companyInfo'] = $companyInfo;

        //Inertia::share($viewShare);

    }
}
