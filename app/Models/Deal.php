<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deal extends Model
{
    use HasFactory;

    protected $table = 'deals';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'name',
        'account_id',
        'contact_id',
        'status',
        'date_won',
        'date_lost'
    ];

    public function Contact(){
        return $this->hasOne('App\Models\Contact','id', 'contact_id');
    }

    public function lastComment(){
        return $this->hasOne(DealComment::class)->orderBy('id', 'DESC');
    }
}
