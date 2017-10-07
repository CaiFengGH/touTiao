<?php
namespace Home\Controller;
use Think\Controller;

class CommonController extends Controller {
    
    public function __construct() {
        header("Content-type: text/html; charset=utf-8");
        parent::__construct();
    }
	
	/*
	 * @desc 文章排行
	 */
	public function getRank(){
		$cond['status'] = 1;
		$topCount = D("News")->getTopCount($cond,8);
//		print_r($topNews);exit;
		return $topCount;
	}
	
	/*
	 * @desc 错误页面
	 */
	public function error($message){
		$message = $message ? $message : "系统发生错误";
		//模板渲染
		$this->assign('message',$message);
		return $this->display("Index/error");
	}
}