<?php
namespace Home\Controller;
use Think\Controller;

class IndexController extends CommonController {
    
    public function index(){
        //获取文章排行
        $topCount = $this->getRank();
//        print_r($topNews);exit;
        //获取首页大图数据
        $topNews = D("PositionContent")->select(array('status'=>1,'position_id'=>1),1);
        //获取右侧三条数据
        $topSmallNews = D("PositionContent")->select(array('status'=>1,'position_id'=>2),3);
		//获取页面数据
		$listNews = D("News")->select(array('status'=>1,'thumb'=>array('neq','')),10);
        //获取右侧广告位
//        $advNews = D("PositionContent")->select(array('status'=>1,'position_id'=>3),2);
        
        $this->assign('result',array(
        	'topNews'=>$topNews,
        	'topSmallNews'=>$topSmallNews,
        	'listNews'=>$listNews,	
        	'topCount'=>$topCount,
//        	'advNews'=>$advNews,
       	));
       	
        return $this->display();
    }
}