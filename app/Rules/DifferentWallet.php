<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class DifferentWallet implements Rule
{
    private $id;

    /**
     * Create a new rule instance.
     *
     * @param $id
     */
    public function __construct($id)
    {
        $this->id = $id;
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
        return $this->id != $value;
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
