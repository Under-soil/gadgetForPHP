<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class verify {
    private $charset = 'abcdefghkmnprstuvwxyzABCDEFGHKMNPRSTUVWXYZ1234567890';//随机因子
    private $code;//验证码
    private $code_len = 4;//验证码长度
    private $width = 130;//宽度
    private $height = 50;//高度
    private $img;//图形资源句柄
    private $font;//指定的字体
    private $font_size = 20;//指定字体大小
    private $font_color;//指定字体颜色

    //构造方法初始化
    public function __construct($config)
    {
        $ttfPath = $config['path'] . '/other/verify/ttfs/';
        $this->width = isset($config['width']) ? $config['width'] : $this->width;
        $this->height = isset($config['height']) ? $config['height'] : $this->height;
        $this->charset = isset($config['charset']) ? $config['charset'] : $this->charset;

        if (empty($this->font))
        {
            $dir = dir($ttfPath);
            $ttfs = array();
            while (false !== ($file = $dir->read()))
            {
                if ($file[0] != '.' && substr($file, -4) == '.ttf')
                {
                    $ttfs[] = $file;
                }
            }
            $dir->close();
            $this->font = $ttfs[array_rand($ttfs)];
        }
        $this->font = $ttfPath . $this->font;
    }

    //生成随机码
    private function createCode()
    {
        $_len = strlen($this->charset) - 1;
        for ($i=0; $i<$this->code_len; $i++)
        {
            $this->code .= $this->charset[mt_rand(0, $_len)];
        }
    }
    //生成背景
    private function createBg()
    {
        $this->img = imagecreatetruecolor($this->width, $this->height);
        $color = imagecolorallocate($this->img, mt_rand(157, 255), mt_rand(157, 255), mt_rand(157, 255));
        imagefilledrectangle($this->img, 0, $this->height, $this->width, 0, $color);
    }
    //生成文字
    private function createFont()
    {
        $_x = $this->width / $this->code_len;
        for ($i=0; $i<$this->code_len; $i++)
        {
            $this->font_color = imagecolorallocate($this->img, mt_rand(0, 156), mt_rand(0, 156), mt_rand(0, 156));
            imagettftext($this->img, $this->font_size, mt_rand(-30, 30),$_x * $i + mt_rand(1, 5),$this->height / 1.4,$this->font_color, $this->font, $this->code[$i]);
        }
    }
    //生成线条、雪花
    private function createLine()
    {
        //线条
        for ($i=0; $i<6; $i++)
        {
            $color = imagecolorallocate($this->img, mt_rand(0, 156), mt_rand(0, 156), mt_rand(0, 156));
            imageline($this->img, mt_rand(0, $this->width), mt_rand(0, $this->height), mt_rand(0, $this->width), mt_rand(0, $this->height), $color);
        }
        //雪花
        for ($i=0; $i<100; $i++)
        {
            $color = imagecolorallocate($this->img, mt_rand(200, 255), mt_rand(200, 255), mt_rand(200, 255));
            imagestring($this->img, mt_rand(1, 5), mt_rand(0, $this->width), mt_rand(0, $this->height),'*', $color);
        }
    }
    //输出
    private function outPut()
    {
        header('Content-type:image/png');
        imagepng($this->img);
        imagedestroy($this->img);
    }
    //对外生成
    public function doimg()
    {
        $this->createBg();
        $this->createCode();
        $this->createLine();
        $this->createFont();
        $this->outPut();
    }
    //获取验证码
    public function getCode()
    {
        return strtolower($this->code);
    }
}