<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory, Formattable;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function debitTransactions()
    {
        return $this->hasMany(Transaction::class, 'to_wallet_id', 'id');
    }

    public function creditTransactions()
    {
        return $this->hasMany(Transaction::class, 'from_wallet_id', 'id');
    }

    public function transactions()
    {
        return ($this->debitTransactions->merge($this->creditTransactions))->sortByDesc('created_at');
    }

    public function withdraw(int $cents)
    {
        if ($cents <= $this->cents) {
            $this->cents -= $cents;
            $this->save();
        }
    }

    public function deposit(int $cents)
    {
        $this->cents += $cents;
        $this->save();
    }
}
