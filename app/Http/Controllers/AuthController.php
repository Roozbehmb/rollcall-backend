<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use ImanRjb\JwtAuth\Services\AccessToken\AccessToken;
use ImanRjb\JwtAuth\Services\AccessToken\AccessTokenService;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{

    public function __construct()
    {
//        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function login(Request $request)
    {
        try {
            $request->validate([
                'refresh-token' => 'nullable',
                'email' => 'required_without:refresh-token|string|email',
                'password' => 'required_without:refresh-token|string',
            ]);

            $credentials = $request->only('email', 'password');
            $refreshToken = $request->get('refresh-token');
            $userAgent = $request->server('HTTP_USER_AGENT');
            if ($request->only('refresh-token')) {
                $token = AccessToken::createFromRefreshToken($refreshToken, $userAgent, $request->ip());
            } else {
                $token = null;
                $Email = $request->only('email');
                $user = User::where(['email' => $Email])->first();
                $password = $request->get('password');

                if (Hash::check($password, $user->password)) {
                    $token = AccessToken::create($user, $userAgent, $request->ip());
                }

            }
            return response()->json([
                'status' => 'success',
                'authorisation' => [
                    'token' => $token,
                    'type' => 'bearer',
                ]
            ]);
        } catch (\Exception $exception) {
            return response()->json(['Message' => $exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR]);
        }

    }

    public function register(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $userAgent = $request->header('User-Agent');
        $token = AccessToken::create($user, $userAgent, $request->ip());

        return response()->json([
            'status' => 'success',
            'message' => 'User created successfully',
            'user' => $user,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ]);
    }

    public function refresh()
    {
        return response()->json([
            'status' => 'success',
            'user' => Auth::user(),
            'authorisation' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ]);
    }

}
