<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Models\User;
use Mail;

class EventMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $users=User::whereNotNull('email')->get()->toArray();
        if($users){
            foreach($users as $user){
                Mail::send('mail/events-email-template',['name'=>$user['name']],function($message) use($user){
                    $message->from('no-reply@example.com','Project Name');
                    $message->to($user['email']);
                    $message->subject('Events Invitation');
                });
            }
        }
    }
}
