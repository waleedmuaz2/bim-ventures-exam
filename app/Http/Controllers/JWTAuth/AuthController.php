<?php

namespace App\Http\Controllers\JWTAuth;

use App\Http\Requests\SignUserRequest;
use App\Interfaces\UserRepositoryInterface;
use Illuminate\Auth\Authenticatable;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    private $userRepository;
    use Authenticatable;

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return JsonResponse
     */
    public function login(): JsonResponse
    {
         $result = $this->userRepository->login();
         return jsonFormat($result['data'],$result['message'],$result['statusCode']);
    }

    /**
     * Get the authenticated User.
     *
     * @return JsonResponse
     */
    public function me(): JsonResponse
    {
        $result =  $this->userRepository->me();
        return jsonFormat($result,"Success",200);

    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        $result =  $this->userRepository->logout();
        return jsonFormat("",$result['message'],200);

    }

    /**
     * Refresh a token.
     *
     * @return JsonResponse
     */
    public function refresh(): JsonResponse
    {
        $result= $this->userRepository->refresh();
        return jsonFormat($result['data'],$result['message'],$result['statusCode']);
    }

    /**
     * register User.
     *
     * @param SignUserRequest $request
     * @return JsonResponse
     */
    public function signup(SignUserRequest $request): JsonResponse
    {
        $user = $this->userRepository->create($request);
        return jsonFormat($user, 'Success', 200);
    }
}
