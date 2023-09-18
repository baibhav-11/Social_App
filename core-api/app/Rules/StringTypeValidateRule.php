<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class StringTypeValidateRule implements Rule
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
        $isString = false;
        if (preg_match('/^[\p{L} ]+$/u', $value))
        {
            $isString = true;
        }else{
            $isString = false;
        }
        return $isString;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Only letters allowded.';
    }
}
