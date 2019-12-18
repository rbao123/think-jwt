<?php


namespace bao\jwt\parser;


class Combination
{
    protected $user;
    public $check_data;
    protected $refresh_ttl;

    /**
     * 构建验证信息
     */
    protected function initializeCheckData()
    {
        $this->check_data = [
            'start_time' => time(),
            'end_time' => time() + $this->refresh_ttl,
            'app' => app('http')->getName(),
        ];
    }

    public function builder(array $user)
    {
        $this->user = $user;
    }
}