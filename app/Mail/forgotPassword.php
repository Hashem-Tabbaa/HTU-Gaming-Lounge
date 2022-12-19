<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class forgotPassword extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    private $token, $fname, $lname, $url;
    public function __construct($token, $fname, $lname)
    {
        $this->token = $token;
        $this->url =  url('/forgot-password/'.$token);
        $this->fname = $fname;
        $this->lname = $lname;
    }
    public function build(){
        return $this->view('emails.forgotpasswordemail')->with([
            'url' => $this->url,
            'fname' => $this->fname,
            'lname' => $this->lname
        ]);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
}
