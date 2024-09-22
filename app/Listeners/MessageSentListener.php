<?php

namespace App\Listeners;

use App\Events\Event;
use App\Events\MessageSent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class MessageSentListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Event  $event
     * @return void
     */
    public function handle(MessageSent $msg)
    {
        $mailReceiverEmail = "testll@zhorachu.com";
        $mailReceiverName = "Admin";

        //Send the info using e-mail
        Mail::send(
        'general.other.emailMsg', ['sender' => $msg->sender, 'email' => $msg->email, 'subject' => $msg->subject, 'body' =>$msg->body], function($message) use($mailReceiverName, $mailReceiverEmail){
          $message->from('admin@mytestcourse.com', 'Admin');
          $message->to($mailReceiverEmail, $mailReceiverName);
          $message->subject('Message sent from form.');
        }
      );
    }
}
