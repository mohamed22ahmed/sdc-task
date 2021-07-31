<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Mpdf\Mpdf;
use Storage;

class Sending_users extends Mailable
{
    use Queueable, SerializesModels;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        // this function to rewrite the content of sample.pdf to attach to mail
        $this->generate_pdf();

        // sending the mail with the body in sending_users.blade.php and attachment sample.pdf
        return $this->view('sending_users')
            ->attach(Storage::path('public/sample.pdf'), [
                'as' => 'sample.pdf',
                'mime' => 'application/pdf',
            ]);
    }


    function generate_pdf()
    {
        $mpdf = new Mpdf();
        // writing the content of pdf (there are many ways but i prefered to
        // add it like below inseide the function convert_users_data_to_html)
        $mpdf->WriteHTML($this->convert_users_data_to_html());
        //save the file put which location you need folder/filname
        $mpdf->Output(Storage::path('public/sample.pdf'), 'F');
    }

    function convert_users_data_to_html()
    {
        $users = User::where('admin_sent', 0)->get();
        // table headers
        $output = '
                <h3 align="center">New Requests</h3>
                <table width="100%" style="border-collapse: collapse; border: 0px;">
                <tr>
                    <th style="border: 1px solid;" width="10%">ID</th>
                    <th style="border: 1px solid;" width="20%">Name</th>
                    <th style="border: 1px solid;" width="15%">Email</th>
                    <th style="border: 1px solid;" width="15%">Brand Name</th>
                </tr>
        ';
        // table body(rows)
        foreach ($users as $user) {
            $output .= '
                    <tr>
                        <td style="border: 1px solid;">' . $user->id . '</td>
                        <td style="border: 1px solid;">' . $user->name . '</td>
                        <td style="border: 1px solid;">' . $user->email . '</td>
                        <td style="border: 1px solid;">' . $user->brand_name . '</td>
                    </tr>
                ';
        }
        $output .= '</table>';
        return $output;
    }
}
