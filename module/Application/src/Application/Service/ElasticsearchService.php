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

    public function createMapping()
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
        }
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
            'body' => [
                'suggest' => [
                    'input' => [
                        (string) $this->product->getId(),
                        $this->product->getName()
                    ]
                ]
            ]
        ];
        
        $this->client->index($document);
    }

    public function editDocument()
    {
        $document = [
            'index' => 'productsearch',
            'type' => 'product',
            'id' => $this->product->getId(),
            'body' => [
                'doc' => [
                    'suggest' => [
                        'input' => [
                            (string) $this->product->getId(),
                            $this->product->getName()
                        ]
                    ]
                ]
            ]
        ];
        
        $this->client->update($document);
    }

    public function setProduct(\Application\Entity\Product $product)
    {
        $this->product = $product;
        
        return $this;
    }
}