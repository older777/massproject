<?php

namespace App\Services;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Elastic\Elasticsearch\Client;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;

final class ESService
{
    protected $products;

    protected $type;

    protected $client;

    protected $request;

    protected $phonesCount = 0;

    protected $tabletsCount = 0;

    protected $partsCount = 0;

    protected $phonesBrands;

    protected $tabletsBrands;

    protected $partsBrands;

    protected $phonesPrices = [];

    protected $tabletsPrices = [];

    protected $partsPrices = [];

    public $paging = null;

    /**
     * Сервис для ElasticSearch
     */
    public function __construct(?string $type, Client $client, Request $request)
    {
        $this->type = $type;
        $this->client = $client;
        $this->request = $request;
    }

    /**
     * Агрегации и фильтры
     */
    public function getData(?bool $search = true): void
    {
        $this->getAggregations();
        if (! $search) {
            return;
        }
        if ($this->request->has('page')) {
            $page = $this->request->get('page') - 1;
        } else {
            $page = 0;
        }
        $this->getSearchResults($page);
    }

    /**
     * Кол-во телефонов
     */
    public function getPhonesCount(): int
    {
        return $this->phonesCount;
    }

    /**
     * Кол-во планшетов
     */
    public function getTabletsCount(): int
    {
        return $this->tabletsCount;
    }

    /**
     * Кол-во аксессуаров
     */
    public function getPartsCount(): int
    {
        return $this->partsCount;
    }

    /**
     * Бренды аксессуаров
     */
    public function getPartsBrands(): ?array
    {
        return $this->partsBrands;
    }

    /**
     * Бренды телефонов
     */
    public function getPhonesBrands(): ?array
    {
        return $this->phonesBrands;
    }

    /**
     * Бренды планшетов
     */
    public function getTabletsBrands(): ?array
    {
        return $this->tabletsBrands;
    }

    /**
     * Цены аксессуаров
     */
    public function getPartsPrices(): ?array
    {
        return $this->partsPrices;
    }

    /**
     * Цены телефонов
     */
    public function getPhonesPrices(): ?array
    {
        return $this->phonesPrices;
    }

    /**
     * Цены планшетов
     */
    public function getTabletsPrices(): ?array
    {
        return $this->tabletsPrices;
    }

    /**
     * Продукты
     */
    public function getProducts(): ?JsonResource
    {
        return $this->products;
    }

    /**
     * Агрегация кол-во продукции
     */
    public function getAggregations(): void
    {
        $params = [
            'index' => 'phones,tablets,parts',
            'body' => [
                'query' => [
                    'match' => [
                        'published' => 'true',
                    ],
                ],
                'size' => 0,
                'aggs' => [
                    'total_by_type' => [
                        'terms' => [
                            'field' => 'type',
                        ],
                        'aggs' => [
                            'brands' => [
                                'terms' => [
                                    'field' => 'name.keyword',
                                ],
                            ],
                            'price_max' => [
                                'max' => [
                                    'field' => 'price',
                                ],
                            ],
                            'price_min' => [
                                'min' => [
                                    'field' => 'price',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];
        if ($this->type) {

        }
        $result = $this->client->search($params);
        if ($result->getStatusCode() == Response::HTTP_OK) {
            $json = $result->asObject();
            foreach ($json->aggregations->total_by_type->buckets as $bucket) {
                if ($bucket->key == 'phones') {
                    $this->phonesCount = $bucket->doc_count;
                    $this->phonesPrices = ['price_max' => $bucket->price_max->value,
                        'price_min' => $bucket->price_min->value];
                    $this->phonesBrands = $bucket->brands->buckets;
                } elseif ($bucket->key == 'tablets') {
                    $this->tabletsCount = $bucket->doc_count;
                    $this->tabletsPrices = ['price_max' => $bucket->price_max->value,
                        'price_min' => $bucket->price_min->value];
                    $this->tabletsBrands = $bucket->brands->buckets;
                } elseif ($bucket->key == 'parts') {
                    $this->partsCount = $bucket->doc_count;
                    $this->partsPrices = ['price_max' => $bucket->price_max->value,
                        'price_min' => $bucket->price_min->value];
                    $this->partsBrands = $bucket->brands->buckets;
                }
            }
        }
    }

    /**
     * Фильтр продукции
     */
    public function getSearchResults(?int $page = 0): void
    {
        $params = [
            'index' => $this->type,
            'body' => [
                '_source' => 'false',
                'query' => [
                    'bool' => [
                        'must' => [
                            [
                                'match' => [
                                    'published' => 'true',
                                ],
                            ],
                        ],
                    ],
                ],
                'size' => env('ELASTICSEARTCH_PAGE', 5),
                'from' => ($page * env('ELASTICSEARTCH_PAGE')),
                'sort' => [
                    'id' => [
                        'order' => 'asc',
                    ],
                ],
            ],
        ];
        if ($this->request->route()->getName() == 'search' && $this->request->has('searching')) {
            $params['body']['query']['bool']['must'][]['multi_match'] = [
                'query' => $this->request->get('searching'),
                'type' => 'phrase_prefix',
                'fields' => [
                    'name', 'model', 'description', 'processor',
                ],
            ];
        }
        if ($this->request->get('filters')) {
            $filters = [];
        }
        $this->products = collect([]);
        $result = $this->client->search($params);
        if ($result->getStatusCode() == Response::HTTP_OK) {
            $json = $result->asObject();
            if (isset($json->hits->hits) && count($json->hits->hits)) {
                $ids = [];
                foreach ($json->hits->hits as $item) {
                    array_push($ids, $item->{'_id'});
                }
                $this->products = Product::whereIn('id', $ids)
                    ->when($this->type == 'phones', function ($query) {
                        $query->with('phone');
                    })
                    ->when($this->type == 'tablets', function ($query) {
                        $query->with('tablet');
                    })
                    ->when($this->type == 'parts', function ($query) {
                        $query->with('part');
                    })
                    ->get();
                $this->getPaging($page, $json->hits->total->value);
            }
        }

        $this->products = ProductResource::collection($this->products);
    }

    /**
     * Пейджинг результатов
     */
    public function getPaging(int $page, int $total): void
    {
        $url = $this->request->route()->uri();
        if ($url[0] != '/') {
            $url = '/'.$url;
        }
        $request = $this->request->all();
        $perPage = env('ELASTICSEARTCH_PAGE', 5);
        $paging = [];
        if ($total) {
            $request['page'] = 1;
            $paging['first_page'] = [
                'label' => 'Первая страница',
                'num' => 1,
                'url' => $url.'?'.http_build_query($request),
                'active' => $page == 0 ? true : false,
            ];
            if ($total > $perPage) {
                $lastPage = floor($total / $perPage);
                $request['page'] = $lastPage;
                $paging['last_page'] = [
                    'label' => 'Последняя страница',
                    'num' => $lastPage,
                    'url' => $url.'?'.http_build_query($request),
                    'active' => $page == $lastPage - 1 ? true : false,
                ];
            }
            if ($total > $perPage * 2) {
                for ($i = 2; $i < floor($total / $perPage); $i++) {
                    $request['page'] = $i;
                    $paging['pages'][] = [
                        'label' => $i,
                        'num' => $i,
                        'url' => $url.'?'.http_build_query($request),
                        'active' => $page == $i - 1 ? true : false,
                    ];
                }
            }
        }
        $this->paging = $paging;
    }
}
