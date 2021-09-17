<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->only('logout');
    }

    public function login(Request $request)
    {
        $cred = $request->validate([
            'Username' => 'required|string',
            'Password' => 'required|string'
        ]);
        $user = $this->attempt($cred);
        if (!$user) {
            return response([
                'message' => 'Unauthorized'
            ], 401);
        }
        return $this->sendLoginResponse($request, $user);
    }

    protected function sendLoginResponse(Request $request, User $user): JsonResponse
    {

        return response()->json([
            'token' => $user->createToken($request->input('device_name'))->accessToken,
            'user' => new UserResource($user->load(['faculty', 'department'])),
        ]);
    }

    /**
     * Log the user out of the application.
     *
     * @param Request $request
     * @return Application|ResponseFactory|Response
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response('', 204);
    }

    /**
     * @param array $creds
     * @return User|false
     */
    public function attempt(array $creds)
    {
        /** @var User $user */
        $user = User::query()->where('Username', '=', $creds['Username'])->first();
        if (!$user) {
            return false;
        }

        if (!Hash::check($creds['Password'], $user->Password)) {
            return false;
        }

        return $user;
    }
}
