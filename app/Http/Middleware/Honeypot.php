<?php

namespace App\Http\Middleware;

use Closure;

class Honeypot
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request  $request
     * @param \Closure  $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $config = config('for-sale.honeypot');

        if (! $config['enabled']) {
            return $next($request);
        }

        if (! $request->has($config['decoy_field'])) {
            return $this->abort();
        }

        if (! empty($request->input($config['decoy_field']))) {
            return $this->abort();
        }

        if ($this->submissionSpeed($request) <= $config['min_time']) {
            return $this->abort();
        }

        return $next($request);
    }

    /**
     * Check how quickly the form was submitted.
     *
     * @param Request $request
     *
     * @return int
     */
    protected function submissionSpeed($request)
    {
        return microtime(true) - $request->input(config('for-sale.honeypot.timestamp_field'));
    }

    /**
     * Stop request execution when spam is detected.
     *
     * @return \Symfony\Component\HttpKernel\Exception\HttpException
     */
    protected function abort()
    {
        return abort(404);
    }
}
