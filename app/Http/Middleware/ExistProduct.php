<?php

namespace App\Http\Middleware;

use App\Services\CacheService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ExistProduct
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $products = CacheService::getProducts();

        $product = $products->firstWhere('id', $request->route()->id);
        if($product == null){
            return response()->json(['success' => false, 'msg' => "Produto não encontrado."], 404);
        }

        $request->attributes->add(['product' => $product]);
        $request->attributes->add(['products' => $products]);

        return $next($request);
    }
}
