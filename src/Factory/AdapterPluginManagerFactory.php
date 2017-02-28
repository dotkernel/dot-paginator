<?php
/**
 * @copyright: DotKernel
 * @library: dot-paginator
 * @author: n3vrax
 * Date: 2/28/2017
 * Time: 10:06 PM
 */

declare(strict_types = 1);

namespace Dot\Paginator\Factory;

use Interop\Container\ContainerInterface;
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
