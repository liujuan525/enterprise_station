<?php
/**
 * 后台 配置文件
 */

return [
    // 视图输出字符串内容替换
    'view_replace_str'       => [
        '__PUBLIC__'=>'/public/',
        '__ROOT__' => '/',
        '__ADMIN__' => 'http://192.168.33.10:8525/static/admin',
    ],

    // 控制器类后缀
    'controller_suffix'      => true,
    // 默认全局过滤方法 用逗号分隔多个
    'default_filter'         => 'strip_tags,htmlspecialchars',

    /**
     * 以下为自己添加的配置文件
     */
    // 加密字符串的盐值
    'encrypt_salt' => '6BSSDFB65257FCAB4E2975CD96B230F7FSDFC4B53D97C10B6',
];