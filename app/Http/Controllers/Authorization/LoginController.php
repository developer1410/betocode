<?php

declare(strict_types=1);

namespace App\Http\Controllers\Authorization;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Authorization\RequestLogin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class LoginController extends ApiController
{
    protected $client;

    /**
     * LoginController constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        parent::__construct($request);

        $this->client = DB::table('oauth_clients')
                          ->where(['password_client' => 1])
                          ->first();
    }

    /**
     * Login user and return access + refresh tokens
     * @param RequestLogin $request
     * @return mixed
     */
    public function login(RequestLogin $request)
    {
        request()->request->add([
            'username' => $request->get('email'),
            'password' => $request->get('password'),
            'grant_type' => 'password',
            'client_id' => $this->client->id,
            'client_secret' => $this->client->secret,
        ]);

        $proxy = Request::create('oauth/token', 'POST');

        return Route::dispatch($proxy);
    }

    /**
     * Logout user
     */
    public function logout()
    {
        Auth::user()
            ->tokens()
            ->delete();
    }
}
