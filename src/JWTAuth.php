<?php


namespace app\common\jwt;


use app\common\jwt\parser\Parser;

class JWTAuth extends JWT
{
    /**
     * Token验证，返回payload
     *
     * @return array
     */
    public function auth()
    {
        return (array)$this->getPayload();
    }

    /**
     * Token构建
     * @param array $user
     * @return mixed
     */
    public function builder(array $user = [])
    {
        return $this->createToken($user);
    }

    /**
     * 添加Token至黑名单
     */
    public function invalidate()
    {
        $this->parser->invalidate();
    }

    /**
     * 刷新token
     */
    public function refresh()
    {
        return $this->payload->refresh();
    }
}