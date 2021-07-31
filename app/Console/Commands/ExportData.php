<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\Sending_users;
use App\Mail\Confirm_user;
use App\User;

class ExportData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'export:data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'trigger all users didn\'t send before for the admin';

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
     * @return mixed
     */
    public function handle()
    {
        // get users data that didn't send to admin before
        $users = User::where('admin_sent', 0)->get();

        // sending message to Admin to inform him that he recieved a new requests
        // suppose admin email is mmm619253@gmail.com
        $mail = Mail::to('mmm619253@gmail.com')->send(new Sending_users());

        foreach ($users as $user) {
            // sending message to user to inform him that we recieved his request
            $data = ['name' => $user->name, 'confirm' => 'We have received your request'];
            Mail::to($user->email)->send(new Confirm_user($data));

            //changing the status for this request to don't send again to mail
            User::find($user->id)->update(['admin_sent' => 1]);
        }

        // to show successful message when the command executes if it runs successfully
        $this->info('Successful');
    }
}
