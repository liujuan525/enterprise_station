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

];