# elasticsearch
Simple Nette extension for creating Elasticsearch Client service

## Installation

Download extension using composer

```
composer require ublaboo/elasticsearch
```

Register extension in your config.neon file:

``` 
extensions:
	elasticsearch: Ublaboo\Elasticsearch\DI\ElasticsearchExtension
```

## Configuration

Configure extension in your `config.neon` file:

``` 
elasticsearch:
	hosts:
		- 127.0.0.1:9200
```

## Usage

```php

use Elasticsearch;

class MySuperBusinessModelClass
{

	/**
	 * @var Elasticsearch\Client
	 */
	public $elasticsearchClient;


	public function __construct(Elasticsearch\Client $elasticsearchClient)
	{
		$this->elasticsearchClient = $elasticsearchClient;
	}


	public function foo(): void
	{
		/**
		 * Do something with $this->elasticsearchClient
		 */
	}

}
```
