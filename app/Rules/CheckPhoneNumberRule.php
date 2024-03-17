<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

use App\Models\{
    User,
    MemberDetail,
};

class CheckPhoneNumberRule implements Rule
{
    public $country, $user;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct( $country, $user = null )
    {
        $this->country = $country;
        $this->user = $user;
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
        $memberDetail = MemberDetail::where( 'phone_number', $value )->first();
        if ( $memberDetail ) {
            $user = User::find( $memberDetail->user_id );
            if ( $user ) {
                if ( $this->user ) {
                    if ( $user->country = $this->country && $user->id != $this->user ) {
                        return false;
                    }
                } else {
                    if ( $user->country = $this->country ) {
                        return false;        
                    }
                }
            }
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
        return __( 'validation.unique' );
    }
}
