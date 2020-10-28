<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class SufficientFunds implements Rule
{
    /**
     * @var int
     */
    private $funds;

    /**
     * Create a new rule instance.
     *
     * @param int $funds
     */
    public function __construct(int $funds)
    {
        $this->funds = $funds;
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
        return $this->funds >= $value * 100;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Insufficient funds.';
    }
}
