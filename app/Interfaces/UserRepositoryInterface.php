<?php

namespace App\Interfaces;

use Illuminate\Http\JsonResponse;

interface UserRepositoryInterface
{
    /**
     * Store User.
     * @param $data
     * @return object
     */
    public function create($data): object;

    /**
     * Login User.
     * @return array
     */
    public function login(): array;

    /**
     * Refresh a token.
     *
     * @return array
     */
    public function refresh(): array;

    /**
     * Log the user out (Invalidate the token).
     *
     * @return array
     */
    public function logout(): array;

    /**
     * Get the authenticated User.
     *
     * @return object
     */
    public function me(): object;

    /**
     * Get user List.
     *
     *
     * @return object
     */
    public function usersList():object;

}
