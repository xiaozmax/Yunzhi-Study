<?php

namespace addons\xunsearch\model;

use addons\xunsearch\library\Xunsearch;
use think\Db;
use think\Model;


class Project extends Model
{

    // 表名
    protected $name = 'xunsearch_project';

    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';
    protected $deleteTime = false;

    // 追加属性
    protected $append = [
        'status_text'
    ];

    public function getUrlAttr($value, $data)
    {
        if (isset($data['url'])) {
            return $data['url'];
        }
        $config = get_addon_config('xunsearch');
        if ($config['defaultproject'] == $data['name']) {
            return addon_url('xunsearch/index/index', null, false);
        } else {
            return addon_url('xunsearch/index/search', [':name' => $data['name']], false);
        }
    }

    public function getLogoAttr($value, $data)
    {
        return $data['logo'] ? $data['logo'] : '/assets/addons/xunsearch/img/logo.png';
    }

    public function getStatusList()
    {
        return ['normal' => __('Normal'), 'hidden' => __('Hidden')];
    }

    public function getStatusTextAttr($value, $data)
    {
        $value = $value ?: ($data['status'] ?? '');
        $list = $this->getStatusList();
        return $list[$value] ?? '';
    }

    public function fields()
    {
        return $this->hasMany("\app\admin\model\xunsearch\Fields", "project_id");
    }

}
