<?php

/**
 * sougou created at 2017-11-2 11:30:11
 * The encoding is UTF-8
 * 
 * @author skl@tzg.cn
 */

namespace sjdskl\rules\wechat;

use sjdskl\rules\baseRules;

class wechatContent extends baseRules
{
    public $title;
    public $content;
    public $author;
    //发布时间
    public $publish_time;
    //二维码
    public $qr;
    public $qr_path;

    public function __construct($url, $path = 'qrcodes/')
    {
        parent::__construct($url);
        $this->qr_path = $path;
    }
    
    public function setQrPath($path)
    {
        $this->qr_path = $path;
    }
    
    public function getRow()
    {
        return [
          'title' => $this->title,
          'content' => $this->content,
          'author' => $this->author,
          'publish_time' => $this->publish_time,
          'qr' => $this->qr,
        ];
    }
    
    public function analysisPage()
    {
        //特殊处理 <!--headTrap<body></body><head></head><html></html>-->
        $this->_ql = $this->_ql->setHtml(substr($this->_ql->getHtml(), 55));
        $this->title = $this->_ql->find('title')->text();
        $this->content = $this->_ql->find('div[class="rich_media_content "]')->html();
        $this->author = $this->_ql->find('a[id="post-user"]')->text();
        $this->publish_time = $this->_ql->find('em[id="post-date"]')->text();
        //取二维码地址
        preg_match('/window.sg_qr_code=\".*\"/', $this->_ql->getHtml(), $qrcode);
        if($qrcode && isset($qrcode[0])) {
            $qr_url = 'https://mp.weixin.qq.com' . str_replace('"', '', str_replace("window.sg_qr_code=\"", "", $qrcode[0]));
            $qr_url = str_replace('\x26amp;', '&', $qr_url);
            $this->qr = $this->qr_path . md5($this->_url) . '.jpg';
            //存放二维码地址
            file_put_contents($this->qr, file_get_contents($qr_url));
        }
    }
    
}