<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Log;

class Helpers
{
    public static function tryCatchHelper(callable $callback, $defaultReturn = null)
    {
        try {
            return $callback();
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return $defaultReturn ?? ResponseHelper::error('An error occurred', env('APP_ENV') == 'local' ? $e->getMessage() : null, 500);
        }
    }
}
