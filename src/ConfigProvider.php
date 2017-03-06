<?php
/**
 * @copyright: DotKernel
 * @library: dot-paginator
 * @author: n3vrax
 * Date: 2/28/2017
 * Time: 10:03 PM
 */

declare(strict_types = 1);

namespace Dot\Paginator;

use Dot\Paginator\Adapter\DbMapperAdapter;
use Dot\Paginator\Factory\AdapterPluginManagerFactory;
use Dot\Paginator\Factory\DbMapperAdapterFactory;
use Dot\Paginator\Factory\ScrollingStylePluginManagerFactory;
use Zend\Paginator\AdapterPluginManager;
use Zend\Paginator\ScrollingStylePluginManager;

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
                        DbMapperAdapter::class => DbMapperAdapterFactory::class,
                    ],
                    'aliases' => [
                        'dbmapperadapter' => DbMapperAdapter::class,
                        'dbMapperAdapter' => DbMapperAdapter::class,
                        'DbMapperAdapter' => DbMapperAdapter::class,
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
