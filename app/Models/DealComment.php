<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DealComment extends Model
{
    use HasFactory;

    protected $table = 'deal_comments';
    protected $primaryKey = 'id';
    protected $fillable = [
        'deal_id',
        'deal_category_id',
        'comment',
        'date'
    ];

    public function Deal(){
        return $this->hasOne('App\Models\Deal','id', 'deal_id');
    }

    public function Category(){
        return $this->hasOne('App\Models\DealCategories','id', 'deal_category_id');
    }
}
