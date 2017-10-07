<?php
namespace Common\Model;
use Think\Model;

class AdminModel extends Model {
	
	private $_db = '';
	
	//构造函数初始化
	public function __construct(){
		$this->_db = M('admin');
	}
	/*
	 * @desc 根据用户名寻找用户
	 */
	public function getAdminByUsername($username=''){
		$res = $this->_db->where('username="'.$username.'"')->find();
//        var_dump($res);
        return $res;
	}
	/*
	 * @desc 更新用户的最新登陆时间
	 */
	public function updateLogintimeByUsername($username,$data){
		//参数校验
//		if(!$id || !is_numeric($id)){
//			throw Exception("ID不合法");
//		}
//		if(!$data || !is_array($data)){
//			throw Exception("数据不是数组");
//		}
		return $this->_db->where('username="'.$username.'"')->save($data);
	}
}
