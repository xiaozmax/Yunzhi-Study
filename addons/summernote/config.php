<?php

return [
    [
        'name' => 'classname',
        'title' => '渲染文本框元素',
        'type' => 'string',
        'content' => [],
        'value' => '.editor',
        'rule' => 'required',
        'msg' => '',
        'tip' => '用于对指定的元素渲染，一般情况下无需修改',
        'ok' => '',
        'extend' => '',
    ],
    [
        'name' => 'height',
        'title' => '默认高度',
        'type' => 'string',
        'content' => [],
        'value' => '250',
        'rule' => 'required',
        'msg' => '',
        'tip' => '编辑器默认高度，auto表示自适应高度',
        'ok' => '',
        'extend' => '',
    ],
    [
        'name' => 'minHeight',
        'title' => '默认高度',
        'type' => 'number',
        'content' => [],
        'value' => '250',
        'rule' => 'required',
        'msg' => '',
        'tip' => '编辑器最低高度',
        'ok' => '',
        'extend' => '',
    ],
    [
        'name' => 'followingToolbar',
        'title' => '是否浮动工具栏',
        'type' => 'radio',
        'content' => [
            1 => '是',
            0 => '否',
        ],
        'value' => '0',
        'rule' => 'required',
        'msg' => '',
        'tip' => '是否浮动工具栏，通常配置自适应高度时使用',
        'ok' => '',
        'extend' => '',
    ],
    [
        'name' => 'airMode',
        'title' => '内嵌模式',
        'type' => 'radio',
        'content' => [
            1 => '是',
            0 => '否',
        ],
        'value' => '0',
        'rule' => 'required',
        'msg' => '',
        'tip' => '启用内嵌模式后将禁用工具栏',
        'ok' => '',
        'extend' => '',
    ],
    [
        'name' => 'toolbar',
        'title' => '默认工具栏配置',
        'type' => 'text',
        'content' => [],
        'value' => '['."\r\n"
            .'	["style", ["style", "undo", "redo"]],'."\r\n"
            .'	["font", ["bold", "underline", "strikethrough", "clear"]],'."\r\n"
            .'	["fontname", ["color", "fontname", "fontsize"]],'."\r\n"
            .'	["para", ["ul", "ol", "paragraph", "height"]],'."\r\n"
            .'	["table", ["table", "hr"]],'."\r\n"
            .'	["insert", ["link", "picture", "video"]],'."\r\n"
            .'	["select", ["image", "attachment"]],'."\r\n"
            .'	["view", ["fullscreen", "codeview", "help"]]'."\r\n"
            .']',
        'rule' => 'required',
        'msg' => '',
        'tip' => '',
        'ok' => '',
        'extend' => 'rows=10',
    ],
    [
        'name' => 'placeholder',
        'title' => '默认占位文字',
        'type' => 'string',
        'content' => [],
        'value' => '',
        'rule' => '',
        'msg' => '',
        'tip' => '',
        'ok' => '',
        'extend' => '',
    ],
    [
        'name' => '__tips__',
        'title' => '温馨提示',
        'type' => 'string',
        'content' => [],
        'value' => '工具栏配置请参考文档：https://summernote.org/deep-dive/',
        'rule' => '',
        'msg' => '',
        'tip' => '',
        'ok' => '',
        'extend' => '',
    ],
];
