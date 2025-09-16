<?php

namespace Database\Seeders;

use Elastic\Elasticsearch\Client;
use Illuminate\Database\Seeder;
use Illuminate\Http\Response;

class ElasticIndexSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Client $client): void
    {
        $response = $client
            ->setResponseException(false)
            ->indices()
            ->get(['index' => 'phones-000001'])
            ->asObject();

        if ($response->status == Response::HTTP_NOT_FOUND) {
            $client->setResponseException(true);
            $params = [
                'index' => 'phones-000001',
                'body' => [
                    'mappings' => [
                        'properties' => [
                            'id' => [
                                'type' => 'long',
                            ],
                            'price' => [
                                'type' => 'float',
                            ],
                            'published' => [
                                'type' => 'boolean',
                            ],
                            'created_at' => [
                                'type' => 'date',
                            ],
                            'updated_at' => [
                                'type' => 'date',
                            ],
                            'name' => [
                                'type' => 'text',
                                'fields' => [
                                    'keyword' => [
                                        'type' => 'keyword',
                                        'ignore_above' => 256,
                                    ],
                                ],
                            ],
                            'model' => [
                                'type' => 'text',
                                'fields' => [
                                    'keyword' => [
                                        'type' => 'keyword',
                                        'ignore_above' => 256,
                                    ],
                                ],
                            ],
                            'color' => [
                                'type' => 'text',
                                'fields' => [
                                    'keyword' => [
                                        'type' => 'keyword',
                                        'ignore_above' => 256,
                                    ],
                                ],
                            ],
                            'processor' => [
                                'type' => 'text',
                                'fields' => [
                                    'keyword' => [
                                        'type' => 'keyword',
                                        'ignore_above' => 256,
                                    ],
                                ],
                            ],
                            'ram' => [
                                'type' => 'integer',
                            ],
                            'storage' => [
                                'type' => 'integer',
                            ],
                            'display_size' => [
                                'type' => 'float',
                            ],
                            'description' => [
                                'type' => 'text',
                                'fields' => [
                                    'keyword' => [
                                        'type' => 'keyword',
                                        'ignore_above' => 256,
                                    ],
                                ],
                            ],
                        ],
                    ],
                    'aliases' => [
                        'phones' => new \stdClass,
                    ],
                    'settings' => [
                        'index.number_of_shards' => 3,
                        'index.number_of_replicas' => '0',
                    ],
                ],
            ];
            $client->indices()->create($params);
        }

        $response = $client
            ->setResponseException(false)
            ->indices()
            ->get(['index' => 'tablets-000001'])
            ->asObject();

        if ($response->status == Response::HTTP_NOT_FOUND) {
            $client->setResponseException(true);
            $params = [
                'index' => 'tablets-000001',
                'body' => [
                    'mappings' => [
                        'properties' => [
                            'id' => [
                                'type' => 'long',
                            ],
                            'price' => [
                                'type' => 'float',
                            ],
                            'published' => [
                                'type' => 'boolean',
                            ],
                            'created_at' => [
                                'type' => 'date',
                            ],
                            'updated_at' => [
                                'type' => 'date',
                            ],
                            'name' => [
                                'type' => 'text',
                                'fields' => [
                                    'keyword' => [
                                        'type' => 'keyword',
                                        'ignore_above' => 256,
                                    ],
                                ],
                            ],
                            'model' => [
                                'type' => 'text',
                                'fields' => [
                                    'keyword' => [
                                        'type' => 'keyword',
                                        'ignore_above' => 256,
                                    ],
                                ],
                            ],
                            'color' => [
                                'type' => 'text',
                                'fields' => [
                                    'keyword' => [
                                        'type' => 'keyword',
                                        'ignore_above' => 256,
                                    ],
                                ],
                            ],
                            'processor' => [
                                'type' => 'text',
                                'fields' => [
                                    'keyword' => [
                                        'type' => 'keyword',
                                        'ignore_above' => 256,
                                    ],
                                ],
                            ],
                            'ram' => [
                                'type' => 'integer',
                            ],
                            'storage' => [
                                'type' => 'integer',
                            ],
                            'display_size' => [
                                'type' => 'float',
                            ],
                            'description' => [
                                'type' => 'text',
                                'fields' => [
                                    'keyword' => [
                                        'type' => 'keyword',
                                        'ignore_above' => 256,
                                    ],
                                ],
                            ],
                        ],
                    ],
                    'aliases' => [
                        'tablets' => new \stdClass,
                    ],
                    'settings' => [
                        'index.number_of_shards' => 3,
                        'index.number_of_replicas' => '0',
                    ],
                ],
            ];
            $client->indices()->create($params);
        }

        $response = $client
            ->setResponseException(false)
            ->indices()
            ->get(['index' => 'parts-000001'])
            ->asObject();

        if ($response->status == Response::HTTP_NOT_FOUND) {
            $client->setResponseException(true);
            $params = [
                'index' => 'parts-000001',
                'body' => [
                    'mappings' => [
                        'properties' => [
                            'id' => [
                                'type' => 'long',
                            ],
                            'price' => [
                                'type' => 'float',
                            ],
                            'published' => [
                                'type' => 'boolean',
                            ],
                            'created_at' => [
                                'type' => 'date',
                            ],
                            'updated_at' => [
                                'type' => 'date',
                            ],
                            'name' => [
                                'type' => 'text',
                                'fields' => [
                                    'keyword' => [
                                        'type' => 'keyword',
                                        'ignore_above' => 256,
                                    ],
                                ],
                            ],
                            'model' => [
                                'type' => 'text',
                                'fields' => [
                                    'keyword' => [
                                        'type' => 'keyword',
                                        'ignore_above' => 256,
                                    ],
                                ],
                            ],
                            'color' => [
                                'type' => 'text',
                                'fields' => [
                                    'keyword' => [
                                        'type' => 'keyword',
                                        'ignore_above' => 256,
                                    ],
                                ],
                            ],
                            'size' => [
                                'type' => 'text',
                                'fields' => [
                                    'keyword' => [
                                        'type' => 'keyword',
                                        'ignore_above' => 256,
                                    ],
                                ],
                            ],
                            'weight' => [
                                'type' => 'float',
                            ],
                            'description' => [
                                'type' => 'text',
                                'fields' => [
                                    'keyword' => [
                                        'type' => 'keyword',
                                        'ignore_above' => 256,
                                    ],
                                ],
                            ],
                        ],
                    ],
                    'aliases' => [
                        'parts' => new \stdClass,
                    ],
                    'settings' => [
                        'index.number_of_shards' => 3,
                        'index.number_of_replicas' => '0',
                    ],
                ],
            ];
            $client->indices()->create($params);
        }
    }
}
