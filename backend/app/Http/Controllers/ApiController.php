<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterAuthRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\JWTException;
use JWTAuth;

class ApiController extends Controller
{
    public $loginAfterSignUp = true;

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login.blade.php', 'register']]);
    }

    public function register(RegisterAuthRequest $request)
    {
        $user = new User();
        $user->full_name=$request->full_name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        if ($this->loginAfterSignUp) {
            return $this->login($request);
        }

        return response()->json([
            'success' => true,
            'data' => $user
        ], Response::HTTP_OK);
    }
    public function login(Request $request)
    {
        $input = $request->only('username', 'password');

        if (!$jwt_token = auth()->attempt($input)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Email or Password',
            ], Response::HTTP_UNAUTHORIZED);
        }

        return $this->createNewToken($jwt_token);
    }

    public function logout(Request $request)
    {
//        $this->validate($request, [
//            'token' => 'required'
//        ]);

        try {
            auth()->logout();

            return response()->json([
                'success' => true,
                'message' => 'User logged out successfully'
            ]);
        } catch (JWTException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, the user cannot be logged out'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getAuthUser(Request $request)
    {
//        $this->validate($request, [
//            'token' => 'required'
//        ]);

        $user = auth()->user();

        return response()->json(['user' => $user]);
    }

    protected function createNewToken($token){
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'user' => auth()->user()
        ]);
    }
}
