<?php
/**
 * @copyright: DotKernel
 * @library: dot-paginator
 * @author: n3vrax
 * Date: 2/28/2017
 * Time: 10:18 PM
 */

declare(strict_types = 1);

namespace Dot\Paginator\Adapter;

use Dot\Ems\Mapper\AbstractDbMapper;
use Dot\Ems\Mapper\MapperInterface;
use Zend\Paginator\Adapter\AdapterInterface;

/**
 * Class MapperAdapter
 * @package Dot\Paginator\Adapter
 */
class MapperAdapter implements AdapterInterface
{
    /** @var  AbstractDbMapper */
    protected $mapper;

    /** @var array  */
    protected $options = [];

    /** @var  int */
    protected $rowCount;

    /** @var array  */
    protected $items;

    /**
     * DbMapperAdapter constructor.
     * @param MapperInterface $mapper
     * @param array $options
     */
    public function __construct(MapperInterface $mapper, array $options = [])
    {
        $this->mapper = $mapper;
        $this->options = $options ?? [];
    }

    /**
     * @param int $offset
     * @param int $itemCountPerPage
     * @return array
     */
    public function getItems($offset, $itemCountPerPage): array
    {
        if ($this->items) {
            return $this->items;
        }

        $options = $this->options;
        $options += [
            'offset' => $offset,
            'limit' => $itemCountPerPage
        ];

        $finder = $options['finder'] ?? 'all';

        $this->items = $this->mapper->find($finder, $options);

        return $this->items;
    }

    /**
     * @return int
     */
    public function count(): int
    {
        if (!$this->rowCount) {
            $options = $this->options;
            $finder = $options['finder'] ?? 'all';

            $this->rowCount = $this->getMapper()->count($finder, $options);
            if ($this->rowCount < 0) {
                $this->rowCount = 0;
            }
        }

        return $this->rowCount;
    }

    /**
     * @return MapperInterface
     */
    public function getMapper(): MapperInterface
    {
        return $this->mapper;
    }

    /**
     * @param MapperInterface $mapper
     */
    public function setMapper(MapperInterface $mapper)
    {
        $this->mapper = $mapper;
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * @param array $options
     */
    public function setOptions(array $options)
    {
        $this->options = $options;
    }
}
