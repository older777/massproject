<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Services\ESService;
use Elastic\Elasticsearch\Client;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    /**
     * Страница магазина
     */
    public function home(Request $request, Client $client): Response|RedirectResponse
    {
        if (! $request->exists('catalog')) {
            return redirect('/?catalog=phones');
        }

        $es = new ESService($request->get('catalog'), $client, $request);
        $es->getData();

        return Inertia::render('Home', [
            'catalog' => $request->get('catalog'),
            'canLogin' => Route::has('login') && Auth::user(),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
            'catalogStats' => $this->catalogStats($es),
            'paging' => $es->paging,
            'products' => $es->getProducts(),
        ]);
    }

    /**
     * Поиск в каталоге
     */
    public function search(Request $request, Client $client): Response
    {
        $es = new ESService('phones,tablets,parts', $client, $request);
        $es->getData();

        return Inertia::render('Home', [
            'catalog' => $request->get('catalog'),
            'search' => $request->get('searching'),
            'canLogin' => Route::has('login') && Auth::user(),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
            'catalogStats' => $this->catalogStats($es),
            'paging' => $es->paging,
            'products' => $es->getProducts(),
        ]);
    }

    /**
     * Страница продукта
     */
    public function product(Request $request, Client $client, Product $product): Response
    {
        $es = new ESService($product->type, $client, $request);
        $es->getData(false);

        return Inertia::render('Home', [
            'catalog' => $product->type,
            'search' => $request->get('searching'),
            'canLogin' => Route::has('login') && Auth::user(),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
            'catalogStats' => $this->catalogStats($es),
            'product' => ProductResource::make($product),
        ]);
    }

    /**
     * Массив агрегаций
     */
    private function catalogStats(ESService $es): array
    {
        return [
            'partsCount' => $es->getPartsCount(),
            'phonesCount' => $es->getPhonesCount(),
            'tabletsCount' => $es->getTabletsCount(),
            'partsBrands' => $es->getPartsBrands(),
            'phonesBrands' => $es->getPhonesBrands(),
            'tabletsBrands' => $es->getTabletsBrands(),
            'partsPrices' => $es->getPartsPrices(),
            'phonesPrices' => $es->getPhonesPrices(),
            'tabletsPrices' => $es->getTabletsPrices(),
        ];
    }
}
