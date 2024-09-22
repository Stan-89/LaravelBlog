<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */

     //In listen, we give Event => [array Of Listeners to that event]
     //Ideally, they get info from the controller in their builder
     /*
      ex: the event     (MessageSent)
        public function __construct($sender, $email, $subject, $body)
          {
              $this->sender = $sender;
              $this->email = $email;
              $this->subject = $subject;
              $this->body = $body;
          }


      AND THE LISTENER: (MessageSentListener)
      public function handle(MessageSent $msg)
      {
          $mailReceiverEmail = "";
          $mailReceiverName = "";

          //Send the info using e-mail
          Mail::send(
          'other.emailMsg', ['sender' => $msg->sender, 'email' => $msg->email, 'subject' => $msg->subject, 'body' =>$msg->body], function($message) use($mailReceiverName, $mailReceiverEmail){
            $message->from('admin@mytestcourse.com', 'Admin');
            $message->to($mailReceiverEmail, $mailReceiverName);
            $message->subject('Message sent from form');
          }
        );
      }

      AND THE FIRING (happens ina controller):
      

      WHERE $msg will be an object of type MessageSent (in whos constructor we gave its variables and properties so that we can later recuperate them and use them)
      inside the listener.
      Why? -> 1. Repeated code (if in many places)
      2. Same event, different listeners. So even less code re-writing
      One could for example, saving in the DB. We do in the controller but it's feasable.
     */
     protected $listen = [
       'App\Events\MessageSent' => [
           'App\Listeners\MessageSentListener'
       ],
     ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
