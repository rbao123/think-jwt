<?php


namespace bao\jwt\payload;


use bao\jwt\Encryption;
use bao\jwt\parser\Parser;

class Payload
{
    protected $refresh_ttl;
    protected $check_data;
    protected $encryption;
    protected $parser;


    public function __construct(Encryption $encryption,Parser $parser)
    {
        $this->refresh_ttl = config('jwt-app.refresh_ttl');
        $this->encryption = $encryption;
        $this->parser = $parser;
    }

    /**
     * 构建验证信息
     */
    protected function initializeCheckData()
    {
        $this->check_data = [
            'start' => time(),
            'end' => time() + $this->refresh_ttl,
//            'app' => app('http')->getName(),
            'jti' => uniqid('', true),
        ];
        return $this->check_data;
    }

    /**
     * 生成token
     * @param $payload
     * @return string
     */
    public function encode($payload)
    {
        return $this->encryption->encryptionToken(json_encode($this->initializeCheckData())) . '.' .
            $this->encryption->encryptionToken(json_encode($payload));
    }

    public function refresh()
    {
        $this->parser->getToken();
        return $this->encode($this->parser->parseToken());

    }
}