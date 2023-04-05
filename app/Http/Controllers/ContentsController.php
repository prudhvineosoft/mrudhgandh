<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Content;
use App\UserInquiries;
use Mail;

class ContentsController extends Controller
{
    //
    /**
     * Show the informative contents to user.
     *
     * @param  int  $slug
     * @return View
     */
    public function index($slug)
    {
        if ($slug == 'contact-us') {
            return $this->contactUs();
        } else {
            $content = Content::where('slug', $slug)->first();
            return view('contents.index', compact('content'));
        }
    }

    public function contactUs()
    {
        return view('contents.contact-us');
    }


    public function contactSubmit(Request $request)
    {

        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required',
        ]);

        $name = $request->name;
        $email = $request->email;
        $subject = $request->subject;
        $message = $request->message;

        $details = [
            'name' => $name,
            'email' => $email,
            'subject' => $subject,
            'message' => $message,
        ];

        UserInquiries::create($details);
        Mail::to('mrudgandhmudpottery@gmail.com')->send(new \App\Mail\ContactMail($details));

        return http_response_code(200);

        // ALTER TABLE `user_inquiries` ADD `name` VARCHAR(500) NULL DEFAULT NULL AFTER `id`, ADD `email` VARCHAR(250) NULL DEFAULT NULL AFTER `name`, ADD `subject` VARCHAR(500) NULL DEFAULT NULL AFTER `email`, ADD `message` TEXT NULL DEFAULT NULL AFTER `subject`;
    }
}
