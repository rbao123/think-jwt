<?php


namespace bao\jwt\parser;


use bao\jwt\blacklist\Blacklist;
use bao\jwt\Encryption;
use bao\jwt\parser\Examine;
use bao\jwt\exception\JWTException;
use think\Request;

class Parser
{
    public $encryption;
    public $payload;
    public $examine;
    public $token;
    public $request;
    public $verification;
    public $blacklist;

    public function __construct(Encryption $encryption, Examine $examine, Request $request, Blacklist $blacklist)
    {
        $this->encryption = $encryption;
        $this->examine = $examine;
        $this->request = $request;
        $this->blacklist = $blacklist;
    }

    /**
     * 写入原始token
     * @param $token
     * @throws JWTException
     */
    public function setToken($token)
    {
        if (empty($token)) {
            throw new JWTException('非法令牌');
        }
        $this->token = $token;
    }

    /**
     * 初步检验原始token
     * @param string $token
     * @return mixed
     * @throws JWTException
     */
    public function excision(string $token)
    {
        if (strpos($token, '.') === false) {
            throw new JWTException('令牌缺少分隔符');
        }
        if (strpos($token, 'Bearer ') === false) {
            throw new JWTException('非法令牌');
        }
        return str_replace('Bearer ', '', $token);
    }

    /**
     * 分割原始token
     */
    public function separation()
    {
        $token_array = explode('.', $this->token);
        $this->verification = $this->decrypt($token_array[0]);
        $this->payload = $this->decrypt($token_array[1]);
        return $this;
    }

    /**
     * 校验token
     * @return $this
     */
    public function checkToken()
    {
        $this->examine->check($this->verification);
        return $this;
    }

    /**
     * 解密密文
     * @param string $token
     * @return string
     */
    public function decrypt(string $token)
    {
        return $this->encryption->decrypt($token);
    }

    /**
     * 获取
     * @return $this
     * @throws JWTException
     */
    public function getToken()
    {
        $bearer = $this->request->header('Authorization');
        if (!$bearer) {
            throw new JWTException('非法令牌');
        }
        $this->setToken($this->excision($bearer));
        return $this;
    }

    /**
     * 添加黑名单
     * @throws JWTException
     */
    public function invalidate()
    {
        $this->getToken();
        $this->separation();
        $this->blacklist->invalidate($this->verification);
    }

    /**
     * 解析token主方法
     * @return mixed
     * @throws JWTException
     */
    public function parseToken()
    {
        $this->getToken();
        $this->separation();
        $this->checkToken();
        return $this->payload;
    }
}