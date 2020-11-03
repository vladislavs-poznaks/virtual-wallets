<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    public $incrementing = false;

    protected $fillable = ['id', 'user_id', 'wallet_id', 'partner_wallet_id', 'cents', 'fraudulent'];
    protected $keyType = 'string';

    public function getAmountAttribute(): string
    {
        return ($this->isIncoming() ? '+' : '-')
            . '$' . number_format(abs($this->cents) / 100, 2);
    }

//    public function setCentsAttribute(float $amount): void
//    {
//        $this->attributes['amount'] = (int) ($amount * 100);
//    }

    public function isIncoming(): bool
    {
        return $this->cents > 0;
    }

    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }

    public function partner()
    {
        return $this->belongsTo(Wallet::class, 'partner_wallet_id', 'id');
    }

    public function toggleFraud()
    {
        $this->update([
            'fraudulent' => $this->fraudulent ? null : Carbon::now()
        ]);
    }
}
