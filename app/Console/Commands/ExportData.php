<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\Sending_users;
use App\Mail\Confirm_user;
use App\User;
use Storage;
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
    protected $description = 'trigger all users didn\'t sent before for the admin';

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
        $users=User::where('admin_sent',0)->get();
        foreach($users as $user){
            // sending message to Admin to inform him that he recieved a new request
            $data=[
                'name'=>$user->name,
                'name_ar'=>$user->name_ar,
                'email'=>$user->email,
                'brand_name'=>$user->brand_name,
                'brand_name_ar'=>$user->brand_name_ar
            ];
            $mail=Mail::to('mmm619253@gmail.com')->send(new Sending_users($data));

            // sending message to user to inform him that we recieved his request
            $data = ['name'=>$user->name,'confirm' => 'We have received your request'];
            Mail::to($user->email)->send(new Confirm_user($data));

            // changing the status for this request to don't send again to mail
            $user->update(['admin_sent'=>1]);
        }

        $this->info('Successful');
    }
}
