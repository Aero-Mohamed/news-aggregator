<?php

namespace App\Console\Commands;

use App\Jobs\SyncNewsSourcesJob;
use App\Services\NewsApiService\Strategies\GuardianStrategy;
use App\Services\NewsApiService\Strategies\NewsApiStrategy;
use App\Services\NewsApiService\Strategies\NYTimesStrategy;
use Illuminate\Console\Command;

class NewsSyncCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:news-sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run an initial news sync';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $sources = [
            NewsApiStrategy::class,
            GuardianStrategy::class,
            NYTimesStrategy::class,
        ];

        foreach ($sources as $strategy) {
            SyncNewsSourcesJob::dispatch($strategy);
        }
    }
}
