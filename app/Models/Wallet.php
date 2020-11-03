<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Wallet extends Model
{
    use HasFactory, SoftDeletes;

    public $incrementing = false;

    protected $fillable = ['id', 'user_id', 'name', 'slug', 'cents'];
    protected $keyType = 'string';

    public function getFundsAttribute(): string
    {
        return '$' . number_format($this->cents / 100, 2);
    }

    public function getDebitAttribute(): string
    {
        $debit = $this->transactions->pluck('cents')->filter(function ($cents) {
            return $cents > 0;
        })->sum();

        return '+$' . number_format($debit / 100, 2);
    }

    public function getCreditAttribute(): string
    {
        $credit = $this->transactions->pluck('cents')->filter(function ($cents) {
            return $cents < 0;
        })->sum();

        $credit = abs($credit);

        return '-$' . number_format($credit / 100, 2);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class)->latest();
    }

    public function withdraw(int $cents, Wallet $partner)
    {
        if ($cents <= $this->cents) {
            $this->update([
                'cents' => $this->cents - $cents
            ]);

            Transaction::create([
                'id' => Str::uuid(),
                'user_id' => auth()->user()->id,
                'wallet_id' => $this->id,
                'partner_wallet_id' => $partner->id,
                'cents' => $cents * (-1)
            ]);
        }
    }

    public function deposit(int $cents, Wallet $partner)
    {
        $this->update([
            'cents' => $this->cents + $cents
        ]);

        Transaction::create([
            'id' => Str::uuid(),
            'user_id' => auth()->user()->id,
            'wallet_id' => $this->id,
            'partner_wallet_id' => $partner->id,
            'cents' => $cents
        ]);
    }
}
