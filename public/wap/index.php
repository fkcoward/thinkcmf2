<?php

// 调试模式开关
define("APP_DEBUG", true);

define("APP_NAMESPACE", 'wap');

// 定义CMF根目录,可更改此目录
define('CMF_ROOT', __DIR__ . '/../../');

// 定义应用目录
define('APP_PATH', CMF_ROOT . 'wap/');

// 定义CMF核心包目录
define('CMF_PATH', CMF_ROOT . 'simplewind/cmf/');

// 定义网站入口目录
define('WEB_ROOT', __DIR__ . '/');

// 定义插件目录
define('PLUGINS_PATH', __DIR__ . '/../plugins/');

// 定义扩展目录
define('EXTEND_PATH', CMF_ROOT . 'simplewind/extend/');
define('VENDOR_PATH', CMF_ROOT . 'simplewind/vendor/');

// 定义应用的运行时目录
define('RUNTIME_PATH', CMF_ROOT . 'data/runtime/wap/');

// 定义CMF 版本号
define('THINKCMF_VERSION', '5.0.190111');
//define('BIND_MODULE','home');
// 加载框架基础文件
require CMF_ROOT . 'simplewind/thinkphp/base.php';

// 执行应用
\think\App::run()->send();
