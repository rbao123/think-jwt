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

    /**
     * 从黑名单中恢复
     * @param $key
     * @return bool
     */
    public function remove($key)
    {
        return $this->storage->delete($key);
    }

    /**
     * 验证是否在黑名单
     * @param $verification
     * @return bool
     */
    public function has($verification)
    {
        return $this->get($this->getKey($verification)) ? true : false;
    }

    /**
     * 添加黑名单
     * @param $verification
     * @return $this
     */
    public function invalidate($verification)
    {
        return $this->set($this->getKey($verification), $this->getTime($verification));
    }
}