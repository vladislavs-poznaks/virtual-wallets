<?php

namespace Database\Factories;

use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TransactionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Transaction::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id' => Str::uuid(),
            'user_id' => self::factoryForModel(User::class),
            'from_wallet_id' => self::factoryForModel(Wallet::class),
            'to_wallet_id' => self::factoryForModel(Wallet::class),
            'cents' => rand(100, 500) * 100
        ];
    }
}
