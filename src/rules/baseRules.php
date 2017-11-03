<?php

/**
 * baseRules created at 2017-11-2 11:36:43
 * The encoding is UTF-8
 * 
 * @author skl@tzg.cn
 */

namespace sjdskl\rules;

use QL\QueryList;

class baseRules
{
    protected $_url;
    protected $_ql;

    public function __construct($url)
    {
        if(!$url) {
            //TODO exception
            return false;
        }
        $this->_url = $url;
        $this->fetch();
    }
    
    public function setUrl($url)
    {
        if(!$url) {
            //TODO exception
            return false;
        }
        
        $this->_url = $url;
    }
    
    public function fetch($url = '')
    {
        $this->_ql = QueryList::get($url ? $url : $this->_url);
    }
    
    public function getHtml()
    {
        return $this->_ql->getHtml();
    }
    
    public function setHtml($html)
    {
        return $this->_ql->setHtml($html);
    }
    
}