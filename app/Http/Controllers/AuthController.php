<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Repositories\UserRepository\UserRepositoryInterface;


class AuthController extends Controller
{
     /**
     * Create a new AuthController instance.
     *
     * @return void
     */

    protected $user_repo;
    public function __construct( UserRepositoryInterface $user_repo)
    {       
        $this->user_repo = $user_repo;
        $this->middleware('auth:api', ['except' => ['login','register']]);
    }

    public function register(){

        $validator =  Validator()->make(request()->all(),
            [
                'name' => 'string|required',
                'email' => 'required|email',
                'password' => 'string|required|min:6',
                'password_confirmation' => 'required '
            ]
        );

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $newUser = [
            'name' => request()->get('name'),
            'email' => request()->get('email'),
            'password' => bcrypt(request()->get('password'))
        ];

        $User =$this->user_repo->create($newUser);
        
        // User::create($newUser);
        return response()->json(
            [
                'message' => ' successfully registered',
                'user' => $User
            ]
        );

    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {   
        $credentials = request(['email', 'password']);
        if (! $token = JWTAuth::attempt($credentials)) {
            dd( $token);
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => config('jwt.ttl')
        ]);
    }
}
