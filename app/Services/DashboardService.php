<?php

namespace App\Services;

use App\Models\Admin;

class DashboardService
{
    protected $adminModel;

    public function __construct(Admin $adminModel)
    {
        $this->adminModel = $adminModel;
    }

    public function countActiveUser()
    {
        return $this->adminModel->whereNull('deleted_at')
        ->where('status','Active')->count();
    }
    public function countInActiveUser()
    {
        return $this->adminModel->whereNull('deleted_at')
        ->where('status','Active')->count();
    }
}