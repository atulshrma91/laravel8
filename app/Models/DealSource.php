<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DealSource extends Model
{
    use HasFactory;

    protected $table = 'deal_sources';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'name'
    ];
}
