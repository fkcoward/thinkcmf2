<?php

$configs = [
    'app_debug' => true,
    'app_status' => APP_DEBUG ? 'debug' : 'release',
    'default_module' => 'index',
    'default_controller' => 'Index',
    'default_action' => 'index',
    'app_namespace' => 'wap',
    'app_multi_module' => true,
    // 入口自动绑定模块
    'auto_bind_module' => false,
    // 注册的根命名空间
    'root_namespace' => ['cmf' => CMF_PATH, 'plugins' => PLUGINS_PATH],
    // +----------------------------------------------------------------------
    // | URL设置
    // +----------------------------------------------------------------------
    'pathinfo_depr' => '/',
    // URL伪静态后缀
    'url_html_suffix' => 'html',
    // URL普通方式参数 用于自动生成
    'url_common_param' => false,
    // URL参数方式 0 按名称成对解析 1 按顺序解析
    'url_param_type' => 0,
    // 是否开启路由
    'url_route_on' => true,
    // 路由配置文件（支持配置多个）
    'route_config_file' => ['route'],
    // 是否强制使用路由
    'url_route_must' => false,
    // 域名部署
    'url_domain_deploy' => false,
    // 域名根，如thinkphp.cn
    'url_domain_root' => '',
    // 是否自动转换URL中的控制器和操作名
    'url_convert' => false,
    // 默认的访问控制器层
    'url_controller_layer' => 'controller',
    // 表单请求类型伪装变量
    'var_method' => '_method',
    'class_suffix' => false,
    // 控制器类后缀
    'controller_suffix' => false,
    'template' => [
        'view_path'=>WEB_ROOT."../themes/wap/"
    ],
    // +----------------------------------------------------------------------
    // | 日志设置
    // +----------------------------------------------------------------------
    'log' => [
        // 日志记录方式，内置 file socket 支持扩展
        'type' => 'File',
        // 日志保存目录
        'path' => LOG_PATH,
        // 日志记录级别
        'level' => [],
    ],
    // +----------------------------------------------------------------------
    // | Trace设置 开启 app_trace 后 有效
    // +----------------------------------------------------------------------
    'trace' => [
        // 内置Html Console 支持扩展
        'type' => 'Html',
    ],
    // +----------------------------------------------------------------------
    // | 缓存设置
    // +----------------------------------------------------------------------
    'cache' => [
        // 驱动方式
        'type' => 'File',
        // 缓存保存目录
        'path' => CACHE_PATH,
        // 缓存前缀
        'prefix' => '',
        // 缓存有效期 0表示永久缓存
        'expire' => 0,
    ],
    // +----------------------------------------------------------------------
    // | 数据库设置
    // +----------------------------------------------------------------------
    'database' => [
        // 数据库调试模式
        'debug' => APP_DEBUG,
        // 数据集返回类型
        'resultset_type' => 'collection',
        // 自动写入时间戳字段
        'auto_timestamp' => false,
        // 时间字段取出后的默认时间格式
        'datetime_format' => false,
        // 是否需要进行SQL性能分析
        'sql_explain' => APP_DEBUG,
    ],
    'http_exception_template' => [
        // 定义404错误的重定向页面地址
        404 => APP_PATH . 'index/view/404.html',
        // 还可以定义其它的HTTP status
        401 => APP_PATH . 'index/view/401.html',
    ]
];
return $configs;