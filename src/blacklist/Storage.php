<?php


namespace app\common\jwt\blacklist;


use think\facade\Cache;

class Storage
{
    public function delete($key)
    {
        return Cache::delete($key);
    }

    public function get($key)
    {
        return Cache::get($key);
    }

    public function set($key, $time = 0)
    {
        return Cache::set($key, time(), $time);
    }
}