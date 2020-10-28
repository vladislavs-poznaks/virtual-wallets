<?php


namespace App\Models;


trait Formattable
{
    public function formattedFunds()
    {
        return '$' . number_format($this->cents / 100, 2);
    }
}
