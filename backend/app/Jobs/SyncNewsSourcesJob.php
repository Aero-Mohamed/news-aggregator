<?php

namespace App\Jobs;

use App\Services\NewsApiService\Contracts\NewsSourceInterface;
use App\Services\NewsApiService\NewsApiService;
use App\Services\NewsApiService\Strategies\NewsApiStrategy;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Throwable;

class SyncNewsSourcesJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public int $tries = 3;
    public int $timeout = 120;
    public string $strategyClass;

    /**
     * Create a new job instance.
     */
    public function __construct(
        string $strategyClass
    ) {
        $this->strategyClass = $strategyClass;
    }

    /**
     * Execute the job.
     * @throws Throwable
     */
    public function handle(): void
    {
        try {
            /** @var NewsSourceInterface $strategy */
            $strategy = app($this->strategyClass);
            $client = new NewsApiService($strategy);
            $client->sync();
        } catch (Throwable $e) {
            if (isset($strategy)) {
                Log::error('News sync failed for source ' . get_class($strategy), [
                    'error' => $e->getMessage(),
                ]);
            }

            throw $e;
        }
    }
}
