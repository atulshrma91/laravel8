<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTransaction extends Model
{
    use HasFactory;
    protected $table = 'user_transactions';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_extension_id',
        'order_id',
        'gateway_id',
        'type',
        'amount',
        'currency',
        'accepted'
    ];
}
