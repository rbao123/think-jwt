<?php


namespace bao\jwt\parser;


use bao\jwt\blacklist\Blacklist;
use bao\jwt\exception\JWTException;

class Examine
{
    public $blacklist;
    public $verification;
    public $combination;

    public function __construct(Blacklist $blacklist, Combination $combination)
    {
        $this->blacklist = $blacklist;
        $this->combination = $combination;
    }

    public function setVerification($verification)
    {
        return $this->verification = $verification;
    }

    public function getVerification($verification)
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
        if ($this->combination->multiApp()) {
            $app_name = $this->verification['app'];
            if ($app_name != $this->combination->getAppName()) {
                throw new JWTException('该令牌不是本应用的');
            }
        }
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