<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RemoveWwwMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        if ($this->shouldRedirect($request)) {
            $url = $request->url();
            $newUrl = $this->removeWww($url);
            return redirect()->to($newUrl, 301);
        }

        return $next($request);
    }

    protected function shouldRedirect($request)
    {
        return Str::startsWith($request->url(), 'https://www.');
    }

    protected function removeWww($url)
    {
        return Str::replaceFirst('https://www.', 'https://', $url);
    }
}
