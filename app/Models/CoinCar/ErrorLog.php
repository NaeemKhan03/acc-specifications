<?php

namespace App\Models\CoinCar;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ErrorLog extends Model
{
    use HasFactory;
    protected $connection = 'coincars';
    protected $fillable = [
        'error',
        'status'
    ];
}
