<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Tenant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function logout()
    {
        Auth::logout();
        Session::flush();
        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

        return redirect('/login');
    }


    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        if ($user->tenants()->exists()) {
            $tenants = Tenant::select(
                'tenants.id',
                'people.name as name',
                'software.name as software',
                'software.id as software_id'
            )
            ->join('people', 'people.id', '=', 'tenants.person_id')
                ->join('software', 'software.tenant_id', '=', 'tenants.id')
                ->where('software.is_enabled', true)
                ->whereIn('tenants.id', $user->tenants)
                ->get(['id', 'name']);

            session(['tenants' => $tenants->toArray()]);
            session(['tenant' => $tenants[0]->toArray()]);
        }

        return redirect()->intended($this->redirectPath());
    }
}
