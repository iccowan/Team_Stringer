<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\PasswordReset;
use App\StringRequest;
use Auth;
use Carbon\Carbon;
use Mail;
use GuzzleHttp\Client;
use Config;

class AuthController extends Controller
{
    public function login() {
        return view('auth.login');
    }

    public function register($plan) {
        return view('auth.register')->with('plan', $plan);
    }

    public function registerUser(Request $request) {
        $validation = $request->validate([
            'email' => 'required|unique:users',
            'fname' => 'required',
            'lname' => 'required',
            'team_name' => 'required',
            'birthday' => 'required',
            'password' => 'required',
            'password2' => 'required'
        ]);

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

        //Continue with Registration
        $date = $request->birthday;
        $month = substr($date, 0, 2);
        $day = substr($date, 3, 2);
        $year = substr($date, 6, 4);
        $date = Carbon::create($year, $month, $day);
        $d = $date->toDateString();
        $now = Carbon::now()->subYears(13);
        $date_now = $now->toDateString();
        $time_now = Carbon::now()->addMinutes(1)->addHours(24);
        $time_subscription = substr($time_now, 0, 10).'T'.substr($time_now, 11).'Z';
        if($d <= $date_now) {

            if($request->password == $request->password2 && $request->terms == 1) {
                $user = new User;
                $user->name = $request->fname.' '.$request->lname;
                $user->email = $request->email;
                $user->password = encrypt($request->password);
                $user->birthday = $d;
                $user->role = 'COACH';
                $user->team_name = $request->team_name;
                $user->team_token = str_random(32);
                $user->account_type = 0;
                $user->plan_id = $request->plan;
                $user->password = encrypt($request->password);
                $user->save();
                Auth::login($user);

                if($request->plan == 0) {
                    return redirect('/')->with('success', 'Account created successfully.');
                } elseif($request->plan == 1) {
                    $json_basic = '{
                        "name": "'.$user->name.' Basic Plan",
                        "description": "Basic Plan subscription on Team Stringer for $5 per month.",
                        "start_date": "'.$time_subscription.'",
                        "payer": {
                          "payment_method": "paypal",
                          "payer_info": {
                            "email": "'.$user->email.'"
                          }
                        },
                        "plan": {
                          "id": "P-37B169604X662094TQRF7N6A"
                        },
                        "override_merchant_preferences": {
                            "return_url": "https://www.team-stringer.com/register-completion/complete",
                            "cancel_url": "https://www.team-stringer.com/register-completion/cancel"
                          }
                      }';

                      $client = new Client;
                      $response = $client->request('POST', 'https://api.paypal.com/v1/payments/billing-agreements', [
                          'headers' => [
                              'Content-Type' => 'application/json',
                              'Authorization' => 'Bearer '.Config::get('paypal.token')
                          ],
                          'body' => $json_basic
                        ]);
                        $r = json_decode($response->getBody());
                        $r_url = $r->links[0]->href;

                        return redirect($r_url);
                } elseif($request->plan == 2) {
                    $json_basic = '{
                        "name": "'.$user->name.' High School Plan",
                        "description": "High School Plan subscription on Team Stringer for $15 per month.",
                        "start_date": "'.$time_subscription.'",
                        "payer": {
                          "payment_method": "paypal",
                          "payer_info": {
                            "email": "'.$user->email.'"
                          }
                        },
                        "plan": {
                          "id": "P-06T6908914504473LQRGPXHA"
                        },
                        "override_merchant_preferences": {
                            "return_url": "https://www.team-stringer.com/register-completion/complete",
                            "cancel_url": "https://www.team-stringer.com/register-completion/cancel"
                          }
                      }';

                      $client = new Client;
                      $response = $client->request('POST', 'https://api.paypal.com/v1/payments/billing-agreements', [
                          'headers' => [
                              'Content-Type' => 'application/json',
                              'Authorization' => 'Bearer '.Config::get('paypal.token')
                          ],
                          'body' => $json_basic
                        ]);
                        $r = json_decode($response->getBody());
                        $r_url = $r->links[0]->href;

                        return redirect($r_url);
                } elseif($request->plan == 3) {
                    $json_basic = '{
                        "name": "'.$user->name.' College Plan",
                        "description": "College Plan subscription on Team Stringer for $25 per month.",
                        "start_date": "'.$time_subscription.'",
                        "payer": {
                          "payment_method": "paypal",
                          "payer_info": {
                            "email": "'.$user->email.'"
                          }
                        },
                        "plan": {
                          "id": "P-6JG60171MU490663BQRG3AQY"
                        },
                        "override_merchant_preferences": {
                            "return_url": "https://www.team-stringer.com/register-completion/complete",
                            "cancel_url": "https://www.team-stringer.com/register-completion/cancel"
                          }
                      }';

                      $client = new Client;
                      $response = $client->request('POST', 'https://api.paypal.com/v1/payments/billing-agreements', [
                          'headers' => [
                              'Content-Type' => 'application/json',
                              'Authorization' => 'Bearer '.Config::get('paypal.token')
                          ],
                          'body' => $json_basic
                        ]);
                        $r = json_decode($response->getBody());
                        $r_url = $r->links[0]->href;

                        return redirect($r_url);
                }
            } elseif($request->password != $request->password2) {
                return redirect()->back()->with('error', 'The passwords must match.');
            } else {
                return redirect()->back()->with('error', 'You must accept the terms of service.');
            }
        } else {
            return redirect('/')->with('error', 'You must be older than 13 to create an account. If you are older than 13, please attempt to register again and confirm that you typed your birthday in the correct format.');
        }
    }

    public function verifyPayPalTransaction(Request $request) {
        $token = $request->query('token');
        if(Auth::check()) {
            $user = Auth::user();
            $client = new Client;
            $response = $client->request('POST', 'https://api.paypal.com/v1/payments/billing-agreements/'.$token.'/agreement-execute', [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer '.Config::get('paypal.token')
                ]
              ]);

            $r = json_decode($response->getBody());
            $plan_id = $r->id;
            $success = $r->payer->status;
            if($success == 'unverified') {
                $user->delete();

                return redirect('/')->with('error', 'The payment could not be processed. The PayPal process was not completed successfully.');
            } elseif($success == 'verified') {
                $user->account_type = $user->plan_id;
                $user->plan_id = $plan_id;
                $user->save();

                Mail::send('emails.new_account', ['user' => $user], function ($m) use ($user) {
                    $m->from('noreply@team-stringer.com', 'Welcome to Team Stringer');
                    $m->to($user->email);
                    $m->subject('Welcome to Team Stringer!');
                });

                return redirect('/')->with('success', 'The payment was processed successfully and your plan and account have been saved.');
            } else {
                $user->delete();

                return redirect('/')->with('error', 'The payment could not be processed.');
            }
        } else {
            return redirect('/')->with('error', 'You must be logged in to continue.');
        }
    }

    public function cancelPayPal() {
        if(Auth::check()) {
            $user = Auth::user();
            $user->delete();
        }

        return redirect('/')->with('error', 'The payment could not be processed. You cancelled the PayPal transaction.');
    }

    public function loginUser(Request $request) {
        $email = $request->email;
        $user = User::where('email', $email)->first();

        if($user == null) {
            return redirect()->back()->with('error', 'An account with this email does not exist.');
        } elseif(decrypt($user->password) != $request->password) {
            return redirect()->back()->with('error', 'This password does not match the provided email.');
        } elseif($request->remember == 1) {
            Auth::login($user, true);

            return redirect('/')->with('success', 'You have been logged in successfully.');
        } else {
            Auth::login($user);

            return redirect('/')->with('success', 'You have been logged in successfully.');
        }
    }

    public function logoutUser() {
        $user = User::find(Auth::id());
        Auth::logout($user);

        return redirect('/')->with('success', 'You have been logged out successfully.');
    }

    public function showPasswordReset() {
        return view('auth.requestreset');
    }

    public function requestPasswordReset(Request $request) {
        $email = $request->email;

        $user = User::where('email', $email)->first();

        if($user == null) {
            return redirect()->back()->with('error', 'This email does not exist.');
        } else {
            $reset = new PasswordReset;
            $reset->email = $user->email;
            $reset->token = encrypt(str_random(32));
            $reset->created_at = Carbon::now();
            $reset->save();

            $email = $reset->email;
            $token = decrypt($reset->token);
            $name = $user->name;

            Mail::send('emails.resetpassword', ['email' => $email, 'token' => $token, 'name' => $name], function ($m) use ($email) {
                $m->from('noreply@team-stringer.com', 'Team Stringer Password Reset');
                $m->to($email);
                $m->subject('Your Password Reset Link');
            });

            return redirect('/')->with('success', 'An email has been sent with a link to reset your password.');
        }
    }

    public function resetPasswordEmailGet($token) {
        return view('auth.newpassemail')->with('token', $token);
    }

    public function resetPasswordEmailVerify(Request $request, $token) {
        $email = $request->email;
        $user = User::where('email', $email)->first();
        $password_reset = PasswordReset::where('email', '=', $user->email)->first();
        if($password_reset == null) {
            return redirect('/')->with('error', 'This token is invalid for the email provided..');
        }

        $real_token = decrypt($password_reset->token);

        if($real_token == $token) {
            return redirect('/email-verified/reset-password/'.$token.'/'.$user->id);
        } else {
            return redirect('/')->with('error', 'This token is invalid for the email provided.');
        }
    }

    public function resetPassword($token, $id) {
        $user = User::find($id);
        return view('auth.newpassword')->with('user', $user);
    }

    public function saveNewPassword(Request $request) {
        $validation = $request->validate([
            'password' => 'required',
            'password2' => 'required'
        ]);

        if($request->password === $request->password2) {
            $user = User::find($request->user_id);
            $user->password = encrypt($request->password);
            $user->save();

            $password_resets = PasswordReset::where('email', $user->email);
            $password_resets->delete();

            // Mail::send() Send an email informing the user that their password has been reset.

            return redirect('/')->with('success', 'Your password has been successfully reset.');
        } else {
            return redirect()->back()->with('error', 'The passwords must match.');
        }
    }

    public function updateProfile(Request $request) {
        $now = Carbon::now();
        $now = substr($now, 0, 19);
        $month = substr($now, 5, 2);
        $year = substr($now, 0, 4);
        if($request->month != null) {
            $month = $request->month;
        }
        if($request->year != null) {
            $year = $request->year;
        }
        $lower_bound = substr(Carbon::create($year, $month, 1, 0, 0, 0), 0, 19);
        $upper_bound = substr(Carbon::create($year, $month, 1, 0, 0, 0)->addMonths(1), 0, 19);
        $stringing_jobs = StringRequest::where('updated_by', Auth::id())->where('updated_at', '>', $lower_bound)->where('updated_at', '<', $upper_bound)->get()->count();
        $user = Auth::user();
        return view('auth.profile')->with('user', $user)->with('stringing_jobs', $stringing_jobs)->with('month', $month)->with('year', $year);
    }

    public function showStringingStats(Request $request) {
        $month = $request->month;
        $year = $request->year;
        return redirect('/profile?month='.$month.'&year='.$year);
    }

    public function saveProfile(Request $request, $id) {
        $user = User::find($id);

        $validation = $request->validate([
            'email' => 'required|unique:users,email,'.$user->id,
            'name' => 'required',
            'birthday' => 'required',
            'current_password' => 'required'
        ]);

        if($request->current_password === decrypt($user->password)){
            $user->name = $request->name;
            $user->email = $request->email;
            $user->team_name = $request->team_name;
            $user->birthday = $request->birthday;
            if($request->password != null) {
                if ($request->password == $request->password2) {
                    $user->password = encrypt($request->password);
                } else {
                    return redirect()->back()->with('error', 'Your updated passwords do not match.');
                }
            }
            $user->save();
            return redirect('/profile')->with('success', 'Your profile has been updated successfully.');
        } else {
            return redirect()->back()->with('error', 'The password your entered is incorrect. If you have forgotten your password, please logout and use the forgot password link to reset your password.');
        }
    }

    public function updatePlan(Request $request, $id) {
        $user = User::find($id);
        $now = Carbon::now();

        if($user->plan_changes > 1) {
            return redirect('/profile')->with('error', 'You are only permitted 2 plan changes per month. If for some reason you need to change your plan again, please send an email to info@team-stringer.com');
        } else {
            if($user->plan_id == null) {
                return redirect()->back()->with('error', 'You are not allowed to do that. The person that created the account must be the person to upgrade or downgrade the account. If for some reason you need to make a change, please send an email to info@team-stringer.com.');
            } elseif($request->plan == $user->account_type) {
                return redirect()->back();
            } elseif($request->current_password === decrypt($user->password)) {
                $client = new Client;
                if($request->plan == 0) {
                    $response = $client->request('POST', 'https://api.paypal.com/v1/payments/billing-agreements/'.$user->plan_id.'/cancel', [
                        'headers' => [
                            'Authorization' => 'Bearer '.Config::get('paypal.token'),
                            'Content-Type' => 'application/json',
                        ],'body' =>
                            '{
                                "note": "Plan cancellation requested by subscriber."
                            }'
                    ]);
                    $code = $response->getStatusCode();
                    if($code == 204) {
                        $new_plan = 0;
                        $user->plan_id = 0;
                        $user->account_type = 0;
                        $user->save();

                        $team = $user->team_name;
                    $team_token = $user->team_token;
                    if($user->account_type == 0) {
                        $coaches = User::where('role', 'COACH')->where('team_name', $team)->where('team_token', $team_token)->where('id', '!=', $user->id)->get();
                        $players = User::where('role', 'PLAYER')->orWhere('role', 'STRING')->where('team_name', $team)->where('team_token', $team_token)->get();
                        $stringers = User::where('role', 'STRING')->where('team_name', $team)->where('team_token', $team_token)->get();
                        if($coaches->count() > 1) {
                            foreach($coaches as $c) {
                                $c->delete();
                            }
                        }
                        if($players->count() > 10) {
                            $number = $players->count() - 10;
                            $delete_players = User::where('role', 'PLAYER')->where('team_name', $team)->where('team_token', $team_token)->get($number);
                            foreach($delete_players as $p) {
                                $p->delete();
                            }
                        }
                        if($stringers->count() > 1) {
                            $number = $stringers->count() - 1;
                            $delete_stringers = User::where('role', 'STRING')->where('team_name', $team)->where('team_token', $team_token)->get($number);
                            foreach($delete_stringers as $s) {
                                $s->delete();
                            }
                        }
                    } elseif($user->account_type == 1) {
                        $coaches = User::where('role', 'COACH')->where('team_name', $team)->where('team_token', $team_token)->where('id', '!=', $user->id)->get();
                        $players = User::where('role', 'PLAYER')->orWhere('role', 'STRING')->where('team_name', $team)->where('team_token', $team_token)->get();
                        $stringers = User::where('role', 'STRING')->where('team_name', $team)->where('team_token', $team_token)->get();
                        if($coaches->count() > 2) {
                            $number = $coaches->count() - 2;
                            $delete_coaches = User::where('role', 'COACH')->where('team_name', $team)->where('team_token', $team_token)->where('id', '!=', $user->id)->get($number);
                            foreach($delete_coaches as $c) {
                                $c->delete();
                            }
                        }
                        if($players->count() > 20) {
                            $number = $players->count() - 20;
                            $delete_players = User::where('role', 'PLAYER')->where('team_name', $team)->where('team_token', $team_token)->get($number);
                            foreach($delete_players as $p) {
                                $p->delete();
                            }
                        }
                        if($stringers->count() > 2) {
                            $number = $stringers->count() - 2;
                            $delete_stringers = User::where('role', 'STRING')->where('team_name', $team)->where('team_token', $team_token)->get($number);
                            foreach($delete_stringers as $s) {
                                $s->delete();
                            }
                        }
                    } elseif($user->account_type == 2) {
                        $coaches = User::where('role', 'COACH')->where('team_name', $team)->where('team_token', $team_token)->where('id', '!=', $user->id)->get();
                        $players = User::where('role', 'PLAYER')->orWhere('role', 'STRING')->where('team_name', $team)->where('team_token', $team_token)->get();
                        $stringers = User::where('role', 'STRING')->where('team_name', $team)->where('team_token', $team_token)->get();
                        if($coaches->count() > 4) {
                            $number = $coaches->count() - 4;
                            $delete_coaches = User::where('role', 'COACH')->where('team_name', $team)->where('team_token', $team_token)->where('id', '!=', $user->id)->get($number);
                            foreach($delete_coaches as $c) {
                                $c->delete();
                            }
                        }
                        if($players->count() > 40) {
                            $number = $players->count() - 40;
                            $delete_players = User::where('role', 'PLAYER')->where('team_name', $team)->where('team_token', $team_token)->get($number);
                            foreach($delete_players as $p) {
                                $p->delete();
                            }
                        }
                        if($stringers->count() > 4) {
                            $number = $stringers->count() - 4;
                            $delete_stringers = User::where('role', 'STRING')->where('team_name', $team)->where('team_token', $team_token)->get($number);
                            foreach($delete_stringers as $s) {
                                $s->delete();
                            }
                        }
                    }

                    $user->plan_changes = $user->plan_changes + 1;
                    $user->save();
                    return redirect('/profile')->with('success', 'Your plan has been updated successfully. Changes will be effective immediately.');
                    } else {
                        return redirect()->back()->with('error', 'The action could not be completed. For assistance, please send an email to info@team-stringer.com.');
                    }
                } else {
                    $tomorrow = Carbon::now()->addMinutes(1)->addHours(24);
                    $time_subscription = substr($tomorrow, 0, 10).'T'.substr($tomorrow, 11).'Z';
                    $client = new Client;
                    if($user->account_type != 0) {
                        $response = $client->request('POST', 'https://api.paypal.com/v1/payments/billing-agreements/'.$user->plan_id.'/cancel', [
                            'headers' => [
                                'Authorization' => 'Bearer '.Config::get('paypal.token'),
                                'Content-Type' => 'application/json'
                            ],'body' =>
                                '{
                                    "note": "Cancelling plan for plan change."
                                }'
                        ]);
                        $code = $response->getStatusCode();
                        if($code != 204) {
                            return redirect('/profile')->with('error', 'Something went wrong. Please send an email to info@team-stringer.com for assistance.');
                        }
                    }
                    $user->plan_id = $request->plan;
                    $user->account_type = 0;
                    $user->save();

                    if($request->plan == 1) {
                        $json_basic = '{
                            "name": "'.$user->name.' Basic Plan",
                            "description": "Basic Plan subscription on Team Stringer for $5 per month.",
                            "start_date": "'.$time_subscription.'",
                            "payer": {
                            "payment_method": "paypal",
                            "payer_info": {
                                "email": "'.$user->email.'"
                            }
                            },
                            "plan": {
                            "id": "P-37B169604X662094TQRF7N6A"
                            },
                            "override_merchant_preferences": {
                                "return_url": "https://www.team-stringer.com/upgrade/complete",
                                "cancel_url": "https://www.team-stringer.com/upgrade/cancel"
                            }
                        }';

                        $client = new Client;
                        $response = $client->request('POST', 'https://api.paypal.com/v1/payments/billing-agreements', [
                            'headers' => [
                                'Content-Type' => 'application/json',
                                'Authorization' => 'Bearer '.Config::get('paypal.token')
                            ],
                            'body' => $json_basic
                            ]);
                            $r = json_decode($response->getBody());
                            $r_url = $r->links[0]->href;

                            return redirect($r_url);
                    } elseif($request->plan == 2) {
                        $json_basic = '{
                            "name": "'.$user->name.' High School Plan",
                            "description": "High School Plan subscription on Team Stringer for $15 per month.",
                            "start_date": "'.$time_subscription.'",
                            "payer": {
                            "payment_method": "paypal",
                            "payer_info": {
                                "email": "'.$user->email.'"
                            }
                            },
                            "plan": {
                            "id": "P-06T6908914504473LQRGPXHA"
                            },
                            "override_merchant_preferences": {
                                "return_url": "https://www.team-stringer.com/upgrade/complete",
                                "cancel_url": "https://www.team-stringer.com/upgrade/cancel"
                            }
                        }';

                        $client = new Client;
                        $response = $client->request('POST', 'https://api.paypal.com/v1/payments/billing-agreements', [
                            'headers' => [
                                'Content-Type' => 'application/json',
                                'Authorization' => 'Bearer '.Config::get('paypal.token')
                            ],
                            'body' => $json_basic
                            ]);
                            $r = json_decode($response->getBody());
                            $r_url = $r->links[0]->href;

                            return redirect($r_url);
                    } elseif($request->plan == 3) {
                        $json_basic = '{
                            "name": "'.$user->name.' College Plan",
                            "description": "College Plan subscription on Team Stringer for $25 per month.",
                            "start_date": "'.$time_subscription.'",
                            "payer": {
                            "payment_method": "paypal",
                            "payer_info": {
                                "email": "'.$user->email.'"
                            }
                            },
                            "plan": {
                            "id": "P-6JG60171MU490663BQRG3AQY"
                            },
                            "override_merchant_preferences": {
                                "return_url": "https://www.team-stringer.com/upgrade/complete",
                                "cancel_url": "https://www.team-stringer.com/upgrade/cancel"
                            }
                        }';
                        }

                        $client = new Client;
                        $response = $client->request('POST', 'https://api.paypal.com/v1/payments/billing-agreements', [
                            'headers' => [
                                'Content-Type' => 'application/json',
                                'Authorization' => 'Bearer '.Config::get('paypal.token')
                            ],
                            'body' => $json_basic
                        ]);
                        $r = json_decode($response->getBody());
                        $r_url = $r->links[0]->href;

                        return redirect($r_url);
                }
            }
        }
    }

    public function upgradeComplete(Request $request) {
        $token = $request->query('token');
        if(Auth::check()) {
            $user = Auth::user();
            $client = new Client;
            $response = $client->request('POST', 'https://api.paypal.com/v1/payments/billing-agreements/'.$token.'/agreement-execute', [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer '.Config::get('paypal.token')
                ]
              ]);

            $r = json_decode($response->getBody());
            $plan_id = $r->id;
            $success = $r->payer->status;
            if($success == 'unverified') {
                return redirect('/profile')->with('error', 'The payment could not be processed. The PayPal process was not completed successfully.');
            } elseif($success == 'verified') {
                $user->account_type = $user->plan_id;
                $user->plan_id = $plan_id;
                $user->save();

                $team = $user->team_name;
                $team_token = $user->team_token;
                if($user->account_type == 0) {
                    $coaches = User::where('role', 'COACH')->where('team_name', $team)->where('team_token', $team_token)->where('id', '!=', $user->id)->get();
                    $players = User::where('role', 'PLAYER')->orWhere('role', 'STRING')->where('team_name', $team)->where('team_token', $team_token)->get();
                    $stringers = User::where('role', 'STRING')->where('team_name', $team)->where('team_token', $team_token)->get();
                    if($coaches->count() > 1) {
                        foreach($coaches as $c) {
                            $c->delete();
                        }
                    }
                    if($players->count() > 10) {
                        $number = $players->count() - 10;
                        $delete_players = User::where('role', 'PLAYER')->where('team_name', $team)->where('team_token', $team_token)->get($number);
                        foreach($delete_players as $p) {
                            $p->delete();
                        }
                    }
                    if($stringers->count() > 1) {
                        $number = $stringers->count() - 1;
                        $delete_stringers = User::where('role', 'STRING')->where('team_name', $team)->where('team_token', $team_token)->get($number);
                        foreach($delete_stringers as $s) {
                            $s->delete();
                        }
                    }
                } elseif($user->account_type == 1) {
                    $coaches = User::where('role', 'COACH')->where('team_name', $team)->where('team_token', $team_token)->where('id', '!=', $user->id)->get();
                    $players = User::where('role', 'PLAYER')->orWhere('role', 'STRING')->where('team_name', $team)->where('team_token', $team_token)->get();
                    $stringers = User::where('role', 'STRING')->where('team_name', $team)->where('team_token', $team_token)->get();
                    if($coaches->count() > 2) {
                        $number = $coaches->count() - 2;
                        $delete_coaches = User::where('role', 'COACH')->where('team_name', $team)->where('team_token', $team_token)->where('id', '!=', $user->id)->get($number);
                        foreach($delete_coaches as $c) {
                            $c->delete();
                        }
                    }
                    if($players->count() > 20) {
                        $number = $players->count() - 20;
                        $delete_players = User::where('role', 'PLAYER')->where('team_name', $team)->where('team_token', $team_token)->get($number);
                        foreach($delete_players as $p) {
                            $p->delete();
                        }
                    }
                    if($stringers->count() > 2) {
                        $number = $stringers->count() - 2;
                        $delete_stringers = User::where('role', 'STRING')->where('team_name', $team)->where('team_token', $team_token)->get($number);
                        foreach($delete_stringers as $s) {
                            $s->delete();
                        }
                    }
                } elseif($user->account_type == 2) {
                    $coaches = User::where('role', 'COACH')->where('team_name', $team)->where('team_token', $team_token)->where('id', '!=', $user->id)->get();
                    $players = User::where('role', 'PLAYER')->orWhere('role', 'STRING')->where('team_name', $team)->where('team_token', $team_token)->get();
                    $stringers = User::where('role', 'STRING')->where('team_name', $team)->where('team_token', $team_token)->get();
                    if($coaches->count() > 4) {
                        $number = $coaches->count() - 4;
                        $delete_coaches = User::where('role', 'COACH')->where('team_name', $team)->where('team_token', $team_token)->where('id', '!=', $user->id)->get($number);
                        foreach($delete_coaches as $c) {
                            $c->delete();
                        }
                    }
                    if($players->count() > 40) {
                        $number = $players->count() - 40;
                        $delete_players = User::where('role', 'PLAYER')->where('team_name', $team)->where('team_token', $team_token)->get($number);
                        foreach($delete_players as $p) {
                            $p->delete();
                        }
                    }
                    if($stringers->count() > 4) {
                        $number = $stringers->count() - 4;
                        $delete_stringers = User::where('role', 'STRING')->where('team_name', $team)->where('team_token', $team_token)->get($number);
                        foreach($delete_stringers as $s) {
                            $s->delete();
                        }
                    }
                }

                $user->plan_changes = $user->plan_changes + 1;
                $user->save();
                return redirect('/profile')->with('success', 'Your plan has been updated successfully. Changes will be effective immediately and the new charge will occur within 24 hours.');
            } else {
                $user->account_type = 0;
                $user->save();
                return redirect('/profile')->with('error', 'The payment could not be processed. You will still need to select a plan again in order to continue.');
            }
        } else {
            return redirect('/')->with('error', 'You must be logged in to continue.');
        }
    }

    public function upgradeCancel() {
        return redirect('/profile')->with('error', 'The upgrade could not be completed because the PayPal transaction got cancelled.');
    }
}
