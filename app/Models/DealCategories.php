<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DealCategories extends Model
{
    use HasFactory;

    protected $table = 'deal_categories';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'name',
        'color_code'
    ];
}
