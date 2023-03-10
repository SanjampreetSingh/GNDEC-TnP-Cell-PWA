<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\User;

class UserCreateEmail extends Mailable
{
    use Queueable, SerializesModels;

    private $user;

    /**
    * Create a new message instance.
    *
    * @return void
    */
    public function __construct($user)
    {
        $this->user = $user;
    }
    
    /**
    * Build the message.
    *
    * @return $this
    */
    public function build()
    {  
        $params = [
            'username' => $this->user['username'],
            'email' =>  $this->user['email'],
            'phone_number' =>  $this->user['phone_number']
        ];
        
        return $this->markdown('emails.users.userCreated',$params)
        ->subject(trans('messages.email.userCreatedMailSendSubject'));
    }
}
