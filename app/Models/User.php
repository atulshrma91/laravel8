<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\CanResetPassword;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail, CanResetPassword
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'username',
        'password',
        'image',
        'to_update_email',
        'last_login',
        'customer_uuid',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function sendEmailVerificationNotification(){
       $this->notify(new \App\Notifications\VerifyEmail);
    }

   public function sendPasswordResetNotification($token){
      $this->notify(new \App\Notifications\MailResetPasswordNotification($token));
    }

   public function hasExtension($extension){
     if(\Auth::user()->hasRole('super-admin')){
       return true;
     }else{
       $extension = \App\Models\Extension::select('id')->where('slug', $extension)->first();
       $user_extension = \App\Models\UserExtension::where('extension_id', $extension->id)->where('user_id', \Auth::user()->id)->first();
       if($user_extension->is_expired){
         return false;
       }else{
         return $user_extension;
       }
     }
   }

   public function isExtensionActivated($extension){
     $extension = \App\Models\Extension::select('id')->where('slug', $extension)->first();
     if($extension){
       return  \App\Models\UserExtension::where(['extension_id' => $extension->id, 'status' => 1])->where('user_id', \Auth::user()->id)->first();
     }else{
       return false;
     }
   }
}
