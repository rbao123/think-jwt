<?php


namespace bao\jwt\blacklist;


use think\facade\Cache;

/**
 * 黑名单基础方法
 * Class Storage
 * @package bao\jwt\blacklist
 */
class Storage
{
    public function delete($key): bool
    {
        return Cache::delete($key);
    }

    public function get($key)
    {
        return Cache::get($key);
    }

    public function set($key, $time = 0): bool
    {
        return Cache::set($key, time(), $time);
    }
}