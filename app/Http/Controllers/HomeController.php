<?php

namespace App\Http\Controllers;

use Config;
use Illuminate\Http\Request;
use Mail;
use Carbon\Carbon;
use GuzzleHttp\Client;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return view('home');
    }

    public function support() {
        return view('support');
    }

    public function submitSupportTicket(Request $request) {
        //Google ReCaptcha Verification
        $client = new Client;
        $response = $client->request('POST', 'https://www.google.com/recaptcha/api/siteverify', [
            'form_params' => [
                'secret' => Config::get('google.captcha_secret'),
                'response' => $request->input('g-recaptcha-response'),
            ]
        ]);
        $r = json_decode($response->getBody())->success;
        if($r != true) {
            return redirect()->back()->with('error', 'You must complete the ReCaptcha to continue.');
        }
        
        //Continue with sending the ticket
        $name = $request->name;
        $email = $request->email;
        $reason = $request->reason;
        $content = $request->msg;
        $time = Carbon::now();

        Mail::send('emails.support', ['name' => $name, 'email' => $email, 'reason' => $reason, 'content' => $content, 'time' => $time], function ($m) use ($email, $name) {
            $m->from('noreply@team-stringer.com', $name);
            $m->to('info@team-stringer.com')->cc($email);
            $m->subject('New Message From '.$name);
        });

        return redirect()->back()->with('success', 'Your message has been successfully sent.');
    }

    public function termsOfService() {
        return view('terms');
    }
}
