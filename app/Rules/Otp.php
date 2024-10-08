<?php

namespace PacketPrep\Rules;

use Illuminate\Contracts\Validation\Rule;

class Otp implements Rule
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
        $code = intval(request()->session()->get('code'));
        if($code !=$value)
            return False;
        else
            return True;

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Invalid code';
    }
}
