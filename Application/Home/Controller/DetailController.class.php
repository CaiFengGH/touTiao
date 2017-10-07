<?php
namespace Home\Controller;
use Think\Controller;

class DetailController extends CommonController {
    
	public function index() {
        $id = intval($_GET['id']);
//        print_r($id);exit;
        if(!$id || $id<0) {
            return $this->error("ID不合法");
        }

        $news =  D("News")->find($id);
//		print_r($news);exit;

        if(!$news || $news['status'] != 1) {
            return $this->error("ID不存在或者资讯被关闭");
        }

        $count = intval($news['count']) + 1;
        D('News')->updateCount($id, $count);

        $content = D("NewsContent")->getNewsContentById($id);
        $news['content'] = htmlspecialchars_decode($content['content']);

        $topCount = $this->getRank();

        $this->assign('result', array(
            'topCount' => $topCount,
            'catId' => $news['catid'],
            'news' => $news,
        ));

        $this->display("Detail/index");
    }
}