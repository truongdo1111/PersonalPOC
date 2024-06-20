<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class ExampleController extends Controller
{
    public function index()
    {
        $cacheKey = 'test_all_users';
        $startTime = microtime(true);

        $hasCache = $this->hasCache($cacheKey);

        if ($hasCache) {
            $users = $this->getDataFromCache($cacheKey);
        } else {
            $users = User::all(['name', 'email'])->toBase();
            $this->writeCache($cacheKey, $users);
        }

        $users = $users->toArray();
        $endTime = microtime(true);

        return view('welcome', [
            'execute_time' => $endTime - $startTime,
            'users' => $users,
            'has_cache' => $hasCache,
        ]);
    }

    /**
     * @param $cacheKey
     * @return Collection
     */
    protected function getDataFromCache($cacheKey): Collection
    {
        if (! $this->hasCache($cacheKey)) {
            return collect([]);
        }

        /**
         * @var array<string, mixed> $data
         */
        $data = json_decode(Cache::get($cacheKey), true);

        return collect($data);
    }

    /**
     * @param $cacheKey
     * @param Collection $data
     * @param null $expiryTime
     * @return void
     */
    protected function writeCache($cacheKey, Collection $data, $expiryTime = null): void
    {
        try {
            Cache::put(
                $cacheKey,
                json_encode($data->toArray()),
                Carbon::now()->addSeconds(
                    $expiryTime ?? config('app.cache_lifetime.common', 60 * 60)
                )
            );
        } catch (Exception $exception) {
            Log::info('[Data cached] failure on caching data to key '.$cacheKey);
            report($exception);
        }
    }

    /**
     * @param $cacheKey
     * @return bool
     */
    protected function hasCache($cacheKey): bool
    {
        return Cache::has($cacheKey);
    }
}
