<?php


namespace bao\jwt\blacklist;


class Blacklist
{
    protected $storage;

    public function __construct(Storage $storage)
    {
        $this->storage = $storage;
    }

    protected function getKey($verification)
    {
        return $verification['jti'];
    }

    protected function getTime($verification)
    {
        return $verification['end'];
    }

    public function set($key, $time = 0)
    {
        $this->storage->set($key, $time);

        return $this;
    }

    public function get($key)
    {
        return $this->storage->get($key);
    }

    public function remove($key)
    {
        return $this->storage->delete($key);
    }

    public function add($verification)
    {
        $this->storage->set($this->getKey($verification));

        return $this;
    }

    public function has($verification)
    {
        return $this->get($this->getKey($verification)) ? true : false;
    }

    public function invalidate($verification)
    {
        return $this->set($this->getKey($verification), $this->getTime($verification));
    }
}