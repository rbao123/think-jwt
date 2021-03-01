<?php


namespace bao\jwt;



class JWTAuth extends JWT
{
    /**
     * Token验证，返回payload
     * @return array
     */
    public function auth(): array
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
     * @throws exception\JWTException
     */
    public function invalidate()
    {
        $this->parser->invalidate();
    }

    /**
     * 刷新token
     * @return mixed
     * @throws
     */
    public function refresh(): string
    {
        return $this->payload->refresh();
    }
}