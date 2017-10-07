<?php
namespace Admin\Controller;
use Think\Controller;

class BasicController extends CommonController{
	
	public function index(){
		$res = D("Basic")->select();
		$this->assign('res',$res);
		
		return $this->display();
	}
	/*
	 * @desc 信息配置的添加
	 */
	public function add(){
		if($_POST){
			//对post数据进行提交
			if(!$_POST['title']){
				return result(0,'标题不存在');
			}
			if(!$_POST['keywords']){
				return result(0,'关键词不存在');
			}
			if(!$_POST['description']){
				return result(0,'描述不存在');
			}
			
			//将信息存储在静态缓存中
			D("Basic")->save($_POST);
			return result(1,'更新成功');
		}else{
			return result(0,'没有提交的数据');
		}
	}
}
