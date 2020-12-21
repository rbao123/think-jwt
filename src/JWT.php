<?php


namespace bao\jwt;


use bao\jwt\parser\Parser;
use bao\jwt\payload\Payload;

class JWT
{
    protected $payload;
    protected $parser;

    public function __construct(Payload $payload, Parser $parser)
    {
        $this->payload = $payload;
        $this->parser = $parser;
    }

    /**
     * 构建token
     * @param array $customerClaim
     * @return string
     */
    public function createToken($customerClaim = []): string
    {
        return $this->payload->encode($customerClaim);
    }

    public function getPayload()
    {
        return $this->parser->parseToken();
    }
}