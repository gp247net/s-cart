<?php

use App\Providers\AppServiceProvider;

return [
    AppServiceProvider::class,

    //Need to register all GP247 service providers here, load after GP247/core
    GP247\Front\FrontServiceProvider::class,
    GP247\Shop\ShopServiceProvider::class,
];
