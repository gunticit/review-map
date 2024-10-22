<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MakeMigrationAll extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:make-migration-all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Chạy các migrations trong tất cả module';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $migrations = $this->getMigrations();
        if(!empty($migrations)){
            foreach ($migrations as $migration) {
                Artisan::call('migrate', ['--path' => $migration]);
            }
        }
    }
}
