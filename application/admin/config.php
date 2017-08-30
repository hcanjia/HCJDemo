<?php
/**
 * Created by PhpStorm.
 * User: HCJ
 * Date: 2017/7/25
 * Time: 9:57
 */

$root = \think\Request::instance()->root();
$root = str_replace('/index.php', '', $root);
define("__ROOT__", $root);

return [
    'default_return_type'    => 'html',
    'view_replace_str'       => [
        '__PUBLIC__'=>__ROOT__.'/public',
        '__ADMIN__'=>__ROOT__.'/admin',
        'ADMIN'=>'/admin'
    ]
];