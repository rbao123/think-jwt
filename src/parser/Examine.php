<?php


namespace bao\jwt\parser;


use bao\jwt\blacklist\Blacklist;
use bao\jwt\exception\JWTException;

class Examine
{
    public $blacklist;
    public $verification;

    public function __construct(Blacklist $blacklist)
    {
        $this->blacklist = $blacklist;
    }

    public function setVerification($verification)
    {
        return $this->verification = $verification;
    }

    /**
     * 验证黑名单
     * @throws
     */
    public function checkBlacklist()
    {
        if ($this->blacklist->has($this->verification)) {
            throw new JWTException('该令牌在黑名单');
        }
    }

    /**
     * 验证过期时间
     * @throws
     */
    public function checkTime()
    {
        $expired_time = $this->verification['end'];
        if ($expired_time <= time()) {
            throw new JWTException('该令牌过期了');
        }
        $this->checkBlacklist();
    }

    /**
     * 验证应用
     * @throws
     */
    public function checkApp()
    {
        $this->checkTime();
    }

    /**
     * 验证
     * @param $verification
     */
    public function check($verification)
    {
        $this->setVerification($verification);
        $this->checkApp();
    }
}