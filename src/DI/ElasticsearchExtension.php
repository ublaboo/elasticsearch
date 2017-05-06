<?php

declare(strict_types=1);

/**
 * @copyright   Copyright (c) 2015 ublaboo <ublaboo@paveljanda.com>
 * @author      Pavel Janda <me@paveljanda.com>
 * @package     Ublaboo
 */

namespace Ublaboo\Elasticsearch\DI;

use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;
use Monolog\Logger;
use Nette\DI\CompilerExtension;
use Nette\DI\Helpers;

class ElasticsearchExtension extends CompilerExtension
{

	/**
	 * @var array
	 */
	private $defaults = [
		'hosts' => [], // e.g.: ['127.0.0.1:9200']
		'logDir' => '%appDir%/../log'
	];


	public function loadConfiguration(): void
	{
		$builder = $this->getContainerBuilder();

		$config = $this->validateConfig($this->defaults, $this->config);
		$config['logDir'] = Helpers::expand($config['logDir'], $builder->parameters);

		$loggerDefinition = $builder->addDefinition($this->prefix('elasticsearch.logger'))
			->setClass(Logger::class)
			->setFactory(ClientBuilder::class . '::defaultLogger', [$config['logDir']]);

		$builder->addDefinition($this->prefix('elasticsearch.clientFactory'))
			->setClass(ClientBuilder::class)
			->addSetup('setHosts', [$config['hosts']])
			->addSetup('setLogger', [$loggerDefinition]);

		$builder->addDefinition($this->prefix('elasticsearch.client'))
			->setClass(Client::class)
			->setFactory($this->prefix('@elasticsearch.clientFactory::build'));
	}

}
