<?php

/**
 * sgwx created at 2017-11-3 10:19:25
 * The encoding is UTF-8
 * 
 * @author skl@tzg.cn
 */

include "../spider.php";

use sjdskl\spider;

$sp = new spider();
$wechat_list = $sp->spider(spider::SOUGOU_WECHAT_LIST);
while($wechat_list->fetchPage()) {
    $list = $wechat_list->getList();
    if($list) {
        foreach($list as $key => $row) {
            $page = $sp->spider(spider::WECHAT_CONTENT, $row['link']);
            $page->setQrPath('../qrcodes/');
            $page->analysisPage();
            file_put_contents('test.txt',  $page->title . '-' . $page->author . '-' . $page->publish_time . '-' . $page->qr . "\n", FILE_APPEND);
        }
    }        
}