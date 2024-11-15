<?php

namespace App\Jobs;


use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Mail;

class SendPassword implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public $password;
    public $email;
    public function __construct($email,$password)
    {
        $this->password = $password;
        $this->email = $email;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->email)->send(new \App\Mail\SendPassword($this->password));
    }
}
