<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\CheckMissionDailyJob;
use App\Jobs\CheckExpiredMissionJob;
use App\Jobs\ChangeStatusCompletedProjectJob;

class DailyCheckMissionCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'daily-check-mission-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        dispatch(new CheckExpiredMissionJob());
        dispatch(new CheckMissionDailyJob());
        dispatch(new ChangeStatusCompletedProjectJob());
    }
}
