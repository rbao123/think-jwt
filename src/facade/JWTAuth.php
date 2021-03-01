<?php


namespace bao\jwt\facade;


use think\Facade;


/**
 * Class JWTAuth
 * @package bao\jwt\facade
 * @mixin \bao\jwt\JWTAuth
 * @see \bao\jwt\JWTAuth
 * @method string builder(array $user = []) static Token构建
 * @method array auth() static Token验证
 * @method string refresh() static Token刷新
 * @method array getPayload() static 获取Payload
 * @method mixed invalidate() static 添加Token至黑名单
 * @method mixed validate($token) static 验证Token是否在黑名单
 */
class JWTAuth extends Facade
{
    /**
     * 获取当前Facade对应类名（或者已经绑定的容器对象标识）
     * @access protected
     * @return string
     */
    protected static function getFacadeClass()
    {
        return '\bao\jwt\JWTAuth';
    }
}