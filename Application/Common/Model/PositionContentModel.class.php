<?php
namespace Common\Model;
use Think\Model;

class PositionContentModel extends Model {
	private $_db = '';

	public function __construct() {
		$this->_db = M('position_content');
	}
	
	/*
	 * @desc 推荐位内容设置
	 */
	public function insert($res=array()) {
//    	if(!$res || !is_array($res)) {
//    		return 0;
//    	}
    	if(!$res['create_time']) {
    		$res['create_time'] = time();
    	}
		
    	return $this->_db->add($res);
    }

    /*
	 * @desc 推荐位内容获取
	 */
    public function select($data = array(),$limit=0) {

		if($data['title']) {
			$data['title'] = array('like', '%'.$data['title'].'%');
		}
		$this->_db->where($data)->order('id desc');
		if($limit) {
			$this->_db->limit($limit);
		}
		$list = $this->_db->select();
		//echo $this->_db->getLastSql();exit;
		return $list;
	}
	
	/*
	 * @desc 推荐内容状态设置
	 */
	public function updateStatusById($id, $status) {
		if(!is_numeric($status)) {
			throw_exception("status不能为非数字");
		}
		if(!$id || !is_numeric($id)) {
			throw_exception("ID不合法");
		}
		$data['status'] = $status;
		return  $this->_db->where('id='.$id)->save($data); 
	}
}
