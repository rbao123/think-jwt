<?php


namespace bao\jwt\payload;


use bao\jwt\Encryption;
use bao\jwt\parser\Combination;
use bao\jwt\parser\Parser;

class Payload
{
    protected $combination;
    protected $encryption;//加密类
    protected $parser;//解密类


    public function __construct(Combination $combination, Encryption $encryption, Parser $parser)
    {
        $this->combination = $combination;
        $this->encryption = $encryption;
        $this->parser = $parser;
    }

    /**
     * 生成token
     * @param $payload
     * @return string
     */
    public function encode($payload)
    {
        return $this->encryption->encryptionToken(json_encode($this->combination->initializeCheckData())) . '.' .
            $this->encryption->encryptionToken(json_encode($payload));
    }

    /**
     * 刷新token
     * @return string
     * @throws \bao\jwt\exception\JWTException
     */
    public function refresh()
    {
        $this->parser->getToken();
        return $this->encode($this->parser->parseToken());
    }
}