<?php

return [
    [
        'name'    => 'defaultproject',
        'title'   => '默认搜索项目',
        'type'    => 'string',
        'content' => [
        ],
        'value'   => '',
        'rule'    => '',
        'msg'     => '',
        'tip'     => '',
        'ok'      => '',
        'extend'  => 'class="form-control selectpage" data-source="xunsearch/project/index" data-primary-key="name" data-field="title"'
    ],
    [
        'name'    => 'defaultserverindex',
        'title'   => '默认索引服务端端口',
        'type'    => 'number',
        'content' => [
        ],
        'value'   => '8383',
        'rule'    => '',
        'msg'     => '',
        'tip'     => '',
        'ok'      => '',
        'extend'  => ''
    ],
    [
        'name'    => 'defaultcharset',
        'title'   => '默认编码',
        'type'    => 'string',
        'content' => [
        ],
        'value'   => 'UTF-8',
        'rule'    => '',
        'msg'     => '',
        'tip'     => '',
        'ok'      => '',
        'extend'  => ''
    ],
    [
        'name'    => 'defaultserversearch',
        'title'   => '默认搜索服务端端口',
        'type'    => 'number',
        'content' => [
        ],
        'value'   => '8384',
        'rule'    => '',
        'msg'     => '',
        'tip'     => '',
        'ok'      => '',
        'extend'  => ''
    ],
    [
        'name'    => 'domain',
        'title'   => '绑定二级域名前缀',
        'type'    => 'string',
        'content' => [
        ],
        'value'   => '',
        'rule'    => '',
        'msg'     => '',
        'tip'     => '',
        'ok'      => '',
        'extend'  => ''
    ],
    [
        'name'    => 'rewrite',
        'title'   => '伪静态',
        'type'    => 'array',
        'content' => [],
        'value'   => [
            'index/index'  => '/xunsearch$',
            'index/search' => '/xunsearch/[:name]',
        ],
        'rule'    => 'required',
        'msg'     => '',
        'tip'     => '',
        'ok'      => '',
        'extend'  => ''
    ],
];
