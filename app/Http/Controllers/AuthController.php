<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUser;
use App\Http\Requests\LoginUser;
use App\Repositories\UserRepository;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Hash;
use JWTAuth;

class AuthController extends Controller
{
    use AuthenticatesUsers;
    protected $user;
    protected $maxAttempts = 5; // Amount of bad attempts user can make
    protected $decayMinutes = 30; // Time for which user is going to be blocked in minutes
    /**
     * Create a new AuthController instance.
     *
     * @param UserRepository $post
     */
    public function __construct(UserRepository $user)
    {
        $this->middleware('auth:api', ['except' => ['login' , 'register']]);
        $this->user = $user;
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginUser $request)
    {
        //check if user has reached the max number of login attempts
        if ($this->hasTooManyLoginAttempts($request)) 
        {
            $this->fireLockoutEvent($request);
            $seconds = $this->limiter()->availableIn($this->throttleKey($request));
            return self::createResponseFromData(422,[
                'message' => trans('auth.throttle', ['seconds' => $seconds,'minutes' => ceil($seconds / 60) ])
            ]);
        }
        //verify user credentials
        $credentials = $request->only('email', 'password');
        if (! $token = auth()->attempt($credentials)) {
            $this->incrementLoginAttempts($request);
            return self::createResponseFromData(401, [$this->username() => trans('auth.failed')]) ;
        }
        $this->clearLoginAttempts($request);
        return $this->respondWithToken($token);
    }
    public function register(RegisterUser $request)
    {
        $name = $this->uploadFile($request->file('image'));
        $newUser = $this->user->createUser([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
            'image' => $name,
            'DOB' => $request->get('DOB')
        ]);
        $token = JWTAuth::fromUser($newUser);
        return self::createResponseFromData(201 ,['user' => $newUser ,'token' => $token , 'message' => trans('auth.register')]);
    }

    public function uploadFile($file)
    {
        $name = time().$file->getClientOriginalExtension();
        $file->move(public_path().'/uploads/', $name);
        return $name;
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return self::createResponseFromData(200 , ['user' => auth()->user()]);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();
        return self::createResponseFromData(200 , ['message' => trans('auth.logout')]);
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
        return self::createResponseFromData(200 ,[
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
