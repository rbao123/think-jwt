<?php


namespace bao\jwt;



use bao\jwt\exception\JWTException;

/**
 * 加解密token
 * Class Encryption
 * @package bao\jwt
 */
class Encryption
{
    protected $data;
    protected $token;

    protected $key;

    /**
     * 获取加密key
     */
    public function __construct()
    {
        $this->key = config('jwt-app.secret');
    }

    /**
     * 获取加密key
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * 加密字符串
     * @param string $data
     * @return string
     */
    public function encryptionToken(string $data): string
    {
        $to_data = openssl_encrypt($data, 'AES-128-ECB', $this->key, OPENSSL_RAW_DATA);
        return $this->token = base64_encode($to_data);
    }

    /**
     * @param $sStr
     * @throws JWTException
     * @return array
     */
    public function decrypt($sStr): array
    {
        $decrypted = openssl_decrypt(base64_decode($sStr), 'AES-128-ECB', $this->key, OPENSSL_RAW_DATA);
        if ($decrypted === false) {
            throw new JWTException('非法令牌');
        }
        return json_decode($decrypted,true);
    }

}