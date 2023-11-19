<?php

namespace App\Rules;

use App\Models\User;
use Illuminate\Contracts\Validation\Rule;
use function PHPUnit\Framework\isNull;

class isAdminRule implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $user = User::find($value);
        if(isNull($user)){
            return false;
        }
        elseif (in_array('customer', $user->getRoleNames()->toArray())) {
            return true;
        }
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Transaction against This User cannot created.';
    }
}
