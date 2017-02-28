<?php
/**
 * @copyright: DotKernel
 * @library: dot-paginator
 * @author: n3vrax
 * Date: 2/28/2017
 * Time: 10:10 PM
 */

declare(strict_types = 1);

namespace Dot\Paginator\Factory;

use Interop\Container\ContainerInterface;
use Zend\Paginator\ScrollingStylePluginManager;

/**
 * Class ScrollingStylePluginManagerFactory
 * @package Dot\Paginator\Factory
 */
class ScrollingStylePluginManagerFactory
{
    public function __invoke(ContainerInterface $container, $requestedName)
    {
        $config = $container->get('config')['dot_paginator'];
        $config = $config['scrolling_style_manager'] ?? [];

        return new ScrollingStylePluginManager($container, $config);
    }
}
