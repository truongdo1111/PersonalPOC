<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class ExampleController extends Controller
{
    public function withCache()
    {
        $cacheKey = 'test_all_users';
        $startTime = microtime(true);

        $hasCache = $this->hasCache($cacheKey);

        $users = Cache::remember($cacheKey, Carbon::now()->addMinutes(5), function () {
            return User::all(['name', 'email'])->toBase();
        });

        if (is_string($users)) {
            $users = json_decode($users, true);
        } else {
            $users = $users->toArray();
        }

        $endTime = microtime(true);

        return view('welcome', [
            'execute_time' => $endTime - $startTime,
            'users' => $users,
            'has_cache' => $hasCache,
        ]);
    }

    public function withoutCache()
    {
        $startTime = microtime(true);

        $users = User::all(['name', 'email'])->toArray();
        $endTime = microtime(true);

        return view('welcome', [
            'execute_time' => $endTime - $startTime,
            'users' => $users,
            'has_cache' => false,
        ]);
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
