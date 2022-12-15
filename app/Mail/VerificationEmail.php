<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerificationEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    private $otp, $fname, $lname;

    public function __construct($otp, $fname, $lname){
        $this->otp = $otp;
        $this->fname = $fname;
        $this->lname = $lname;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(){
        return $this->view('email')->with([
            'otp' => $this->otp,
            'fname' => $this->fname,
            'lname' => $this->lname
        ]);
    }
}
