<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use \App\Models\UserExtension;

class ExtensionTask extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'extension:daily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cronjob for user extensions';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $user_extensions = UserExtension::where(['is_expired' => 0])->get();
        if(!$user_extensions->isEmpty()){
          foreach($user_extensions as $extension){
            if($extension->status){
              if($extension->on_trial){
                if($extension->trial_expiry_days){
                  if($extension->trial_expiry_days - 1){
                    UserExtension::where('id', $extension->id)->update(['trial_expiry_days' => ($extension->trial_expiry_days - 1)]);
                  }else{
                    UserExtension::where('id', $extension->id)->update(['trial_expiry_days' => 0, 'status' => 0, 'is_expired' => 1]);
                  }
                }
              }else{
                if(date('Y-m-d') >= date('Y-m-d', strtotime($extension->extension_expiry))){
                  UserExtension::where('id', $extension->id)->update(['status' => 0, 'is_expired' => 1]);
                }
              }
            }else{
              if($extension->on_trial){
                if($extension->trial_expiry_days && $extension->trial_expiry_days != 30){
                  UserExtension::where('id', $extension->id)->update(['extension_expiry' => date('Y-m-d', strtotime("+".$extension->trial_expiry_days." days"))]);
                }
              }else{
                if(date('Y-m-d') >= date('Y-m-d', strtotime($extension->extension_expiry))){
                  UserExtension::where('id', $extension->id)->update(['status' => 0, 'is_expired' => 1]);
                }
              }
            }
          }
        }
        $this->info('Extensions updated');
    }
}
