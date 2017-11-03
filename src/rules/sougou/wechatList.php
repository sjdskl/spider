<?php

/**
 * sougou created at 2017-11-2 11:30:11
 * The encoding is UTF-8
 * 
 * @author skl@tzg.cn
 */

namespace sjdskl\rules\sougou;

use sjdskl\rules\baseRules;
use QL\QueryList;

class wechatList extends baseRules
{

    private $_list;
    private $_page        = 0;
    private $_max_page    = 5;
    private $_page_url    = "http://weixin.sogou.com/pcindex/pc/pc_0/";
    private $_default_url = 'http://weixin.sogou.com';

    public function __construct($url = '')
    {
        if (!$url) {
            $url = $this->_default_url;
        }
        parent::__construct($url);
    }
    
    public function setMaxPage($max)
    {
        $this->_max_page = $max;
    }

    public function getList()
    {
        return $this->_list;
    }

    public function fetchPage()
    {
        if ($this->_page >= $this->_max_page) {
            return false;
        }
        if($this->_page) {
            $url = $this->_page_url . $this->_page . ".html";
            $this->fetch($url);
        }
        $this->_analysisPage();
        $this->_page ++;
        return true;
    }

    private function _analysisPage()
    {
        $this->_list = $this->_ql->rules([
                  'title' => array('li[d!=""]>div[class="txt-box"]>h3>a', 'text'),
                  'link'  => array('li[d!=""]>div[class="txt-box"]>h3>a', 'href'),
                  'image' => array('li[d!=""]>div[class="img-box"]>a>img', 'src'),
                  'id' => array('li[d!=""]', 'd'),
                ])->query()->getData()->all();
    }

}
