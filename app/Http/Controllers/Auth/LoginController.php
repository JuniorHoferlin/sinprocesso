<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

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
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('sessao.login');
    }

    /**
     * Get the failed login response instance.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        flash('Login ou senha incorretos. Por favor, tente novamente.', 'danger');

        return redirect()->back()->withInput($request->only($this->username(), 'remember'));
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'login';
    }

    /**
     * Depois de logar, verifica se o usuário está inativo, se estiver, não permite continuar.
     *
     * @param Request $request
     * @param $user
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function authenticated(Request $request, $user)
    {
        if ($user->status == 'Ativo') {
            return redirect()->intended($this->redirectPath());
        } else {
            auth()->logout();
            flash('Não foi possível realizar o login, o usuário está desativado no sistema.', 'warning');

            return redirect()->route('login');
        }
    }

}
