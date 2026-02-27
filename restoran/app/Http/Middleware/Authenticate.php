<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Determine where to redirect the user if authentication fails.
     */
    protected function redirectTo(Request $request): ?string
    {
        /**
         * JIKA REQUEST API ATAU TIDAK MINTA HTML
         * JANGAN REDIRECT KE MANA-MANA
         */
        if (
            $request->expectsJson() ||
            $request->is('api/*')
        ) {
            return null;
        }

        /**
         * OPTIONAL:
         * kalau kamu memang punya halaman login blade
         * kalau TIDAK → return null juga
         */
        return null;
    }
}
