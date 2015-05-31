<?php

namespace Etki\Projects\MentorshipEtkiName\MasterBundle\Service;

use Doctrine\Common\Cache\Cache as CacheInterface;
use Doctrine\Common\Cache\ClearableCache as ClearableCacheInterface;
use Doctrine\Common\Cache\FlushableCache as FlushableCacheInterface;

/**
 * Simple cache purger.
 *
 * @version 0.1.0
 * @since   0.1.0
 * @package Etki\Projects\MentorshipEtkiName\MasterBundle\Service
 * @author  Etki <etki@etki.name>
 */
class SimpleDoctrineCacheCleaner
{
    /**
     * Cache instance.
     *
     * @type CacheInterface
     * @since 0.1.0
     */
    private $cache;

    /**
     * Initializer.
     *
     * @param CacheInterface $cache Doctrine cache instance.
     *
     * @since 0.1.0
     */
    public function __construct(CacheInterface $cache)
    {
        $this->cache = $cache;
    }

    /**
     * Purges all the cache.
     *
     * @return bool
     * @since 0.1.0
     */
    public function purgeCache()
    {
        if ($this->cache instanceof ClearableCacheInterface) {
            $this->cache->deleteAll();
            return true;
        } elseif ($this->cache instanceof FlushableCacheInterface) {
            $this->cache->flushAll();
            return true;
        }
        return false;
    }
}
