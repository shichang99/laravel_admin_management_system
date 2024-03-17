<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

use App\Models\{
    User
};

class CheckInvitationCodeRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if ( !User::where( 'status', 1 )->where( 'invitation_code', $value )->first() ) {
            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __( 'validation.not_exist' );
    }
}
