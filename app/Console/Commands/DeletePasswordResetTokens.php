<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\PasswordReset;
use Carbon\Carbon;

class DeletePasswordResetTokens extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'DeletePassword:ResetTokens';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deletes all password reset tokens at a given interval.';

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
        $resets = PasswordReset::get();
        $time_now = Carbon::now()->subMinutes(10);
        foreach($resets as $r) {
            if($r->created_at <= $time_now) {
                $r->delete();
            }
        }
    }
}
