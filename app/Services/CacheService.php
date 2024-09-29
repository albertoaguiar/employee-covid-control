<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;

/**
 * Class CacheService
 *
 * Service for managing caches.
 *
 * @author Alberto Aguiar Neto
 * @since 09/2024
 * 
 */
class CacheService
{

    /**
     * Save cache
     */
    public function cacheData(string $cacheKey, callable $callback, int $duration = 60)
    {
        return Cache::remember($cacheKey, $duration, $callback);
    }

    /**
     * Save cache of keys cache
     */
    public function storeCacheKey(string $cacheKey)
    {
        $existingKeys = Cache::get('vaccine_cache_keys', []);
        if (!is_array($existingKeys)) {
            $existingKeys = [];
        }
        $existingKeys[] = $cacheKey;
        Cache::put('vaccine_cache_keys', $existingKeys);
    }

    /**
     * clear cache
     */
    public function clearCache()
    {
        $keys = Cache::get('vaccine_cache_keys', []);
        if (is_array($keys)) {
            foreach ($keys as $key) {
                Cache::forget($key);
            }
            Cache::forget('vaccine_cache_keys');
        }
    }
}
