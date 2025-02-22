<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\AdminService;
use App\Traits\SystemTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class LoginController extends Controller
{
    use SystemTrait;

    protected $AdminService;
    public function __construct(AdminService $AdminService)
    {
        $this->AdminService = $AdminService;
    }
    public function login(LoginRequest $request)
    {
        $request->validated();

        $userInfo =  $this->AdminService->AdminExists(request()->email);

        if (!empty($userInfo)) {
            if ($userInfo->status != "Active") {
                return Inertia::render('Login')->with('errorMessage', 'Your Account Temporary Blocked. Please Contact Administrator.');
            }

            if (Hash::check(request()->password, $userInfo->password)) {
                Auth::guard('admin')->login($userInfo);

                // session()->flash('message', 'Logged In Successfully');
                return redirect()->route('backend.dashboard')->with('successMessage', 'Logged In Successfully');
                // return Inertia::render('Backend/Dashboard')->with('warningMessage', 'Logged In Successfully');
            } else {
                return Inertia::render('Login')->with('warningMessage', 'Wrong Password. Please Enter Valid Password.');
            }
        } else {
            return Inertia::render('Login')->with('warningMessage', 'Invalid Username. Please Enter Valid Username.');
        }
    }
    function loginPage()
    {
        return Inertia::render('Login');
    }

    function logout()
    {

        auth('admin')->logout();

        session()->flush('message', "Successfully Logged Out.");

        return redirect()->route('login');
    }
}
