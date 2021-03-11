<?php

namespace App\Http\Controllers;

use App\Http\Requests\SignupRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    //
    /**
     * Realiza el inicio de sesión de un usuario.
     * @param Request $request
     * @return Response
     */
    public function login(Request $request): Response
    {
        if (Auth::attempt($request->only('email', 'password')))
        {
            $authenticated_user = Auth::user();
            $user = User::find($authenticated_user->id);
            $token = $user->createToken('admin')->accessToken;
            return response(['token' => $token], Response::HTTP_CREATED);
        }
        return response(['error' => 'Invalid credentials'], Response::HTTP_UNAUTHORIZED);
    }

    /**
     * Realiza el registro de un usuario.
     * @param Request $request
     * @return Response
     */
    public function register(SignupRequest $request): Response
    {
        $body = $request->only('first_name','last_name', 'email', 'password');
        $body['password'] = Hash::make($body['password']);
        $user = User::create($body);

        return response($user, Response::HTTP_CREATED);
    }

    public function user(): Response
    {
        return response(Auth::user(), Response::HTTP_OK);
    }

    public function updateInfo(Request $request): Response
    {
        $authenticated_user = Auth::user();
        $user = User::find($authenticated_user->id);
        $user->update($request->only('first_name', 'last_name', 'email'));
        return response($user, Response::HTTP_ACCEPTED);
    }

    public function updatePassword(Request $request): Response
    {

    }
}
