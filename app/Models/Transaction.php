<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory, Formattable;

    public $incrementing = false;

    protected $fillable = ['id', 'user_id', 'from_wallet_id', 'to_wallet_id', 'cents', 'fraudulent'];
    protected $keyType = 'string';

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
