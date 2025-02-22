<?php

namespace App\Http\Middleware;

use App\Models\Company;
use Illuminate\Http\Request;
use Inertia\Middleware;
use Tightenco\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): string|null
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {

        $sideMenus = [];
        $companyInfo = [];
        if (auth()->guard('admin')->check() && auth()->guard('admin')->user()->status == 'Active') {
            $sideMenus = (session()->has('sideMenus')) ? session()->get('sideMenus') : getSideMenus();
        }
        $sideMenus = (session()->has('sideMenus')) ? session()->get('sideMenus') : getSideMenus();

        $companyInfo = (session()->has('companyInfo')) ? session()->get('companyInfo') : Company::first();



        return array_merge(parent::share($request), [
            'ziggy' => function () use ($request) {
                return array_merge((new Ziggy)->toArray(), [
                    'location' => $request->url(),
                ]);
            },
            'flash' => [
                'successMessage' => $request->session()->get('successMessage'),
                'errorMessage' => $request->session()->get('errorMessage'),
            ],
            'auth' => [
                'admin' => fn () => auth('admin')->user(),
                'sideMenus' => $sideMenus,
            ],

            'companyInfo' => $companyInfo,
        ]);
    }
}
