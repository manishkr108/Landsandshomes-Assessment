<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\StoreDetails;

class DeleteOldRecords extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'records:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete records older than 2 days';// for testing purpose i am given 2 day

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
     * @return int
     */
    public function handle()
    {
        $twoDaysAgo = Carbon::now()->subDays(1);

        StoreDetails::where('created_at', '<', $twoDaysAgo)->delete();

        $this->info('Old records deleted successfully.');
    }
}
