<?php
namespace Admin\Controller;
use Think\Controller;

class LoginController extends Controller {
	
    /*
     * @desc session校验是否用户存在
     */
    public function index(){
    	//判断session中adminUser是否存在
    	if(session('adminUser')){
    		return $this->redirect('/admin.php?c=index');
    	}
    	return $this->display();
    }
    
    /*
     * @desc 用户名和密码校验
     */
    public function check(){
		//获取用户名和密码
    	$username = $_POST['username'];
    	$password = $_POST['password'];

		//基本校验用户名和密码
		if(!trim($username)){
			return result(0,'用户名不能为空');
		}		
		if(!trim($password)){
			return result(0,'密码不能为空');
		}		
//		print_r($username);exit;	
		
		//从数据库中获取
		$res = D('Admin')->getAdminByUsername($username);
		if(!$res || $res['status'] != 1){
			return result(0,'该用户不存在');
		}
		
		if($res['password'] != md5($password)){
			return result(0,'密码不正确');
		}
		
		//验证从数据库中提取的数据
//		print_r($res);exit;	
		
		//更新用户最后一次登陆时间
		D('Admin')->updateLogintimeByUsername($res['username'],array('lastlogintime'=>time()));
		
		//保存在session中
		session('adminUser',$res);
		return result(1,'登录成功');
    }
    
    /*
     * @desc 用户名和密码校验
     */
    public function loginout(){
		 session('adminUser',null);
		 $this->redirect('/amdin.php?c=login');   	
    } 
}