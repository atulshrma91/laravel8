<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;
    protected $table = 'accounts';
    protected $primaryKey = 'id';
    protected $fillable = [
          'user_id',
          'uuid',
          'name',
          'category_id',
          'image'
    ];

    public function Category(){
        return $this->hasOne('App\Models\Category','id', 'category_id');
    }
}
