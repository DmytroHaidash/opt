<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;
use Session;

class HandleUserLocale
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $locale = Session::get('locale');

        if (!$locale) {
            $available = collect(
                preg_split('/,|;/', $request->server('HTTP_ACCEPT_LANGUAGE'))
            )->filter(function ($locale) {
                return in_array($locale, config('translatable.locales'));
            });

            $locale = $available->count() ? $available->first() : 'uk';
            Session::put('locale', $locale);
        }

        app()->setLocale($locale);

        if ($locale === 'ru') {
            setlocale(LC_TIME, 'ru_RU.utf-8');
        } elseif (app()->getLocale() === 'uk') {
            setlocale(LC_TIME, 'uk_UA.utf-8');
        }

        return $next($request);
    }
}
