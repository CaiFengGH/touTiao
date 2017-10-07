<?php
namespace Common\Model;
use Think\Model;

class NewsContentModel extends Model {
	
	private $_db = '';
	
	//构造函数初始化
	public function __construct(){
		$this->_db = M('newsContent');
	}
	
	/*
	 * @desc 添加文章内容
	 */
	public function insert($data){
		$data['create_time'] = time();
		
		if(isset($data['content']) && $data['content']){
			$data['content'] = htmlspecialchars($data['content']);
		}
		
		return $this->_db->add($data);
	}
	
	/*
	 * @desc 根据文章id获取文章内容
	 */
	public function getNewsContentById($newsId){
		
		return $this->_db->where('news_id='.$newsId)->find();
	}
	
	/*
	 * @desc 根据文章id更新文章内容
	 */
	public function updateNewsById($id, $data) {

        if(isset($data['content']) && $data['content']) {
            $data['content'] = htmlspecialchars($data['content']);
        }

        return $this->_db->where('news_id='.$id)->save($data);
    }
	
	
}
