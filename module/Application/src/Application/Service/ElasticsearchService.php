<?php
namespace Application\Service;

class ElasticsearchService
{

    private $client;

    private $product;

    public function __construct()
    {
        $this->client = \Elasticsearch\ClientBuilder::create()->setHosts([
            '149.210.204.168:9200'
        ])->build();
    }

    public function mapping()
    {
        $params = [
            'index' => 'productsearch',
            'body' => [
                'mappings' => [
                    'product' => [
                        '_source' => [
                            'enabled' => true
                        ],
                        'properties' => [
                            'suggest' => [
                                'type' => 'completion',
                                'analyzer' => 'standard'
                            ],
                            'name' => [
                                'type' => 'keyword'
                            ],
                            'ean' => [
                                'type' => 'long'
                            ],
                            'price' => [
                                'type' => 'scaled_float',
                                'scaling_factor' => 100
                            ]
                        ]
                    ]
                ]
            ]
        ];
        
        if (! $this->client->indices()->exists([
            'index' => 'productsearch'
        ])) {
            $this->client->indices()->create($params);
        } else {
            $this->client->indices()->putMapping($params);
        }
    }

    public function document($product)
    {
        return [
            'suggest' => [
                'input' => [
                    (string) $this->product->getId(),
                    $this->product->getName()
                ]
            ],
            'name' => $this->product->getName(),
            'ean' => (int) $this->product->getEan(),
            'price' => $this->product->getPrice(),
        ];
    }

    public function createDocument()
    {
        if ($this->product == null) {
            throw new \Exception('Product entity cannot be null.');
        }
        
        $document = [
            'index' => 'productsearch',
            'type' => 'product',
            'id' => $this->product->getId(),
            'body' => $this->document($this->product)
        ];
        
        $this->client->index($document);
    }

    public function editDocument()
    {
        if ($this->product == null) {
            throw new \Exception('Product entity cannot be null.');
        }
        
        $document = [
            'index' => 'productsearch',
            'type' => 'product',
            'id' => $this->product->getId(),
            'body' => [
                'doc' => $this->document($this->product)
            ]
        ];
        
        try {
            $this->client->update($document);
        } catch (\Elasticsearch\Common\Exceptions\Missing404Exception $e) {
            $this->createDocument();
        }
    }

    public function setProduct(\Application\Entity\Product $product)
    {
        $this->product = $product;
        
        return $this;
    }
}