<?php

namespace App\Models\CoinCar;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailLog extends Model
{
    use HasFactory;
    protected $connection = 'coincars';
    protected $fillable = [
        'email',
        'sent',
        'opened',
        'content',
        'type',
        'user_id',
    ];
}
