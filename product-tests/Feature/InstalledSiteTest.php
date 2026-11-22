<?php

namespace ProductTests\Feature;

use GP247\Shop\Models\ShopProduct;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Artisan;
use ProductTests\ProductTestCase;

/**
 * An installed (or upgraded) S-Cart works: the main pages open, the health check has
 * no failure and the four platform packages are present.
 *
 * Runs after `php artisan gp247:install --force=1 --sample` (clean install), and again
 * after `composer update` + `php artisan gp247:update` from the previous release.
 *
 * @aidlc-unit installer-deploy
 * @aidlc-story US-DEP-product-install-ci
 */
class InstalledSiteTest extends ProductTestCase
{
    use DatabaseTransactions;

    public function test_the_storefront_home_page_opens(): void
    {
        $this->get('/')->assertOk();
    }

    public function test_a_sample_product_page_opens(): void
    {
        $product = ShopProduct::query()->where('status', 1)->first();
        $this->assertNotNull($product, 'the sample catalogue has an active product');

        $this->get($product->getUrl())->assertOk();
    }

    public function test_the_cart_page_opens(): void
    {
        $this->get(route('cart'))->assertOk();
    }

    public function test_the_admin_sign_in_page_opens(): void
    {
        $this->get(route('admin.login'))->assertOk();
    }

    public function test_the_health_check_reports_no_failure(): void
    {
        $this->assertSame(0, Artisan::call('gp247:doctor', ['--json' => true]));
        $report = json_decode(Artisan::output(), true);

        $this->assertTrue($report['ok'] ?? false, 'gp247:doctor answered ok');
        $failed = array_filter($report['data']['checks'] ?? [], fn (array $check) => ($check['status'] ?? null) === 'fail');
        $this->assertSame([], array_values($failed), 'no health check fails');
    }

    public function test_the_site_reports_the_four_platform_packages(): void
    {
        $this->assertSame(0, Artisan::call('gp247:info', ['--json' => true]));
        $info = json_decode(Artisan::output(), true);

        $this->assertTrue($info['data']['installed'] ?? false);
        foreach (['gp247/core', 'gp247/front', 'gp247/shop', 'gp247/mcp'] as $package) {
            $this->assertArrayHasKey($package, $info['data']['versions'] ?? [], "$package is reported");
            // WHY not null: the JSON output reports a package that is not installed as null.
            $this->assertNotNull($info['data']['versions'][$package], "$package is installed");
        }
    }
}
