<?php

/*
 * This file is part of the Perimeter package.
 *
 * (c) Adobe Systems, Inc. <bshafs@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Perimeter\CacheBundle\Cache;

use Memento\Client;
use Memento\Key;

class Memento implements CacheServiceInterface
{
    protected $client;
    protected $prefix;

    public function __construct(Client $client, $prefix = null)
    {
        $this->client = $client;
        $this->prefix = $prefix;
    }

    public function store($data, $key, $expires)
    {
        return $this->client->store($this->createMementoKey($key), $data, $expires);
    }

    public function retrieve($key)
    {
        return $this->client->retrieve($this->createMementoKey($key));
    }

    public function isFresh($key)
    {
        return $this->client->exists($this->createMementoKey($key));
    }

    public function invalidate($key)
    {
        return $this->client->invalidate($this->createMementoKey($key));
    }

    protected function createMementoKey($name)
    {
        return new Key($this->prefix ? $this->prefix . $name : $name);
    }
}
