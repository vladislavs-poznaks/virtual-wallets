<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class MinimumAmount implements Rule
{
    private int $min = 100;

    /**
     * Create a new rule instance.
     *
     * @param int $min
     */
    public function __construct(int $min = 100)
    {
        $this->min = $min;
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
        return $value * 100 >= $this->min;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute must be larger than ' . $this->min / 100 . '.';
    }
}
