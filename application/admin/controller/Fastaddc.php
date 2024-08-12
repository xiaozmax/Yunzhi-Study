<?php

namespace app\admin\controller;

use think\Controller;
use think\Db;
use think\Request;

class Fastaddc extends Controller
{
    public function index()
    {
        return "<a href='fastaddc/generateClasses'>start</a></br><h1>注意，①先调整生成配置再点击start ②可能会提示失败但已生成，请以数据库状态为准</h1>";
    }
    // 一键生成班级的方法
    public function generateClasses()
    {
        // 获取用户输入的年级、前缀和班级数量
        $grade = '2021';
        $classPrefix = '20';
        $numClasses = 22;

        // 开始事务
        Db::startTrans();

        try {
            // 生成班级并插入到数据库
            for ($i = 1; $i <= $numClasses; $i++) {
                $classNumber = str_pad($i, 2, '0', STR_PAD_LEFT); // 将数字格式化为两位数字，例如：01
                $className = $classPrefix . $classNumber;

                // 使用数据库查询构建器插入数据，假设你的表名为 classes
                Db::name('class')->insert([
                    'name' => $className,
                    'grade' => $grade,
                    'headteacher' => $i,
                ]);
            }

            // 提交事务
            Db::commit();

            // 提示操作成功
            $this->success('班级生成成功', 'index');
        } catch (\Exception $e) {
            // 打印异常信息
            echo $e->getMessage();
            // 发生错误时回滚事务
            Db::rollback();
            // 提示操作失败
            $this->error('班级生成失败');
        }
        
    }
}
