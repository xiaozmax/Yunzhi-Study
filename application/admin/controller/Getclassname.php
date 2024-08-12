<?php

namespace app\admin\controller;

use app\common\controller\Backend;
use think\Db;

class Getclassname extends Backend
{
    protected $noNeedLogin = ['inpost'];

    public function inpost()
    {
        $classid = $_POST['classid'];
        $data = Db::name('user_group')->where('id',$classid)->column('name');

        return json_encode($data);
    }
}
