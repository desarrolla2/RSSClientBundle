<?php
namespace Desarrolla2\Bundle\RSSClientBundle\Cache;

use Desarrolla2\Cache\Adapter\AdapterInterface;
use Symfony\Component\HttpKernel\CacheWarmer\CacheWarmerInterface;

/**
 * Warms our cache.
 * For instance, the File adapter will already create the cache directory.
 */
class CacheWarmer implements CacheWarmerInterface
{
    public function __construct(AdapterInterface $adapter)
    {
    }

    public function isOptional()
    {
        return false;
    }

    public function warmUp($cacheDir)
    {
        // Normally, we'd do some sort of operations to "warm" our cache
        // In this case, this heavy lifting is already done in the constructor of the adapter.
    }
}
