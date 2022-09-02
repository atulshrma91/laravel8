<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    use HasFactory;

    protected $table = 'forms';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'user_id',
        'uuid',
        'category_id',
        'headline',
        'introduction',
        'is_required_role',
        'is_displayed_role',
        'is_required_first_name',
        'is_displayed_first_name',
        'is_required_last_name',
        'is_displayed_last_name',
        'is_required_email',
        'is_displayed_email',
        'is_required_telephone',
        'is_displayed_telephone',
        'is_required_website',
        'is_displayed_website',
        'is_required_company',
        'is_displayed_company',
        'is_required_cvr_number',
        'is_displayed_cvr_number',
        'is_required_address',
        'is_displayed_address',
        'is_required_company_telephone',
        'is_displayed_company_telephone',
        'is_required_company_email',
        'is_displayed_company_email',
        'is_required_profile_image',
        'is_displayed_profile_image',
        'is_required_logo',
        'is_displayed_logo',
        'add_to_deals',
        'status'
    ];

    public function FormSubmissions(){
        return $this->hasMany('App\Models\FormSubmission','form_id', 'id');
    }

    public function FormCustomizedFields(){
        return $this->hasMany('App\Models\FormCustomizedFields','form_id', 'id');
    }
}
