<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class CheckMailTemplate extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:mail_template';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check mail template functionality';


    /**
     * Execute the console command.
     */
    public function handle()
    {
        Mail::to('dhana@gmail.com')->send(new \App\Mail\Admin\WelcomeMail(User::first()));
    }
}
