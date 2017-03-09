<?php
/**
 * @copyright: DotKernel
 * @library: dot-paginator
 * @author: n3vrax
 * Date: 3/1/2017
 * Time: 12:34 AM
 */

declare(strict_types = 1);

namespace Dot\Paginator\Factory;

use Dot\Mapper\Mapper\MapperInterface;
use Dot\Mapper\Mapper\MapperManager;
use Dot\Paginator\Adapter\MapperAdapter;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;

/**
 * Class MapperAdapterFactory
 * @package Dot\Paginator\Factory
 */
class MapperAdapterFactory
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        if (empty($options)) {
            throw new ServiceNotCreatedException(sprintf(
                '%s requires a minimum of dot-ems MapperInterface instance or name',
                MapperAdapter::class
            ));
        }

        $mapper = isset($options['mapper'])
        && (is_string($options['mapper']) || $options['mapper'] instanceof MapperInterface)
            ? $options['mapper']
            : null;

        if (is_string($mapper)) {
            /** @var MapperManager $mapperManager */
            $mapperManager = $container->get(MapperManager::class);
            $mapper = $mapperManager->get($mapper);
        }

        if (!$mapper instanceof MapperInterface) {
            throw new ServiceNotCreatedException('Mapper parameter must be an instance of ' .
                MapperInterface::class . ' or its associated service name');
        }

        $selectOptions = $options['options'] ?? [];

        return new $requestedName($mapper, $selectOptions);
    }
}
