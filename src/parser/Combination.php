<?php


namespace bao\jwt\parser;


class Combination
{
    public $check_data;
    public $is_app;

    /**
     * 构建验证信息
     */
    public function initializeCheckData()
    {
        $this->check_data = [
            'start_time' => time(),
            'end_time' => $this->getEndTime(),
            'jti' => $this->getJti(),
        ];
        if ($this->multiApp()) {
            $this->check_data['app'] = $this->getAppName();
        }

        return $this->check_data;
    }

    /**
     * 是否多应用
     * @return bool
     */
    public function multiApp(): bool
    {
        $this->is_app = config('jwt-app.multi_app') ?? false;
    }


    /**
     * 获取标记
     * @return string
     */
    public function getJti()
    {
        return uniqid('JWT', true);
    }

    /**
     * 获取获取时间
     * @return int
     */
    public function getEndTime(): int
    {
        return time() + $this->getRefreshTtl();
    }


    /**
     * 获取有效时间
     * @return mixed
     */
    public function getRefreshTtl(): int
    {
        return config('jwt-app.refresh_ttl');
    }

    /**
     * 获取当前应用名
     * @return mixed
     */
    public function getAppName()
    {
        return app('http')->getName();
    }
}