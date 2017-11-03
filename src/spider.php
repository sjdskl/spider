<?php

/**
 * spider created at 2017-11-2 11:30:29
 * The encoding is UTF-8
 * 
 * @author skl@tzg.cn
 */
namespace sjdskl;

include dirname(__FILE__) . "/../vendor/autoload.php";

use sjdskl\rules\sougou\wechatList;
use sjdskl\rules\wechat\wechatContent;

class spider
{
    const SOUGOU_WECHAT_LIST = 1;
    const WECHAT_CONTENT = 2;
    
    public function __construct()
    {
        ;
    }
    
    public function spider($type = self::SOUGOU_WECHAT, $url = '', $default_sechme = 'http://')
    {
        if($url && stripos($url, 'http') !== 0) {
            $url = $default_sechme . $url;
        }
        
        switch ($type) {
            default: return false;
                case self::SOUGOU_WECHAT_LIST: return new wechatList($url);
                case self::WECHAT_CONTENT: return new wechatContent($url);
            
        }
    }
}