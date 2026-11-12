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
|   (unset)  trust nothing - the default, also in docker-compose*.yml.
|            Correct whenever nothing sits in front of the web server:
|            the client IP and HTTPS flag arrive natively over FastCGI.
|   ip,cidr  comma-separated ranges of EVERY proxy that sits in front, in
|            one value: Cloudflare / load-balancer ranges, 127.0.0.1 for a
|            local proxy_pass on a bare host, or 172.16.0.0/12 for nginx /
|            Caddy / Traefik on the same host in front of Docker (then
|            also bind the port: SC_DOCKER_APP_PORT=127.0.0.1:8000).
|            Several hops (Cloudflare -> host nginx -> Docker) need all of
|            them: X-Forwarded-* is read only when the direct peer is
|            listed, so a missing hop turns every URL into http:// (the
|            System alerts page and gp247:doctor report it).
|   REMOTE_ADDR, *, 0.0.0.0/0 - never: over FastCGI REMOTE_ADDR is the
|            visitor's own address (the bundled nginx passes $remote_addr),
|            so these trust every visitor and let anyone fake their IP and
|            scheme through X-Forwarded-*. The System alerts page and
|            `php artisan gp247:doctor` warn about them (check
|            trusted_proxies).
|
| Whatever is listed, gp247/core never trusts X-Forwarded-Host or
| X-Forwarded-Prefix: generated URLs take their host from the real Host
| header, so the proxy in front must keep it (nginx: proxy_set_header
| Host $host;).
|
| @see https://laravel.com/docs/13.x/requests#configuring-trusted-proxies
*/

return [

    // '' would be passed through to Symfony as a proxy IP; normalize to
    // null so the middleware's "nothing to trust" path applies instead.
    'proxies' => env('TRUSTED_PROXIES') ?: null,

];
