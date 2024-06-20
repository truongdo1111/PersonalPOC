<?php

namespace App\Contracts;

trait Cacheable
{
    protected ?string $cacheKey;

    /**
     * Expiration of cache in seconds
     *
     * @var int|null
     */
    protected ?int $cacheExpiryTime;

    /**
     * @return Collection
     */
    protected function getDataFromCache(): Collection
    {
        if (! $this->hasCache()) {
            return collect([]);
        }

        /**
         * @var array<string, mixed> $data
         */
        $data = json_decode(Cache::get($this->cacheKey), true);

        return collect($data);
    }

    /**
     * @param Collection $data
     * @return void
     */
    protected function writeCache(Collection $data): void
    {
        if (is_null($this->cacheKey)) {
            return;
        }

        try {
            Cache::put(
                $this->cacheKey,
                json_encode($data->toArray()),
                Carbon::now()->addSeconds(
                    $this->cacheExpiryTime ?? config('scout.cache_lifetime.common', 60 * 60)
                )
            );
        } catch (Exception $exception) {
            Log::info('[Data cached] failure on caching data to key '.$this->cacheKey);
            report($exception);
        }
    }

    /**
     * @return bool
     */
    protected function hasCache(): bool
    {
        if (is_null($this->cacheKey)) {
            return false;
        }

        return Cache::has($this->cacheKey);
    }

    /**
     * @return void
     */
    protected function invalidCache(): void
    {
        try {
            Cache::forget($this->cacheKey);
        } catch (Exception $e) {
            Log::info('[Invalid cache failed] failure on invalid caching data to key '.$this->cacheKey);
            report($e);
        }
    }
}
