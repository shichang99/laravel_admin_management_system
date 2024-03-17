<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

use App\Models\{
    MemberWallet,
};

class CheckWalletBalanceRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */

    private $type;

    public function __construct( $type )
    {
        $this->type = $type;
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
        $currentBalance = MemberWallet::where( 'user_id', auth()->user()->id )
            ->where( 'type', $this->type )
            ->lockForUpdate()
            ->first();

        if ( !$currentBalance ) {
            return false;
        }

        if ( $currentBalance->balance < $value ) {
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
        return 'Not enough wallet balance.';
    }
}
