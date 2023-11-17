<?php

namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Env;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Spatie\Permission\Models\Role;

class UserRepository implements UserRepositoryInterface
{
    /**
     * Store User.
     * @param $data
     * @return object
     */

    public function create($data): object
    {
        try {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);
            if ($data['role'] == "admin") {
                $user->assignRole('admin');
                $user->givePermissionTo('view_transaction');
                $user->givePermissionTo('create_transaction');
                $user->givePermissionTo('edit_transaction');
            } else {
                $user->assignRole('customer');
                $user->givePermissionTo('view_transaction');
            }
            return $user;
        } catch (\Exception $e) {
            abort(response()->json(
                $e->getMessage()));
        }
    }

    /**
     * Login User.
     * @return array
     */
    public function login(): array
    {
        try{
            $credentials = request(['email', 'password']);
            if (!$token = auth('api')->attempt($credentials)) {
                return [
                    "message"=>"Unauthorized",
                    "statusCode"=>"401",
                    "data"=>[]
                ];
            }
            return $this->respondWithToken($token);
        } catch (\Exception $e) {
            abort(response()->json(
                $e->getMessage()));
        }

    }

    /**
     * Refresh a token.
     *
     * @return array
     */
    public function refresh(): array
    {
        try {
            $token = auth('api')->refresh();
            return $this->respondWithToken($token);
        } catch (\Exception $e) {
            abort(response()->json(
                $e->getMessage()));
        }

    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return array
     */
    public function logout(): array
    {
        try {
            auth('api')->logout();
            return [
                'message'=>'success logout',
            ];
        } catch (\Exception $e) {
            abort(response()->json(
                $e->getMessage()));
        }
    }

    /**
     * Get the authenticated User.
     *
     * @return object
     */
    public function me(): object
    {
        try{
            return auth('api')->user();
        } catch (\Exception $e) {
            abort(response()->json(
                $e->getMessage()));
        }
    }

    /**
     * Get the token array structure.
     *
     * @param $token
     *
     * @return array
     */
    protected function respondWithToken($token): array
    {
        try {
            return [
                "data"=>[
                    'access_token' => "bearer " . $token,
                    'expires_in' => auth('api')->factory()->getTTL() * 60,
                ],
                'message'=>"success",
                "statusCode"=>200,
            ];
        } catch (\Exception $e) {
            abort(response()->json(
                $e->getMessage()));
        }

    }

    /**
     * Get user List.
     *
     *
     * @return object
     */
    public function usersList(): object
    {
        try {
            $users = Role::where('name', 'customer')->first();
            return $users->users;
        }catch (\Exception $e) {
            abort(response()->json(
                $e->getMessage()));
        }
    }
}
