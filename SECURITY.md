# Security Policy

## Supported Versions

| Version | Platform | Status | Security fixes until |
| ------- | -------- | ------ | -------------------- |
| 3.x | Laravel 13 · PHP 8.3+ | :white_check_mark: Supported | March 2028 |
| 2.x and earlier | Laravel 12–13 | :x: No longer supported | — |

New features go into the newest line only. When a new line ships, the previous line gets critical bug fixes for 6 more
months and security fixes until the time in the table — never past the security support of the Laravel version it runs on.

S-Cart is built from the packages `gp247/core`, `gp247/front`, `gp247/shop` and `gp247/mcp`, and security fixes ship in
those packages. To check a running site, compare the package versions shown by `php artisan gp247:info` with the
recommended versions, then update with `composer update` and `php artisan gp247:update`.

Recommended versions and how to update: [S-Cart releases and security](https://github.com/gp247net/gp247-docs/blob/main/release/release.md).

## Reporting a Vulnerability

If you discover a security vulnerability within S-Cart or GP247, please email **support@gp247.net**. Do not open a public
GitHub issue, so the problem is not exposed before a fix is released. All security vulnerabilities will be promptly addressed.
