<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;

class ClearPlanChanges extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clear:planchanges';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clears the plan changes column in the users databse. Should be run once a month.';

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
        $users = User::get();
        foreach($users as $u) {
            $u->plan_changes = null;
            $u->save();
        }
    }
}
