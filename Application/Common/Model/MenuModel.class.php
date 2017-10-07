<?php
namespace Common\Model;
use Think\Model;

class MenuModel extends Model {
	
	private $_db = '';
	
	//构造函数初始化
	public function __construct(){
		$this->_db = M('Menu');
	}
	/*
	 * @desc 根据用户名寻找用户
	 */
	public function add($data = []){
		//判断数据是否为数组
//		if($data || !is_array($data)){
//			return 0;
//		}
		return $this->_db->add($data);
	}
	/*
	 * @desc 获取指定页数的目录
	 */
	public function getMenus($data,$page,$pageSize=10){
		$data['status'] = array('neq',-1);
		$offset = ($page - 1) * $pageSize;
		$list = $this->_db->where($data)->order('menu_id asc')
			->limit($offset,$pageSize)->select();
		return $list;
	} 
	/*
	 * @desc 获取目录条数
	 */
	public function getMenuCount($data = array()){
		$data['status'] = array('neq',-1);
		return $this->_db->where($data)->count();		
	}
	
	/*
	 * @desc 获取目录条数
	 */
	public function find($id){
		//判断参数的准确性
		if(!$id || !is_numeric($id)){
			return array();
		}
		return $this->_db->where('menu_id='.$id)->find();
	}
	
	/*
	 * @desc 更新目录
	 */
	public function updateMenuById($id,$data){
				
		return $this->_db->where('menu_id='.$id)->save($data);
	}
	
	/*
	 * @desc 更新状态
	 */
	public function updateStatusById($id,$status){
		
		//将$status封装到数组中
		$data['status'] = $status;
		return $this->_db->where('menu_id='.$id)->save($data);
	}
	
	/*
	 * @desc 获取后台所有目录
	 */
	public function getAdminMenus(){
		$data = array(
			'status' => array('neq',-1),
			'type' => 1,
		);
		
		return $this->_db->where($data)->order('menu_id asc')->select();
	}
	
	/*
	 * @desc 获取前端导航
	 */
	public function getBarMenus(){
		$data = array(
			'status' => 1,
			'type' => 0,
		);
		
		$res = $this->_db->where($data)
				->order('menu_id asc')
				->select();
		return $res;				
	}
}
