<?php

namespace app\index\controller;

use app\common\controller\Frontend;
use think\Cookie;
use think\Db;

class Index extends Frontend
{
    protected $noNeedLogin = '*';
    protected $noNeedRight = '*';
    protected $layout = '';

    public function get_secname()
    {
        if (!Db::name('config')->where('id', 2)->value('value')) {
            $secsitename = 'Powered By 芸志信息';
        } else {
            $secsitename = '由芸志信息开发';
        }

        return $secsitename;
    }

    public function index()
    {
        if (session('user_id')) {
            $user = session('user_info');
            $this->assign('user', $user);
        }
        if (!Db::name('config')->where('id', 2)->value('value')) {
            $secsitename = 'Powered By 芸志信息';
        } else {
            $secsitename = '由芸志信息开发';
        }
        //$style = cookie('style');
        //if ($style == '2') {
        return $this->fetch('index_new', ['sitename' => Db::name('config')->where('id', 1)->value('value'), 'secsitename' => $secsitename, 'message' => '暂无']);
        //}

        //return $this->fetch('index', ['sitename' => Db::name('config')->where('id', 1)->value('value'), 'secsitename' => $secsitename, 'message' => '暂无']);
    }

    public function class()
    {
        if (session('user_id')) {
            $user = session('user_info');
            $this->assign('user', $user);
        }
        if (!Db::name('config')->where('id', 2)->value('value')) {
            $secsitename = 'Powered By 芸志信息';
        } else {
            $secsitename = '由芸志信息开发';
        }

        return $this->fetch('class', ['sitename' => Db::name('config')->where('id', 1)->value('value'), 'secsitename' => $secsitename, 'message' => '暂无']);
    }

    public function contentlist()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // 处理POST请求
        $category = isset($_POST['category']) ? $_POST['category'] : null; // 分类ID
        $pagesize = isset($_POST['size']) ? $_POST['size'] : 10; // 每页显示数量
        $pagenow = isset($_POST['pagenow']) ? $_POST['pagenow'] : 1; // 当前页码

        // 构建查询条件
            $where = [];
            if ($category) {
                $where['category_id'] = $category;
            }
            $whereArr['isshow'] = ['neq', 0];
            // 实例化模型
            $articleModel = new \app\admin\model\Article();

            // 使用分页
            $articles = $articleModel->where($where)->where($whereArr)//->Field('article_id,category_id,title,weight,isshow')
            ->order('weight desc, article_id desc')
            ->paginate($pagesize, false, [
                'page' => $pagenow,
            ]);

            // 返回文章列表数据
            return json($articles);
        } else {
            // 处理GET请求
            if (session('user_id')) {
                $user = session('user_info');
                $this->assign('user', $user);
            }

            $sitename = Db::name('config')->where('id', 1)->value('value');
            $secsitename = Db::name('config')->where('id', 2)->value('value') ?: 'Powered By 芸志信息';

            $this->assign('sitename', $sitename);
            $this->assign('secsitename', $secsitename);

            // 返回视图
            //$style = cookie('style');
            //if ($style == '2') {
            return $this->fetch('contentlist_new', ['sitename' => Db::name('config')->where('id', 1)->value('value'), 'secsitename' => $secsitename, 'message' => '暂无']);
            //}

            //return $this->fetch('contentlist');
        }
    }

    public function get_category()
    {
        $categorylist = Db::name('category')->where('type', 'article')->select();

        return json($categorylist);
    }

    public function get_content($page, $limit)
    {
        return '6';
    }

    public function content()
    {
        $content = Db::table('fa_article')->where('article_id', htmlspecialchars($_GET['id']))->value('content');
        $title = Db::table('fa_article')->where('article_id', htmlspecialchars($_GET['id']))->value('title');
        $cid = Db::table('fa_article')->where('article_id', htmlspecialchars($_GET['id']))->value('category_id');
        $category = Db::table('fa_category')->where('id', $cid)->value('name');
        $showedtimes = Db::table('fa_article')->where('article_id', htmlspecialchars($_GET['id']))->value('showedtimes') + 1;
        if (!$content) {
            return '<center><h1>404 NOT FOUND</h1>';
        }
        if (!Db::name('config')->where('id', 2)->value('value')) {
            $secsitename = 'Powered By 芸志信息';
        } else {
            $secsitename = '由芸志信息开发';
        }
        Db::table('fa_article')->where('article_id', htmlspecialchars($_GET['id']))->update(['showedtimes' => $showedtimes]);
        error_reporting(0);
        //$style = cookie('style');
        //if ($style == '2') {
        return $this->fetch('content_new', ['content' => $content, 'title' => $title, 'sitename' => Db::name('config')->where('id', 1)->value('value'), 'secsitename' => $secsitename, 'message' => '暂无', 'category' => $category, 'id' => $_GET['id']]);
        //}

        //return $this->fetch('content', ['content' => $content, 'title' => $title, 'sitename' => Db::name('config')->where('id', 1)->value('value'), 'secsitename' => $secsitename, 'message' => '暂无', 'category' => $category, 'id' => $_GET['id']]);
    }

    public function contentdat()
    {
        $content = Db::table('fa_article')->where('article_id', htmlspecialchars($_GET['id']))->value('content');
        $title = Db::table('fa_article')->where('article_id', htmlspecialchars($_GET['id']))->value('title');
        $cid = Db::table('fa_article')->where('article_id', htmlspecialchars($_GET['id']))->value('category_id');
        $category = Db::table('fa_category')->where('id', $cid)->value('name');
        if (!$content) {
            return '<center><h1>404 NOT FOUND</h1>';
        }
        if (!Db::name('config')->where('id', 2)->value('value')) {
            $secsitename = 'Powered By 芸志信息';
        } else {
            $secsitename = '由芸志信息开发';
        }
        error_reporting(0);

        return $this->fetch('contentdat', ['content' => $content, 'title' => $title, 'sitename' => Db::name('config')->where('id', 1)->value('value'), 'secsitename' => $secsitename, 'message' => '暂无', 'category' => $category]);
    }

    public function help()
    {
        if (session('user_id')) {
            $user = session('user_info');
            $this->assign('user', $user);
        }
        if (!Db::name('config')->where('id', 2)->value('value')) {
            $secsitename = 'Powered By 芸志信息';
        } else {
            $secsitename = '由芸志信息开发';
        }
        //$style = cookie('style');
        //if ($style == '2') {
        return $this->fetch('help_new', ['sitename' => Db::name('config')->where('id', 1)->value('value'), 'secsitename' => $secsitename, 'message' => '暂无']);
        //}

        //return $this->fetch('help', ['sitename' => Db::name('config')->where('id', 1)->value('value'), 'secsitename' => $secsitename, 'message' => '暂无']);
    }

    public function about()
    {
        if (session('user_id')) {
            $user = session('user_info');
            $this->assign('user', $user);
        }
        if (!Db::name('config')->where('id', 2)->value('value')) {
            $secsitename = 'Powered By 芸志信息';
        } else {
            $secsitename = '由芸志信息开发';
        }
        //$style = cookie('style');
        //if ($style == '2') {
        return $this->fetch('about_new', ['sitename' => Db::name('config')->where('id', 1)->value('value'), 'secsitename' => $secsitename, 'message' => '暂无']);
        //}

        //return $this->fetch('about', ['sitename' => Db::name('config')->where('id', 1)->value('value'), 'secsitename' => $secsitename, 'message' => '暂无']);
    }

    public function change_style()
    {
        return 'err';
        if ($_GET['id'] == '1') {
            Cookie::set('style', '1', 36000);

            return 'change to old';
        } else {
            Cookie::set('style', '2', 36000);

            return 'change to new';
        }
    }
}
