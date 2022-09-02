<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormSubmission extends Model
{
    use HasFactory;

    protected $table = 'form_submissions';
    protected $primaryKey = 'id';
    protected $fillable = [
        'form_id',
        'contact_id',
        'customized_fields_data',
        'status'
    ];

    public function Contact(){
        return $this->hasOne('App\Models\Contact','id', 'contact_id');
    }
    public function Form(){
        return $this->hasOne('App\Models\Form','id', 'form_id');
    }
}
