<?php
namespace Admin\Controller;
use Think\Controller;

class CommonController extends Controller {

	public function __construct() {
		parent::__construct();
		$this->_init();
	}
	/*
     * @desc 初始化函数
     */
	private function _init() {
		// 如果已经登录
		$isLogin = $this->isLogin();
		if(!$isLogin) {
			// 跳转到登录页面
			$this->redirect('/index.php?m=admin&c=login');
		}
	}

	/*
     * @desc 获取session
     */
	public function getLoginUser() {
		return session("adminUser");
	}

	/*
     * @desc 判断是否已经登陆
     */
	public function isLogin() {
		$user = $this->getLoginUser();
		if($user && is_array($user)) {
			return true;
		}
		return false;
	}

}