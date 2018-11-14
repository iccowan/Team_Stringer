<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;
use Artisan;
use Config;

class PayPalTokenUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'paypal:tokenupdate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates the paypal sandbox and live tokens.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $path_sandbox = base_path('.env');
        $path_live = base_path('.env');

        //Sandbox Token
        $client_sandbox = new Client;
        $response_sandbox = $client_sandbox->request('POST', 'https://api.sandbox.paypal.com/v1/oauth2/token', [
            'auth' => [Config::get('paypal.sandbox_client_id'), Config::get('paypal.sandbox_secret')],
            'form_params' => [
                'grant_type' => 'client_credentials',
            ]
        ]);

        $r_sandbox = json_decode($response_sandbox->getBody());
        $token_sandbox = $r_sandbox->access_token;

        $old_sandbox = Config::get('paypal.sandbox_token');

        file_put_contents($path_sandbox, str_replace(
            'SANDBOX_PAYPAL_TOKEN='.$old_sandbox, 'SANDBOX_PAYPAL_TOKEN='.$token_sandbox, file_get_contents($path_sandbox)
        ));

        //Live Token
        $client_live = new Client;
        $response_live = $client_live->request('POST', 'https://api.paypal.com/v1/oauth2/token', [
            'auth' => [Config::get('paypal.client_id'), Config::get('paypal.secret')],
            'form_params' => [
                'grant_type' => 'client_credentials',
            ]
        ]);

        $r_live = json_decode($response_live->getBody());
        $token_live = $r_live->access_token;

        $old_live = Config::get('paypal.token');

        file_put_contents($path_live, str_replace(
            'LIVE_PAYPAL_TOKEN='.$old_live, 'LIVE_PAYPAL_TOKEN='.$token_live, file_get_contents($path_live)
        ));

        Artisan::call('config:cache');
    }
}
