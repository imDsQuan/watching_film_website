<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterAuthRequest;
use App\Models\User;
use App\Repositories\PackRepository;
use App\Repositories\SubscriptionRepository;
use Google_Client;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class ApiController extends Controller
{
    public $loginAfterSignUp = true;

    protected $subscriptionRepo;
    protected $packRepo;

    public function __construct(SubscriptionRepository $subscriptionRepo, PackRepository $packRepo)
    {
        $this->middleware('auth:api', ['except' => ['login', 'register', 'loginWithGoogle', 'loginWithFacebook']]);
        $this->subscriptionRepo = $subscriptionRepo;
        $this->packRepo = $packRepo;
    }

    public function register(RegisterAuthRequest $request)
    {
        $user = new User();
        $user->full_name = $request->full_name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->phone = $request->phone;
        $user->image = 'https://graph.facebook.com/v3.3/3304255366453703/picture?type=normal';
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
                'message' => 'Invalid Username or Password',
            ], Response::HTTP_UNAUTHORIZED);
        }

        return $this->createNewToken($jwt_token);
    }

    public function logout(Request $request)
    {
//        $this->validate($request, [
//            'token' => 'required'
//        ]);

        auth()->logout();

        return response()->json([
            'success' => true,
            'message' => 'User logged out successfully'
        ]);
    }

    public function getAuthUser()
    {
        return response()->json(auth()->user());
    }

    protected function createNewToken($token)
    {
        $user = auth()->user();
        $user->subscription = $this->subscriptionRepo->getLastSubByUserId($user->id);
        if ($user->subscription != null) $user->pack = $this->packRepo->find($user->subscription->pack_id);
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'user' => $user,
        ]);
    }

    public function loginWithGoogle(Request $request)
    {

        $client = new Google_Client();  // Specify the CLIENT_ID of the app that accesses the backend
        $payload = $client->verifyIdToken($request->token);

        if ($payload) {
            $userid = (int) $payload['sub'];
            $user_login = User::where('email', $payload['email'])->first();
            if ($user_login == null) {
                $user_login = User::create([
                    'full_name' => $payload['name'],
                    'email' => $payload['email'],
                    'username' => $payload['email'],
                    'password' => bcrypt($payload['email']),
                    'image' => $payload['picture'],
                ]);
            }
            $input = $request->only('username', 'password');
            if (!$jwt_token = auth()->attempt(['username' => $user_login->username, 'password' => $user_login->username])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid Username or Password',
                ], Response::HTTP_UNAUTHORIZED);
            }

            return $this->createNewToken($jwt_token);

        } else {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Username or Password',
            ], Response::HTTP_UNAUTHORIZED);
        }
    }

    public function loginWithFacebook(Request $request)
    {
        $user = Socialite::driver('facebook')->userFromToken($request->token);
        $user_login = User::where('email', $user->id.'@facebook.com')->first();
        if ($user_login == null) {
            $user_login = User::create([
                'full_name' => $user->name,
                'email' => $user->id . '@facebook.com',
                'username' => $user->id,
                'password' => bcrypt($user->id),
                'image' => $user->avatar,
            ]);
        }
        $input = $request->only('username', 'password');
        if (!$jwt_token = auth()->attempt(['username' => $user_login->username, 'password' => $user_login->username])) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Username or Password',
            ], Response::HTTP_UNAUTHORIZED);
        }

        return $this->createNewToken($jwt_token);


    }


}
