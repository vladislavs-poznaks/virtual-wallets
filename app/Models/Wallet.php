<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory, Formattable;

    public $incrementing = false;

    protected $fillable = ['user_id', 'name', 'slug', 'cents'];

    protected $primaryKey = 'slug';
    protected $keyType = 'string';

    public function getRouteKey()
    {
        return $this->slug;
    }

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
            $this->update([
                'cents' => $this->cents - $cents
            ]);
        }
    }

    public function deposit(int $cents)
    {
        $this->update([
            'cents' => $this->cents + $cents
        ]);
    }
}
