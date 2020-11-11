<?php

namespace App\Http\Requests;

use App\Models\Wallet;
use App\Rules\MinimumAmount;
use App\Rules\RecipientWalletIsDifferent;
use App\Rules\SenderHasSufficientFunds;
use Illuminate\Foundation\Http\FormRequest;

class TransactionStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'partner' => ['required', 'exists:wallets,id', new RecipientWalletIsDifferent($this->wallet->id)],
            'amount' => ['required', new MinimumAmount(), new SenderHasSufficientFunds($this->wallet->cents)]
        ];
    }
}
