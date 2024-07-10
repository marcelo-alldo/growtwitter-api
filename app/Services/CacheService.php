<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;

class CacheService
{
    static public function  getProducts() {
        $productsCache = Cache::get('products');
        $productsCollect = collect([]);

        if($productsCache !== null){
            $productsCollect = collect(json_decode($productsCache));
        }

        return $productsCollect;
    }

    static public function updateProducts($products){
        Cache::put('products', $products->toJson());
    }

}
