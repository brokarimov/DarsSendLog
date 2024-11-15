<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\VerifyCode;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Log;

class DeleteVerifyCode extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:delete-verify-code';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Code is deleted';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (auth()->check()) {
            $time = Carbon::now()->subSeconds(60);
            // dd($time);
            $user = User::findOrFail(auth()->user()->id);
            $verifyCode = VerifyCode::where('user_id', auth()->user()->id)->first();
            if ($user && $user->created_at > $time && $verifyCode) {
                
                $verifyCode->delete();
                session()->flash('alert', 'Salom ' . $user->name . '. Ro\'yxatdan o\'tganligingiz bilan tabriklaymiz!');
                Log::info('User registered. User ID: ' . $user->id);
            }
        }
    }

}
