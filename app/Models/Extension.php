<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Extension extends Model
{
    use HasFactory;
    protected $table = 'extensions';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'slug',
        'price'
    ];

    public function UserExtension(){
        return $this->hasOne('App\Models\UserExtension','extension_id', 'id');
    }
}
