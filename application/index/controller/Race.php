<?php

namespace app\index\controller;

use app\common\controller\Frontend;
use think\Cookie;
use think\Db;

class Race extends Frontend
{
    protected $noNeedLogin = '*';
    protected $noNeedRight = '*';
    protected $layout = '';

    public function index()
    {
        //$getdata = file_get_contents('https://huodong.ncet.edu.cn/');
        $getdata = self::http_data('https://huodong.ncet.edu.cn/',[],);
        $test = strpos($getdata,'正在努力加载中',0);
        echo 'alert('.$test.')';
        return $getdata;
    }
    
    function http_data($url,Array $data,$method='get')
{
    $time_out = 30;//超时时间
    if(!function_exists('curl_init'))  //如果不支持curl，使用file_get_content进行采集
    {
        $data_query = http_build_query($data);
        if('post' == strtolower($method))
        {
            $opts = array(  
                'http'=>array(
                    'method'=>"POST",
                    'timeout'=>$time_out,
                    'header'=>"Content-type: application/x-www-form-urlencoded\r\n".
                              "Content-length:".strlen($data_query)."\r\n",
                    'content' => $data_query,
                )
            );
            $format_url = $url;
        }
        else
        {
            $opts = array(
                'http'=>array(
                    'method'=>"GET",
                    'timeout'=>$time_out,
                )
            );
            $format_url = $url . (strpos($url,'?')===false ? ('?'.$data_query) : ('&' . $data_query));
        }
        $cxContext = stream_context_create($opts);
        $response = file_get_contents($format_url, false, $cxContext);
    }
    else
    {
        $ch = curl_init();
        //初始化一个 CURL对象 
        curl_setopt($ch, CURLOPT_TIMEOUT, $time_out);
        curl_setopt($ch, CURLOPT_HEADER, false);   //设定是否显示头信息
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // 设置CURL 参数，要求结果保存到字符串中还是输出到屏幕上
        //curl_setopt($curl, CURLOPT_NOBODY, true);//设定是否输出页面内容 
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $time_out);

        if('post' == strtolower($method))
        {
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }
        else
        {
            $data_query = http_build_query($data);
            $format_url = $url . (strpos($url,'?')===false ? ('?'.$data_query) : ('&' . $data_query));
            curl_setopt($ch, CURLOPT_URL, $format_url);
        }
        $response = curl_exec($ch);
        // 关闭URL请求 
        curl_close($ch);
    }

    return $response;
}

}
