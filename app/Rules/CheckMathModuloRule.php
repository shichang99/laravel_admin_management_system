<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CheckMathModuloRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($amount)
    {
        $this->amount = $amount;
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
        if ( $value % $this->amount !=0 ) {
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
        return ['message' =>  __('member.error_amount_modules',['value' => $this->amount])];
    }
}
