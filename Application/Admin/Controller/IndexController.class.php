<?php
namespace Admin\Controller;
use Think\Controller;

class IndexController extends CommonController {
    
    public function index(){
    	//获取文章总数
    	$newsNum = D("News")->getNewsCount(array('status'=>1));
    	//获取文章最大阅读量
    	$newsCount = D("News")->getNewsMaxRead();
    	//获取推荐位个数
    	$positionNum = D("Position")->getCount(array('status'=>1));

	//模板渲染
	$this->assign('newsNum',$newsNum);    	
	$this->assign('newsCount',$newsCount);    	
	$this->assign('positionNum',$positionNum);    	
    	
    	return $this->display();
    }
}
