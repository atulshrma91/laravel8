<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserExtension extends Model
{
    use HasFactory;
    protected $table = 'user_extensions';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'extension_id',
        'extension_payment_id',
        'on_trial',
        'trial_expiry_days',
        'extension_expiry',
        'is_expired',
        'status',
    ];

    public function Extension(){
        return $this->hasOne('App\Models\Extension','id', 'extension_id');
    }
    public function User(){
        return $this->hasOne('App\Models\User','id', 'user_id');
    }
}
