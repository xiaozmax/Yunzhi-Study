<?php

return [
    'autoload' => false,
    'hooks' => [
        'action_begin' => [
            'clicaptcha',
        ],
        'view_filter' => [
            'clicaptcha',
            'darktheme',
        ],
        'captcha_mode' => [
            'clicaptcha',
        ],
        'config_init' => [
            'darktheme',
            'ueditor',
        ],
        'app_init' => [
            'log',
        ],
        'admin_login_init' => [
            'loginbg',
        ],
        'prismhook' => [
            'prism',
        ],
    ],
    'route' => [],
    'priority' => [],
    'domain' => '',
];
