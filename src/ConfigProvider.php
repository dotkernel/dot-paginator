<?php
/**
 * @see https://github.com/dotkernel/dot-paginator/ for the canonical source repository
 * @copyright Copyright (c) 2017 Apidemia (https://www.apidemia.com)
 * @license https://github.com/dotkernel/dot-paginator/blob/master/LICENSE.md MIT License
 */

declare(strict_types = 1);

namespace Dot\Paginator;

use Dot\Paginator\Adapter\MapperAdapter;
use Dot\Paginator\Factory\AdapterPluginManagerFactory;
use Dot\Paginator\Factory\MapperAdapterFactory;
use Dot\Paginator\Factory\ScrollingStylePluginManagerFactory;
use Laminas\Paginator\AdapterPluginManager;
use Laminas\Paginator\ScrollingStylePluginManager;

/**
 * Class ConfigProvider
 * @package Dot\Paginator
 */
class ConfigProvider
{
    public function __invoke()
    {
        return [
            'dependencies' => $this->getDependenciesConfig(),

            'dot_paginator' => [
                'adaptor_manager' => [
                    'factories' => [
                        MapperAdapter::class => MapperAdapterFactory::class,
                    ],
                    'aliases' => [
                        'mapperadapter' => MapperAdapter::class,
                        'mapperAdapter' => MapperAdapter::class,
                        'MapperAdapter' => MapperAdapter::class,
                    ]
                ],
                'scrolling_style_manager' => [],
            ]
        ];
    }

    public function getDependenciesConfig(): array
    {
        return [
            'factories' => [
                AdapterPluginManager::class => AdapterPluginManagerFactory::class,
                ScrollingStylePluginManager::class => ScrollingStylePluginManagerFactory::class,
            ]
        ];
    }
}
