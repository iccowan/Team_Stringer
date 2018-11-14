<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use GuzzleHttp\Client;
use Config;

class User extends Authenticatable
{
    use Notifiable;
    protected $table = 'users';
    protected $fillable = ['id', 'name', 'email', 'email_verified_at', 'password', 'role', 'team_name', 'team_token', 'remember_token', 'created_at', 'updated_at'];
    protected $hidden = ['password', 'remember_token'];

    public function getPlanNameAttribute() {
        $plan = $this->account_type;
        if($plan == 0) {
            return 'Free';
        } elseif($plan == 1) {
            return 'Basic';
        } elseif($plan === 2) {
            return 'High School';
        } elseif($plan == 3) {
            return 'College';
        }
    }

    public function getPlayerNumberAttribute() {
        $team_token = $this->team_token;
        $players = User::where('role', 'PLAYER')->orWhere('role', 'STRING')->where('team_token', '=', $team_token)->get();
        $player_number = $players->count();

        if($player_number == null) {
            return '0';
        } else {
            return $player_number;
        }
    }

    public function getLastPaymentAttribute() {
        if(strlen($this->plan_id) > 1) {
            $client = new Client;
            $response = $client->request('GET', 'https://api.sandbox.paypal.com/v1/payments/billing-agreements/'.$this->plan_id, [
                'headers' => [
                    'Authorization' => 'Bearer '.Config::get('paypal.sandbox_token'),
                    'Content-Type' => 'application/json'
                ]
            ]);
            $body = json_decode($response->getBody());
            if($body->agreement_details->cycles_completed > 0) {
                $date_long = $body->agreement_details->last_payment_date;
                $date = substr($date_long, 5, 2).'/'.substr($date_long, 8, 2).'/'.substr($date_long, 0, 4);
                return $date;
            } else {
                $date_long = $body->agreement_details->next_billing_date;
                $date = substr($date_long, 5, 2).'/'.substr($date_long, 8, 2).'/'.substr($date_long, 0, 4);
                return 'None, next on '.$date;
            }
        } else {
            return 'No Payment Plan';
        }
    }

    public function getStringCountAttribute() {
        $string_requests = StringRequest::where('user_id', $this->id)->get();
        $string_count = $string_requests->count();
        if($string_count == null) {
            return 0;
        } else {
            return $string_count;
        }
    }
}
