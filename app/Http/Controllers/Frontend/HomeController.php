<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

use Inertia\Inertia;
use Exception;

class HomeController extends Controller
{

    public function __construct()
    {
      
    }

    public function index()
    {

        return Inertia::render('Frontend/Home');
    }
}
