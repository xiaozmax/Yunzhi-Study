<?php

namespace app\admin\model;

use think\Model;


class Taskrecord extends Model
{

    

    

    // 表名
    protected $name = 'taskrecord';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;
    protected $deleteTime = false;

    // 追加属性
    protected $append = [
        'subtime_text'
    ];
    

    



    public function getSubtimeTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['subtime']) ? $data['subtime'] : '');
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }

    protected function setSubtimeAttr($value)
    {
        return $value === '' ? null : ($value && !is_numeric($value) ? strtotime($value) : $value);
    }


}
