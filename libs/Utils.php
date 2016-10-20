<?php

namespace libs;

use Yii;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * 通用工具类
 *
 * @package libs
 */
class Utils
{

    /**
     * 用于调试的变量输出
     *
     * @param      $data 要打印的变量
     * @param bool $end  程序中断开关
     *
     * @throws \yii\base\ExitException
     */
    public static function dump($data, $end = true)
    {
        echo Html::tag('pre', print_r($data, true));

        if($end){
            Yii::$app->end();
        }
    }

    /**
     * 生成页面 Title
     *
     * @param $title
     *
     * @return string
     */
    public static function headTitle($title)
    {
        if(is_array($title)){
            $title = join(" - ", $title);
        }

        if($title){
            $title = " - " . $title;
        }

        return Html::encode(Yii::$app->name . $title);
    }

    /**
     * 获取 Cookie
     *
     * @param string $key
     * @param string $default
     *
     * @return mixed
     */
    public static function getCookie($key, $default = '')
    {
        return Yii::$app->request->getCookies()->getValue($key, $default);
    }

    /**
     * 写入 Cookie
     *
     * @param string $key
     * @param string $value
     */
    public static function setCookie($key, $value)
    {
        return Yii::$app->request->getCookies()->add(new Cookie([
            'name' => $key,
            'value' => $value,
        ]));
    }

    /**
     * 去掉字串中的 html 标签代码
     *
     * @param string $string 要处理的字符串
     *
     * @return string
     */
    public static function emptyTag($string)
    {
        if($string){
            $string = strip_tags(trim($string));
            $string = preg_replace("|&.+?;|", '', $string);
        }

        return $string;
    }

    /**
     * 遍历生成目录
     *
     * @param string $dirpath 要生成的目录路径
     *
     * @return string
     */
    public static function mkdir($dirpath)
    {
        $root = Yii::getAlias('@webroot') . DS;
        $root = preg_replace('/[\\\\\/]/', DS, $root);
        $dirpath = preg_replace('/[\\\\\/]/', DS, $dirpath);
        
        if($dirpath != $root && !file_exists($dirpath)){
            $path = explode(DS, str_replace($root, '', $dirpath));
            
            $dirpath = $root . array_shift($path);
            
            if(!file_exists($dirpath)){
                @mkdir($dirpath);
                @chmod($dirpath, 0777);
            }

            foreach($path as $dir){
                $dirpath .= DS . $dir;

                if($dir != '.' && $dir != '..'){
                    if(!file_exists($dirpath)){
                        @mkdir($dirpath);
                        @chmod($dirpath, 0777);
                    }
                }
            }
        }

        return $dirpath;
    }

    /**
     * 遍历删除目录以及其所有子目录和文件
     *
     * @param string $folder 要删除的目录路径
     *
     * @return bool
     */
    public static function rmdir($folder)
    {
        set_time_limit(0);
        
        if(!file_exists($folder)){
            return false;
        }
        
        $files = array_diff(scandir($folder), ['.', '..']);
        
        foreach ($files as $file) {
            $file = $folder . DIRECTORY_SEPARATOR . $file;
            (is_dir($file) && !is_link($folder)) ? self::rmdir($file) : unlink($file);
        }
        
        return rmdir($folder);
    }

    /**
     * 获取绝对物理路径
     *
     * @param string $path 获取指定路径的绝对路径的相对目录路径
     *
     * @return string
     */
    public static function staticFolder($path = NULL)
    {
        if($path){
            $path = Yii::getAlias('@webroot/' . ltrim($path, '/'));
        }

        return $path;
    }

    /**
     * 获取绝对网址路径
     *
     * @param string $path 要生成静态文件绝对网址的相对目录路径
     *
     * @return string
     */
    public static function staticUrl($path = NULL)
    {
        if($path){
            $path = Url::to('@web/' . ltrim($path, '/'));
        }

        return $path;
    }

    /**
     * 生成文件名
     *
     * @param string $ext 文件后缀
     *
     * @return string
     */
    public static function newFileName($ext)
    {
        list($usec, $sec) = explode(" ", microtime());

        $fix = substr($usec, 2, 4);

        return date('YmdHis') . $fix . "." . ltrim($ext, ".");
    }

    /**
     * 将文件保存
     *
     * @param string $file 目标文件
     * @param string $source 源文件
     *
     * @return boolean
     */
    public static function saveFile($file, $source)
    {
        if(@copy($source, $file)){
            return true;
        }else{
            if(function_exists('move_uploaded_file') && @move_uploaded_file($source, $file)){
                return true;
            }else{
                if(@is_readable($source) && (@$fp_s = fopen($source, 'rb')) && (@$fp_t = fopen($file, 'wb'))){

                    while(!feof($fp_s)){
                        $s = @fread($fp_s, 1024 * 512);
                        @fwrite($fp_t, $s);
                    }

                    fclose($fp_s);
                    fclose($fp_t);

                    return true;
                }else{
                    return false;
                }
            }
        }
    }

    /**
     * 生成随机字符串
     *
     * @param integer $len 要获得的随机字符串长度
     * @param bool    $onlyNum
     *
     * @return string
     */
    public static function getRand($len = 12, $onlyNum = false)
    {
        $chars = $onlyNum ? '0123456789' : 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        mt_srand((double)microtime() * 1000000 * getmypid());
        $return = '';
        while(strlen($return) < $len){
            $return .= substr($chars, (mt_rand() % strlen($chars)), 1);
        }

        return $return;
    }

    /**
     * UTF8 字符串截取
     *
     * @param string  $str 要截取的字符串
     * @param integer $start 截取起始位置
     * @param integer $len 截取长度
     *
     * @return string
     */
    public static function substr($str, $start = 0, $len = 50)
    {
        return mb_strlen($str) > $len ? mb_substr($str, $start, $len, 'UTF-8') . "…" : $str;
    }

    /**
     * 字符串中间部分星号加密
     * 如果是邮箱地址，则只加密位于 @ 前的字串
     *
     * @param string $str 要星号加密的字符串
     *
     * @return string
     */
    public static function starcode($str)
    {
        $suffix = '';

        if(filter_var($str, FILTER_VALIDATE_EMAIL)){
            list($str, $suffix) = explode("@", $str);
        }

        $len = intval(strlen($str) / 2);
        $str = substr_replace($str, str_repeat('*', $len), ceil(($len) / 2), $len);

        return $suffix ? $str . '@' . $suffix : $str;
    }
}

?>