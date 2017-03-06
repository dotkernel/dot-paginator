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

use Dot\Ems\Event\MapperEvent;
use Dot\Ems\Event\MapperEventListenerInterface;
use Dot\Ems\Event\MapperEventListenerTrait;
use Dot\Ems\Mapper\AbstractDbMapper;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Select;
use Zend\Paginator\Adapter\AdapterInterface;

/**
 * Class MapperAdapter
 * @package Dot\Paginator\Adapter
 */
class DbMapperAdapter implements AdapterInterface, MapperEventListenerInterface
{
    use MapperEventListenerTrait;

    /** @var  AbstractDbMapper */
    protected $mapper;

    /** @var array  */
    protected $options = [];

    /** @var  int */
    protected $rowCount;

    /** @var array  */
    protected $items;

    /** @var  Select */
    protected $countSelect;

    /** @var bool  */
    protected $isCountSelect = false;

    /**
     * DbMapperAdapter constructor.
     * @param AbstractDbMapper $mapper
     * @param array $options
     */
    public function __construct(AbstractDbMapper $mapper, array $options = [])
    {
        $this->mapper = $mapper;
        $this->options = $options ?? [];

        $this->attach($mapper->getEventManager(), -1000);
    }

    /**
     * @param int $offset
     * @param int $itemCountPerPage
     * @return array
     */
    public function getItems($offset, $itemCountPerPage): array
    {
        $this->isCountSelect = false;

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
            $this->rowCount = 0;

            if (!$this->countSelect) {
                $this->isCountSelect = true;

                $options = $this->options;
                $finder = $options['finder'] ?? 'all';

                $this->countSelect = $this->getMapper()->find($finder, $options);
                $this->isCountSelect = false;
            }

            $sql = $this->getMapper()->getSql();
            $stmt = $sql->prepareStatementForSqlObject($this->countSelect);
            $result = $stmt->execute();

            $this->rowCount = (int) $result->current()['count'];
        }

        return $this->rowCount;
    }

    /**
     * @param MapperEvent $e
     * @return mixed|Select
     */
    public function onBeforeFind(MapperEvent $e)
    {
        $select = $e->getParam('select');
        if ($select instanceof Select) {
            $this->countSelect = clone $select;
            $this->countSelect->reset(Select::LIMIT);
            $this->countSelect->reset(Select::OFFSET);
            $this->countSelect->reset(Select::ORDER);

            $this->countSelect->columns(['count' => new Expression('COUNT(1)')]);
        }

        if ($this->isCountSelect) {
            // returning something !== null in this event will stop the mapper from fetching data
            return $this->countSelect;
        }

        return null;
    }

    /**
     * @return AbstractDbMapper
     */
    public function getMapper(): AbstractDbMapper
    {
        return $this->mapper;
    }

    /**
     * @param AbstractDbMapper $mapper
     */
    public function setMapper(AbstractDbMapper $mapper)
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
