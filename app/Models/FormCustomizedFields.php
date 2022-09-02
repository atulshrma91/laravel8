<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormCustomizedFields extends Model
{
    use HasFactory;
    protected $table = 'form_customized_fields';
    protected $primaryKey = 'id';
    protected $fillable = [
        'form_id',
        'name',
        'type',
        'is_required',
        'is_displayed',
        'option_name',
        'options_selection',
        'options_selection_choice'
    ];
}
