<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\Api\UserInfoResource;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpKernel\Exception\HttpException;

class AuthController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $email = $request->get('email');
        $password = $request->get('password');

        try {
            $user = User::where('email', $email)->first();

            if (!$user) {
                throw new HttpException(400, 'Wrong credentials');
            }

            if (!Hash::check($password, $user->password)) {
                throw new HttpException(400, 'Wrong credentials');
            }

            return response()->json([
                'user' => new UserInfoResource($user),
                'token' => $user->createToken('api_token')->plainTextToken
            ]);
        } catch (HttpException $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], $e->getStatusCode());
        }
    }

    public function register(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|unique:users,email',
            'firstName' => 'required',
            'lastName' => 'required',
            'password' => 'required|confirmed'
        ]);

        $user = User::create([
            'email' => $request->get('email'),
            'first_name' => $request->get('firstName'),
            'last_name' => $request->get('lastName'),
            'password' => bcrypt($request->get('password'))
        ]);

        return response()->json([
            'user' => new UserInfoResource($user),
            'token' => $user->createToken('api_token')->plainTextToken
        ]);
    }

    public function me() {
        return response()->json([
            'user' => new UserInfoResource(auth('sanctum')->user())
        ]);
    }
}
