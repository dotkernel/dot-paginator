<?php
/**
 * @see https://github.com/dotkernel/dot-paginator/ for the canonical source repository
 * @copyright Copyright (c) 2017 Apidemia (https://www.apidemia.com)
 * @license https://github.com/dotkernel/dot-paginator/blob/master/LICENSE.md MIT License
 */

declare(strict_types = 1);

namespace Dot\Paginator\Factory;

use Psr\Container\ContainerInterface;
use Laminas\Paginator\ScrollingStylePluginManager;

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
