<?php

namespace App\Http\Controllers;
use \Illuminate\Http\Request;
use \App\Events\MessageSent;
use \App\ContactMessage;
use Illuminate\Support\Facades\Event;
use App\Rules\AlphaWithSpace;


class ContactMessageController extends Controller
{

  //The contact form
  public function getContactIndex()
  {
    return view('general.other.contact');
  }

  //Processing that conctact form
  public function processMessage(Request $request)
  {

    //Prepare our error messages in advance
    $messages = [
      'name.required' => 'You must enter a name',
      'email.required' => 'You must enter an e-mail address',
      'email.email' => 'You must enter a valid e-mail address',
      'subject.required' => 'Please enter a subject line',
      'message.required' => 'Please enter a message'
    ];

    //Validate the input -> if not passed, it will automatically (on the form page) display $errors
    $this->validate($request,[
      'name' => ['bail', 'required', new AlphaWithSpace],
      'email' => 'bail|required|email',
      'subject' => 'required',
      'message' => 'required'
    ], $messages);


    //If here, then we passed the validation

    //Create and store in the database
    $contactMessage = new ContactMessage();
    $contactMessage->sender = $request['name'];
    $contactMessage->email = $request['email'];
    $contactMessage->subject = $request['subject'];
    $contactMessage->body = $request['message'];
    $contactMessage->save();

    //Fire the event of creation
    Event::fire(new MessageSent($contactMessage->sender,$contactMessage->email,$contactMessage->subejct,$contactMessage->body));

    //Return to the contact form with an OK msg

    //If we return the VIEW, we re-render the view, thus no flash msg from session
    //Instead, we must return THE ROUTE along with the session var
    //return view('general.other.contact')->with('success', 'We have succesfully received your message! We will contact you as soon as we can!');
    return redirect()->route('contact')->with('success', 'We have succesfully received your message!We will contact you as soon as we can!');
  }


}
