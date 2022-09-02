<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;
    protected $table = 'contacts';
    protected $primaryKey = 'id';
    protected $fillable = [
          'uuid',
          'user_id',
          'account_id',
          'role',
          'first_name',
          'last_name',
          'email',
          'telephone',
          'website',
          'company',
          'cvr_number',
          'address',
          'company_telephone',
          'company_email',
          'profile_image',
          'logo',
    ];

    public function Account(){
        return $this->hasOne('App\Models\Account','id', 'account_id');
    }

    public function FormSubmission(){
        return $this->hasOne('App\Models\FormSubmission','contact_id', 'id');
    }
}
