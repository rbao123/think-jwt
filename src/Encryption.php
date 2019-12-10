<?php


namespace app\common\jwt;


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
    public function encryptionToken(string $data)
    {
        $to_data = openssl_encrypt($data, 'AES-128-ECB', $this->key, OPENSSL_RAW_DATA);
        return $this->token = base64_encode($to_data);
    }

    /**
     * @param $sStr
     * @return false|string
     */
    public function decrypt($sStr)
    {
        $decrypted = openssl_decrypt(base64_decode($sStr), 'AES-128-ECB', $this->key, OPENSSL_RAW_DATA);
        return json_decode($decrypted,true);
    }

}