<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory, Formattable;

    protected $guarded = [];

    public function fromWallet()
    {
        return $this->belongsTo(Wallet::class, 'from_wallet_id', 'id');
    }

    public function toWallet()
    {
        return $this->belongsTo(Wallet::class, 'to_wallet_id', 'id');
    }

    public function toggleFraud()
    {
        $this->update([
            'fraudulent' => ($this->fraudulent ? 0 : 1),
        ]);
    }
}
