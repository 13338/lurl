<?php

namespace App\Console\Commands;

use App\Link;
use Carbon\Carbon;
use Illuminate\Console\Command;

class LinkClear extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'link:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear expired links';

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
        Link::where('expired_at', '<', Carbon::now())
            ->whereNotNull('expired_at')
            ->delete();
    }
}
