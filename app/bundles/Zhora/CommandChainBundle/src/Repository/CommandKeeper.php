<?php

namespace Zhora\CommandChainBundle\Repository;

use Symfony\Component\Cache\Adapter\ApcuAdapter;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\TagAwareCacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

class CommandKeeper
{
    private CacheInterface $myCachePool;

    public function __construct(CacheInterface $myCachePool)
    {
        $this->myCachePool = $myCachePool;

    }

    public function getRegisteredCommands()
    {
        $value0 = $this->myCachePool->get('item_0', function (ItemInterface $item) {
            $item->tag(['foo', 'bar']);

            return 'debug';
        });

        $value1 = $this->myCachePool->get('item_1', function (ItemInterface $item) {
            $item->tag('foo');

            return 'debug';
        });

        // Remove all cache keys tagged with "bar"
        $this->myCachePool->invalidateTags(['bar']);
    }

    public function registerCommand(string $name)
    {
        $productsCount = $this->myCachePool->getItem('stats.products_count');
        $productsCount->set('key', $name);
        $this->myCachePool->save($productsCount);

    }
}
