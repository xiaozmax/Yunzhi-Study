<?php

namespace addons\clicaptcha\library;

use think\Config;
use think\Exception;

class Clicaptcha
{

    protected $gallery = [
        'square' => '正方形',
        'airplane' => '飞机',
        'dolphin' => '海豚',
        'hamburger' => '汉堡',
        'butterfly' => '蝴蝶',
        'babyfeet' => '脚掌',
        'whale' => '鲸鱼',
        'lipstick' => '口红',
        'hanger' => '晾衣架',
        'hexagon' => '六边形',
        'bottle' => '奶瓶',
        'alarmclock' => '闹钟',
        'triangle' => '三角形',
        'rabbit' => '兔子',
        'banana' => '香蕉',
        'snowflake' => '雪花',
        'cherry' => '樱桃',
        'fishone' => '鱼',
        'round' => '圆形',
        'diamonds' => '钻石'
    ];

    protected $custom = [];
    protected $mode = [];

    protected $options = [];

    public function __construct($options = [])
    {
        if ($config = get_addon_config('clicaptcha')) {
            $this->options = array_merge($this->options, $config);
        }
        $this->options = array_merge($this->options, $options);
        $this->custom = array_map('trim', array_unique(array_filter(explode("\n", str_replace("\r", "", $config['customtext'])))));
        $this->mode = explode(',', $this->options['mode']);
    }

    /**
     * 生成图片
     * @return \think\Response
     * @throws Exception
     */
    public function create()
    {
        $imagePathArr = array_map('trim', array_unique(array_filter(explode(',', $this->options['background']))));
        if (!$imagePathArr) {
            throw new Exception("背景图片不能为空");
        }
        shuffle($imagePathArr);
        $imagePath = ROOT_PATH . 'public' . reset($imagePathArr);
        $fontPath = ROOT_PATH . 'public' . $this->options['font'];
        if (!is_file($imagePath)) {
            throw new Exception("未找到背景图片");
        }
        if (!is_file($fontPath)) {
            throw new Exception("未找到字体文件");
        }

        //获取验证文字和干扰文字
        $text = $this->randChars($this->options['textsize'], $this->options['disturbsize']);

        foreach ($text as $v) {
            $tmp = [];
            if (isset($this->gallery[$v])) {
                //当前为图案
                $tmp['isimage'] = true;
                $tmp['name'] = $v;
                $tmp['text'] = "<{$this->gallery[$v]}>";
                $tmp['size'] = 24;
                $tmp['width'] = 36;
                $tmp['height'] = 36;
            } else {
                $tmp['isimage'] = false;
                $fontSize = rand(20, 24);
                //字符串文本框宽度和长度
                $fontarea = imagettfbbox($fontSize, 0, $fontPath, $v);
                $textWidth = $fontarea[2] - $fontarea[0];
                $textHeight = $fontarea[1] - $fontarea[7];
                $tmp['text'] = $v;
                $tmp['size'] = $fontSize;
                $tmp['width'] = $textWidth;
                $tmp['height'] = $textHeight;
            }
            $textArr['text'][] = $tmp;
        }

        //图片宽高和类型
        list($imageWidth, $imageHeight, $imageType) = getimagesize($imagePath);
        $textArr['width'] = $imageWidth;
        $textArr['height'] = $imageHeight;
        $text = [];

        //随机生成汉字位置
        foreach ($textArr['text'] as &$v) {
            list($x, $y) = $this->randPosition($textArr['text'], $v['text'], $imageWidth, $imageHeight, $v['width'], $v['height']);
            $v['x'] = $x;
            $v['y'] = $y;
            $text[] = $v['text'];
        }
        unset($v);

        $responseText = implode(',', array_slice($text, 0, $this->options['textsize']));
        session('clicaptcha_text', $textArr);
        cookie('clicaptcha_text', $responseText, ['expire' => 600, 'path' => '/', 'prefix' => '', 'httponly' => false]);

        //创建图片的实例
        $image = null;
        $output = '';
        $contentType = '';
        switch ($imageType) {
            case 1 :
                $image = imagecreatefromgif($imagePath);
                $contentType = 'image/gif';
                $output = 'imagegif';
                break;
            case 2 :
                $image = imagecreatefromjpeg($imagePath);
                $contentType = 'image/jpeg';
                $output = 'imagejpeg';
                break;
            case 3 :
                $image = imagecreatefrompng($imagePath);
                $contentType = 'image/png';
                $output = 'imagepng';
                break;
        }
        if (!$image) {
            throw new Exception("读取背景图片错误");
        }

        //渲染图片和文字
        foreach ($textArr['text'] as $v) {
            if ($v['isimage']) {
                //绘画图片
                $stamp = imagecreatefrompng(ADDON_PATH . 'clicaptcha' . DS . 'data' . DS . 'gallery' . DS . $v['name'] . '.png');
                $this->imagecopymerge_alpha($image, $stamp, $v['x'], $v['y'], 0, 0, 36, 36, $this->options['alpha']);
            } else {
                //字体颜色
                $color = imagecolorallocatealpha($image, 230, 230, 230, 127 - intval($this->options['alpha'] * (127 / 100)));
                //绘画文字
                imagettftext($image, $v['size'], 0, $v['x'], $v['y'] + $v['height'], $color, $fontPath, $v['text']);
            }
        }

        //输出图片
        ob_start();
        call_user_func($output, $image);
        imagedestroy($image);
        $content = ob_get_clean();

        return response($content, 200, ['Content-Length' => strlen($content), 'Content-Type' => $contentType, 'X-Clicaptcha-Text' => urlencode($responseText)])->contentType($contentType);
    }

    /**
     * 拷贝透明图片
     */
    protected function imagecopymerge_alpha($dst_im, $src_im, $dst_x, $dst_y, $src_x, $src_y, $src_w, $src_h, $pct)
    {
        $cut = imagecreatetruecolor($src_w, $src_h);
        imagecopy($cut, $dst_im, 0, 0, $dst_x, $dst_y, $src_w, $src_h);
        imagecopy($cut, $src_im, 0, 0, $src_x, $src_y, $src_w, $src_h);
        imagecopymerge($dst_im, $cut, $dst_x, $dst_y, 0, 0, $src_w, $src_h, $pct);
    }

    /**
     * 验证
     * @param string $info
     * @param bool $unset
     * @return bool
     */
    public function check($info, $unset = true)
    {
        $flag = false;
        $textArr = session('clicaptcha_text');
        if ($textArr) {
            list($xy, $w, $h) = explode(';', $info);
            $xyArr = explode('-', $xy);
            $xpro = $w / $textArr['width'];//宽度比例
            $ypro = $h / $textArr['height'];//高度比例
            $textsize = $this->options['textsize'];
            $success = 0;
            $xyArr = array_slice($xyArr, 0, $textsize);
            foreach ($xyArr as $k => $v) {
                $xy = explode(',', $v);
                $x = $xy[0];
                $y = $xy[1];
                if ($x / $xpro < $textArr['text'][$k]['x'] || $x / $xpro > $textArr['text'][$k]['x'] + $textArr['text'][$k]['width']) {
                    $flag = false;
                    break;
                }
                if ($y / $ypro < $textArr['text'][$k]['y'] || $y / $ypro > $textArr['text'][$k]['y'] + $textArr['text'][$k]['height']) {
                    $flag = false;
                    break;
                }
                $success++;
            }
            if ($success == $textsize) {
                $flag = true;
            }
            if ($unset) {
                session('clicaptcha_text', null);
            }
        }
        return $flag;
    }

    /**
     * 随机生成字符
     * @param int $textsize
     * @param int $disturbsize
     * @return array
     */
    private function randChars($textsize = 4, $disturbsize = 2)
    {
        /**
         * 字符串截取，支持中文和其他编码
         * @static
         * @access public
         * @param string $str 需要转换的字符串
         * @param int $start 开始位置
         * @param int $length 截取长度
         * @param string $charset 编码格式
         * @param bool $suffix 截断显示字符
         * @return string
         */
        function msubstr($str, $start = 0, $length = 1, $charset = 'utf-8', $suffix = true)
        {
            if (function_exists('mb_substr')) {
                $slice = mb_substr($str, $start, $length, $charset);
            } else if (function_exists('iconv_substr')) {
                $slice = iconv_substr($str, $start, $length, $charset);
            } else {
                $re['utf-8'] = '/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/';
                $re['gb2312'] = '/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/';
                $re['gbk'] = '/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/';
                $re['big5'] = '/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/';
                preg_match_all($re[$charset], $str, $match);
                $slice = join('', array_slice($match[0], $start, $length));
            }
            return $suffix ? $slice . '...' : $slice;
        }

        $return = [];
        $textsize = $textsize + $disturbsize;

        //文字
        if (in_array('text', $this->mode)) {
            $text = [];
            $chars = '们以我到他会作时要动国产的是工就年阶义发成部民可出能方进在了不和有大这主中人上为来分生对于学下级地个用同行面说种过命度革而多子后自社加小机也经力线本电高量长党得实家定深法表着水理化争现所起政三好十战无农使前等反体合斗路图把结第里正新开论之物从当两些还天资事队批点育重其思与间内去因件日利相由压员气业代全组数果期导平各基或月毛然如应形想制心样干都向变关问比展那它最及外没看治提五解系林者米群头意只明四道马认次文通但条较克又公孔领军流入接席位情运器并飞原油放立题质指建区验活众很教决特此常石强极土少已根共直团统式转别造切九你取西持总料连任志观调七么山程百报更见必真保热委手改管处己将修支识病象几先老光专什六型具示复安带每东增则完风回南广劳轮科北打积车计给节做务被整联步类集号列温装即毫知轴研单色坚据速防史拉世设达尔场织历花受求传口断况采精金界品判参层止边清至万确究书术状厂须离再目海交权且儿青才证低越际八试规斯近注办布门铁需走议县兵固除般引齿千胜细影济白格效置推空配刀叶率述今选养德话查差半敌始片施响收华觉备名红续均标记难存测士身紧液派准斤角降维板许破述技消底床田势端感往神便贺村构照容非搞亚磨族火段算适讲按值美态黄易彪服早班麦削信排台声该击素张密害侯草何树肥继右属市严径螺检左页抗苏显苦英快称坏移约巴材省黑武培著河帝仅针怎植京助升王眼她抓含苗副杂普谈围食射源例致酸旧却充足短划剂宣环落首尺波承粉践府鱼随考刻靠够满夫失包住促枝局菌杆周护岩师举曲春元超负砂封换太模贫减阳扬江析亩木言球朝医校古呢稻宋听唯输滑站另卫字鼓刚写刘微略范供阿块某功套友限项余倒卷创律雨让骨远帮初皮播优占圈伟季训控激找叫云互跟裂粮粒母练塞钢顶策双留误础吸阻故寸盾晚丝女散焊功株亲院冷彻弹错散商视艺灭版烈零室轻血倍缺厘泵察绝富城冲喷壤简否柱李望盘磁雄似困巩益洲脱投送奴侧润盖挥距触星松送获兴独官混纪依未突架宽冬章湿偏纹吃执阀矿寨责熟稳夺硬价努翻奇甲预职评读背协损棉侵灰虽矛厚罗泥辟告卵箱掌氧恩爱停曾溶营终纲孟钱待尽俄缩沙退陈讨奋械载胞幼哪剥迫旋征槽倒握担仍呀鲜吧卡粗介钻逐弱脚怕盐末阴丰雾冠丙街莱贝辐肠付吉渗瑞惊顿挤秒悬姆烂森糖圣凹陶词迟蚕亿矩康遵牧遭幅园腔订香肉弟屋敏恢忘编印蜂急拿扩伤飞露核缘游振操央伍域甚迅辉异序免纸夜乡久隶缸夹念兰映沟乙吗儒汽磷艰晶插埃燃欢铁补咱芽永瓦倾阵碳演威附牙芽永瓦斜灌欧献顺猪洋腐请透司危括脉宜笑若尾束壮暴企菜穗楚汉愈绿拖牛份染既秋遍锻玉夏疗尖殖井费州访吹荣铜沿替滚客召旱悟刺脑措贯藏敢令隙炉壳硫煤迎铸粘探临薄旬善福纵择礼愿伏残雷延烟句纯渐耕跑泽慢栽鲁赤繁境潮横掉锥希池败船假亮谓托伙哲怀割摆贡呈劲财仪沉炼麻罪祖息车穿货销齐鼠抽画饲龙库守筑房歌寒喜哥洗蚀废纳腹乎录镜妇恶脂庄擦险赞钟摇典柄辩竹谷卖乱虚桥奥伯赶垂途额壁网截野遗静谋弄挂课镇妄盛耐援扎虑键归符庆聚绕摩忙舞遇索顾胶羊湖钉仁音迹碎伸灯避泛亡答勇频皇柳哈揭甘诺概宪浓岛袭谁洪谢炮浇斑讯懂灵蛋闭孩释乳巨徒私银伊景坦累匀霉杜乐勒隔弯绩招绍胡呼痛峰零柴簧午跳居尚丁秦稍追梁折耗碱殊岗挖氏刃剧堆赫荷胸衡勤膜篇登驻案刊秧缓凸役剪川雪链渔啦脸户洛孢勃盟买杨宗焦赛旗滤硅炭股坐蒸凝竟陷黎救冒暗洞犯筒您宋弧爆谬涂味津臂障褐陆啊健尊豆拔莫抵桑坡缝警挑污冰柬嘴啥饭塑寄赵喊垫丹渡耳刨虎笔稀昆浪萨茶滴浅拥穴覆伦娘吨浸袖珠雌妈紫戏塔锤震岁貌洁剖牢锋疑霸闪埔猛诉刷狠忽灾闹乔唐漏闻沈熔氯荒男凡抢像浆旁玻亦忠唱蒙予纷捕锁尤乘乌智淡允叛畜俘摸锈扫毕璃宝芯爷鉴秘净蒋钙肩腾枯抛轨堂拌爸循诱祝励肯酒绳穷塘燥泡袋朗喂铝软渠颗惯贸粪综墙趋彼届墨碍启逆卸航衣孙龄岭休借';
            for ($i = 0; $i < $textsize; $i++) {
                $text[] = msubstr($chars, floor(mt_rand(0, mb_strlen($chars, 'utf-8') - 1)), 1, 'utf-8', false);
            }
            $return = array_merge($return, $text);
        }

        //图像
        if (in_array('gallery', $this->mode)) {
            $gallery = array_keys($this->gallery);
            shuffle($gallery);
            $gallery = array_slice($gallery, 0, $textsize);
            $return = array_merge($return, $gallery);
        }
        //自定义
        if (in_array('custom', $this->mode)) {
            $return = array_merge($return, array_slice($this->custom, 0, $textsize));
        }

        shuffle($return);
        $return = array_slice($return, 0, $textsize);
        return $return;
    }

    /**
     * 随机生成位置布局
     * @return array
     */
    private function randPosition($textArr, $text, $imgW, $imgH, $fontW, $fontH)
    {
        $return = array();
        $x = rand(0, $imgW - $fontW);
        $y = rand(0, $imgH - $fontH);
        //碰撞验证
        if (!$this->checkPosition($textArr, $text, $x, $y, $fontW, $fontH)) {
            $return = $this->randPosition($textArr, $text, $imgW, $imgH, $fontW, $fontH);
        } else {
            $return = array($x, $y);
        }
        return $return;
    }

    /**
     * 验证位置是否可用
     * @return bool
     */
    private function checkPosition($textArr, $text, $x, $y, $w, $h)
    {
        $flag = true;
        foreach ($textArr as $v) {
            if ($v['text'] == $text) {
                continue;
            }
            if (isset($v['x']) && isset($v['y'])) {
                //分别判断X和Y是否都有交集，如果都有交集，则判断为覆盖
                $flagX = true;
                if ($v['x'] > $x) {
                    if ($x + $w > $v['x']) {
                        $flagX = false;
                    }
                } else if ($x > $v['x']) {
                    if ($v['x'] + $v['width'] > $x) {
                        $flagX = false;
                    }
                } else {
                    $flagX = false;
                }

                $flagY = true;
                if ($v['y'] > $y) {
                    if ($y + $h > $v['y']) {
                        $flagY = false;
                    }
                } else if ($y > $v['y']) {
                    if ($v['y'] + $v['height'] > $y) {
                        $flagY = false;
                    }
                } else {
                    $flagY = false;
                }
                if (!$flagX && !$flagY) {
                    $flag = false;
                }
            }
        }
        return $flag;
    }

    /**
     * 获取图片某个定点上的主要色
     * @return array
     */
    private function getImageColor($img, $x, $y)
    {
        list($imageWidth, $imageHeight, $imageType) = getimagesize($img);
        switch ($imageType) {
            case 1://GIF
                $im = imagecreatefromgif($img);
                break;
            case 2://JPG
                $im = imagecreatefromjpeg($img);
                break;
            case 3://PNG
                $im = imagecreatefrompng($img);
                break;
        }
        $rgb = imagecolorat($im, $x, $y);
        $r = ($rgb >> 16) & 0xFF;
        $g = ($rgb >> 8) & 0xFF;
        $b = $rgb & 0xFF;
        return array($r, $g, $b);
    }

}
