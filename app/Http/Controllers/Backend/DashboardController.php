<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Services\DashboardService;
use Inertia\Inertia;
use Exception;

class DashboardController extends Controller
{
    protected $dashboardService, $viewAreaService;


    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    public function index()
    {
        $dashboardData['inActiveUsers'] = $this->dashboardService->countInActiveUser();
        $dashboardData['activeUsers'] = $this->dashboardService->countActiveUser();

        $data = [
            'pageTitle' => 'Dashboard',
            'breadcrumbs' => [
                ['link' => route('backend.dashboard'), 'title' => 'Dashboard'],
            ],
            'dashboardData' => fn() => $dashboardData,
        ];

        return Inertia::render('Backend/Dashboard', $data);
    }
}
