<?php

/*
| Proxies whose X-Forwarded-* headers the app trusts, so URLs generate as
| https:// and $request->ip() returns the real client IP behind a reverse
| proxy. Read at request time by Illuminate\Http\Middleware\TrustProxies
| (its config fallback), so it works under `artisan config:cache` - which
| is also why this is NOT set in bootstrap/app.php: that closure runs
| before the env/config bootstrappers, where env()/config() silently
| return null for .env values.
|
| TRUSTED_PROXIES values:
|   (unset)  trust nothing - correct for a bare host install where
|            Nginx/Apache talks to php-fpm directly over FastCGI (client
|            IP and HTTPS flag arrive natively, no proxy hop to trust).
|            Trusting more here would let clients spoof X-Forwarded-*.
|   *        trust the directly-connecting peer - set automatically by
|            docker-compose*.yml (safe there: the app container has no
|            published port and is only reachable by the internal
|            webserver container, whose bridge IP is dynamic).
|   ip,cidr  comma-separated list, for a host install that DOES sit
|            behind an HTTP proxy hop (e.g. 127.0.0.1 for a local
|            proxy_pass, or Cloudflare's ranges) - add it to that
|            server's .env.
|
| @see https://laravel.com/docs/13.x/requests#configuring-trusted-proxies
*/

return [

    // '' would be passed through to Symfony as a proxy IP; normalize to
    // null so the middleware's "nothing to trust" path applies instead.
    'proxies' => env('TRUSTED_PROXIES') ?: null,

];
