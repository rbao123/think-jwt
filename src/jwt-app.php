<?php

return [
    //加密盐
    'secret' => env('JWT_SECRET'),
    //有效时间
    'refresh_ttl' => env('JWT_REFRESH_TTL', 20160),
    //错误code
    'error_code' => 401,
    //多应用
    'multi_app' => true,
];