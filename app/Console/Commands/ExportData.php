<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\Sending_users;
use App\Mail\Confirm_user;
use App\User;
use Storage;
use PDF;

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
        $users = User::where('admin_sent', 0)->get();
        foreach ($users as $user) {
            // sending message to Admin to inform him that he recieved a new request
            $data = [
                'name' => $user->name,
                'name_ar' => $user->name_ar,
                'email' => $user->email,
                'brand_name' => $user->brand_name,
                'brand_name_ar' => $user->brand_name_ar
            ];
            $mail = Mail::to('mmm619253@gmail.com')->send(new Sending_users($data));

            // sending message to user to inform him that we recieved his request
            $data = ['name' => $user->name, 'confirm' => 'We have received your request'];
            Mail::to($user->email)->send(new Confirm_user($data));

            // changing the status for this request to don't send again to mail
            $user->update(['admin_sent' => 1]);
        }

        $this->info('Successful');
    }

    // function pdf()
    // {
    //     $pdf = \App::make('dompdf.wrapper');
    //     $pdf->loadHTML($this->convert_users_data_to_html());
    //     return $pdf->stream();
    // }

    // function convert_users_data_to_html()
    // {
    //     $customer_data = $this->get_customer_data();
    //     $output = '
    //             <h3 align="center">New Requests</h3>
    //             <table width="100%" style="border-collapse: collapse; border: 0px;">
    //             <tr>
    //             <th style="border: 1px solid; padding:12px;" width="20%">Name</th>
    //             <th style="border: 1px solid; padding:12px;" width="30%">Arabic Name</th>
    //             <th style="border: 1px solid; padding:12px;" width="15%">Email</th>
    //             <th style="border: 1px solid; padding:12px;" width="15%">Brand Name</th>
    //             <th style="border: 1px solid; padding:12px;" width="20%">Arabic Brand Name</th>
    //         </tr>
    //     ';
    //     foreach ($customer_data as $customer) {
    //         $output .= '
    //                 <tr>
    //                 <td style="border: 1px solid; padding:12px;">' . $customer->CustomerName . '</td>
    //                 <td style="border: 1px solid; padding:12px;">' . $customer->Address . '</td>
    //                 <td style="border: 1px solid; padding:12px;">' . $customer->City . '</td>
    //                 <td style="border: 1px solid; padding:12px;">' . $customer->PostalCode . '</td>
    //                 <td style="border: 1px solid; padding:12px;">' . $customer->Country . '</td>
    //                 </tr>
    //             ';
    //     }
    //     $output .= '</table>';
    //     return $output;
    // }
}
