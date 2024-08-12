<?php

return array(
    0 =>
        array(
            'name'    => 'theme',
            'title'   => '主题',
            'type'    => 'radio',
            'content' =>
                array(
                    'prism'                => 'Default',
                    'prism-dark'           => 'Dark',
                    'prism-funky'          => 'Funky',
                    'prism-okaidia'        => 'Okaidia',
                    'prism-twilight'       => 'Twilight',
                    'prism-coy'            => 'Coy',
                    'prism-solarizedlight' => 'Solarized Light',
                    'prism-tomorrow'       => 'Tomorrow Night',
                ),
            'value'   => 'prism-okaidia',
            'rule'    => 'required',
            'msg'     => '',
            'tip'     => '',
            'ok'      => '',
            'extend'  => '',
        ),
    1 =>
        array(
            'name'    => 'font_size',
            'title'   => '字体大小',
            'type'    => 'string',
            'content' => '',
            'value'   => '16',
            'rule'    => 'required',
            'msg'     => '',
            'tip'     => 'px',
            'ok'      => '',
            'extend'  => '',
        ),
    2 =>
        array(
            'name'    => 'line_number',
            'title'   => '显示行号',
            'type'    => 'radio',
            'content' =>
                array(
                    0 => '不显示',
                    1 => '自动显示',
                    2 => '手动配置<span class="text-muted"> - 需手动添加 line-numbers 的class</span>',
                ),
            'value'   => '2',
            'rule'    => 'required',
            'msg'     => '',
            'tip'     => '',
            'ok'      => '',
            'extend'  => '',
        ),
    3 =>
        array(
            'name'    => 'auto_wrap',
            'title'   => '自动换行',
            'type'    => 'radio',
            'content' =>
                array(
                    1 => '是<span class="text-muted"> - 仅当显示行号时有效</span>',
                    0 => '否',
                ),
            'value'   => '1',
            'rule'    => 'required',
            'msg'     => '',
            'tip'     => '',
            'ok'      => '',
            'extend'  => '',
        ),
);
