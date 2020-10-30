<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class DifferentWallet implements Rule
{
    private $id;

    /**
     * Create a new rule instance.
     *
     * @param string $slug
     */
    public function __construct(string $slug)
    {
        $this->slug = $slug;
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
        return $this->slug != $value;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Recipient must differ from current wallet.';
    }
}
