<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

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
        if (!Auth::guard()->attempt($cred)) {
            return response([
                'message' => 'Unauthorized'
            ], 401);
        }
        return $this->sendLoginResponse($request);
    }

    protected function sendLoginResponse(Request $request): JsonResponse
    {

        return response()->json([
            'token' => $request->user()->createToken($request->input('device_name'))->accessToken,
            'user' => new UserResource($request->user()->load(['faculty', 'department'])),
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
}