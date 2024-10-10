<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Helpers\FileHelper;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\Middleware\JwtCustomResponse;

class AuthController extends Controller
{
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 401);
        }

        $refreshToken = $this->createRefreshToken();

        return $this->respondWithToken($token, $refreshToken);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'avatar_path' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'password' => 'required|string|min:6',
            'password_confirmation' => 'required|string|min:6|same:password',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $avatarPath = null;
        if ($request->hasFile('avatar_path')) {
            $fileInfo = FileHelper::uploadFile($request->avatar_path, 'users/avatar');
            if (!is_null($fileInfo)) {
                $avatarPath = $fileInfo['path'];
            }
        }

        $credentials = [
            'name' => $request->name,
            'email' => $request->email,
            'avatar_path' => $avatarPath,
            'password' => bcrypt($request->password),
        ];
        $user = User::create($credentials);

        auth()->attempt([
            'email' => $request->email,
            'password' => $request->password
        ]);

        $token = JWTAuth::fromUser($user);

        $refreshToken = $this->createRefreshToken();

        return $this->respondWithToken($token, $refreshToken);
    }

    public function me()
    {
        try {
            return response()->json(auth()->user());
        } catch (JWTException $exception) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 401);
        }
    }

    public function refresh(Request $request)
    {
        try {
            $refreshToken = $request->refresh_token;
            $decode = JWTAuth::getJWTProvider()->decode($refreshToken);
            $user = User::find($decode['user_id']);

            if (!$user) {
                return response()->json(['status' => 'error', 'message' => 'User not found'], 404);
            }

            auth()->invalidate();

            $token = JWTAuth::fromUser($user);

            $refreshToken = $this->createRefreshToken();

            return $this->respondWithToken($token, $refreshToken);
        } catch (JWTException $exception) {
            return response()->json(['status' => 'error', 'message' => 'Refresh token is invalid'], 500);
        }
    }

    public function logout()
    {
        auth()->logout();

        return response()->json(['status' => 'success', 'message' => 'Successfully logged out']);
    }

    private function respondWithToken($token, $refreshToken = null)
    {
        return response()->json([
            'status' => 'success',
            'access_token' => $token,
            'refresh_token' => $refreshToken,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    private function createRefreshToken()
    {
        $data = [
            'user_id' => auth()->user()->id,
            'random' => rand() . time(),
            'exp' => time() + config('jwt.refresh_ttl')
        ];

        return JWTAuth::getJWTProvider()->encode($data);
    }
}
