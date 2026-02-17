<?php


declare(strict_types=1);


namespace App\Services\Redis;

use App\Enums\RedisCacheChannelsEnum;
use App\Http\Resources\PresentationCollection;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Throwable;

class RedisCacheService
{
    public static function channelCleaning(string $channel): void
    {
        try {
            if (!in_array($channel, RedisCacheChannelsEnum::REDIS_CACHE_CHANNELS_LIST)) {
                throw new Exception('Unknown channel');
            }

            $client = Redis::connection()->client();
            $client->del($channel);
        } catch (Exception | Throwable $e) {
            Log::error($e->getMessage());
            dump($e);
        }
    }

    public static function channelReceiving(string $channel): Collection
    {
        try {

            if (!in_array($channel, RedisCacheChannelsEnum::REDIS_CACHE_CHANNELS_LIST)) {
                throw new Exception('Unknown channel');
            }

            $client = Redis::connection()->client();
            $isExistChannel = $client->exists($channel);

            if ($isExistChannel) {
                $collection = collect(json_decode($client->get($channel)));
            }

        } catch (Exception | Throwable $e) {
            Log::error($e->getMessage());
            dump($e);
        }

        return $collection ?? new Collection();
    }

    public static function channelRecording(string $channel, $query): void
    {
        try {

            $client = Redis::connection()->client();
            $client->set($channel, json_encode(new PresentationCollection($query)));

        } catch (Exception | Throwable $e) {
            Log::error($e->getMessage());
            dump($e);
        }
    }
}
