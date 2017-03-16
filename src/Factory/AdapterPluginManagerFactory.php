<?php
/**
 * @see https://github.com/dotkernel/dot-paginator/ for the canonical source repository
 * @copyright Copyright (c) 2017 Apidemia (https://www.apidemia.com)
 * @license https://github.com/dotkernel/dot-paginator/blob/master/LICENSE.md MIT License
 */

declare(strict_types = 1);

namespace Dot\Paginator\Factory;

use Psr\Container\ContainerInterface;
use Zend\Paginator\AdapterPluginManager;

/**
 * Class AdaptorPluginManagerFactory
 * @package Dot\Paginator\Factory
 */
class AdapterPluginManagerFactory
{
    public function __invoke(ContainerInterface $container, $requestedName)
    {
        $config = $container->get('config')['dot_paginator'];
        $config = $config['adaptor_manager'] ?? [];

        return new AdapterPluginManager($container, $config);
    }
}
