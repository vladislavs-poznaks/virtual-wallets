<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class WalletAmountIsValid implements Rule
{
    /**
     * @var int
     */
    private $min;
    /**
     * @var int
     */
    private $max;

    /**
     * Create a new rule instance.
     *
     * @param int $min
     * @param int $max
     */
    public function __construct(int $min = 100, int $max = 500)
    {
        $this->min = $min;
        $this->max = $max;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return $value >= $this->min && $value <= $this->max;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute must be between ' . $this->min . ' and ' . $this->max . '.';
    }
}
