<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CommandClearCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:ClearCacheAll';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Đang xóa cache';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->call('route:cache');
        $this->call('config:cache');
        $this->call('view:clear');
        $this->call('cache:clear');
        $this->call('storage:link');
        $this->info('Đã xóa cache thành công');
    }
}
