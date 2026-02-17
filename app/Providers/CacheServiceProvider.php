<?php


declare(strict_types=1);

namespace App\Providers;

use App\Services\PresentationRedisService;

use App\Services\V1\Presentation\PresentationServiceInterface as PresentationServiceInterfaceV1;
use App\Services\V1\Presentation\PresentationService as PresentationServiceV1;

use App\Services\V2\Presentation\PresentationServiceInterface as PresentationServiceInterfaceV2;
use App\Services\V2\Presentation\PresentationService as PresentationServiceV2;

use Illuminate\Support\ServiceProvider;


class CacheServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        if ($this->getConfig()) {
            $this->app->bind(PresentationServiceInterface::class, PresentationRedisService::class);
        } else {
            $appVersion = config('app.version');

            match ($appVersion) {
                'v1' => $this->app->bind(PresentationServiceInterfaceV1::class, PresentationServiceV1::class),
                'v2' => $this->app->bind(PresentationServiceInterfaceV2::class, PresentationServiceV2::class),
            };

        }
    }

    /**
     * @return bool
     */
    public function getConfig(): bool
    {
        return 'redis' === config('cache.default');
    }

}
