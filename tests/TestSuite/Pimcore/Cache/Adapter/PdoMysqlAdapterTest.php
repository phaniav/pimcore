<?php

namespace TestSuite\Pimcore\Cache\Adapter;

use Cache\IntegrationTests\CachePoolTest;
use Psr\Cache\CacheItemPoolInterface;
use Test\Cache\Traits\PdoMysqlAdapterTrait;

require_once __DIR__ . '/../../../../lib/Test/Cache/Traits/PdoMysqlAdapterTrait.php';

class PdoMysqlAdapterTest extends CachePoolTest
{
    use PdoMysqlAdapterTrait;

    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();
        static::fetchPdo();
    }

    /**
     * @return CacheItemPoolInterface that is used in the tests
     */
    public function createCachePool()
    {
        $adapter = $this->createPdoAdapter();
        $adapter->clear();

        return $adapter;
    }
}