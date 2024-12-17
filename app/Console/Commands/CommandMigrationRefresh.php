<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CommandMigrationRefresh extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:MigrationRefresh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Chạy lại migrations';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Chạy lại migrations');
        $this->call('migrate:refresh');
        $this->call('route:cache');
        $this->call('db:seed');
        $this->info('Đã chạy xong!');
    }
}
