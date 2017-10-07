<?php
namespace Common\Model;
use Think\Model;

class BasicModel extends Model {
	
	//构造函数初始化
	public function __construct(){
		
	}
	
	/*
	 * @desc 将配置存储在缓存中
	 */
	public function save($data = array()){
		//异常参数校验
		if(!$data){
			throw_exception("没有数据提交");
		}
		$id = F('web_config',$data);
		return $id;
	}
	
	public function select(){
		return F('web_config');
	}
}
