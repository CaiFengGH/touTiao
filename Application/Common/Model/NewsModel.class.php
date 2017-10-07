<?php
namespace Common\Model;
use Think\Model;

class NewsModel extends Model {
	
	private $_db = '';
	
	//构造函数初始化
	public function __construct(){
		$this->_db = M('news');
	}
	/*
	 * @desc 添加新闻内容
	 */
	public function insert($data){
		$data['create_time'] = time();
		$data['username'] = getLoginUsername();
		
		return $this->_db->add($data);
	}
	/*
	 * @desc 获取新闻内容
	 */	
    public function getNews($data,$page,$pageSize=10) {
        $conditions = $data;
        if(isset($data['title']) && $data['title']) {
            $conditions['title'] = array('like','%'.$data['title'].'%');
        }
        if(isset($data['catid']) && $data['catid'])  {
            $conditions['catid'] = intval($data['catid']);
        }
        
        $conditions['status'] = array('neq',-1);

        $offset = ($page - 1) * $pageSize;
        $list = $this->_db->where($conditions)
            ->order('count desc')
            ->limit($offset,$pageSize)
            ->select();

        return $list;
    }

	/*
	 * @desc 获取新闻内容
	 */	
    public function getNewsCount($data = array()){
        $conditions = $data;
        if(isset($data['title']) && $data['title']) {
            $conditions['title'] = array('like','%'.$data['title'].'%');
        }
        if(isset($data['catid']) && $data['catid'])  {
            $conditions['catid'] = intval($data['catid']);
        }
        $conditions['status'] = array('neq',-1);
		
        return $this->_db->where($conditions)->count();
    }
    
    /*
	 * @desc 更新状态
	 */	
    public function updateStatusById($id,$status){
    	//进行参数校验
    	
    	$data['status'] = $status;
    	return $this->_db->where('news_id='.$id)->save($data);
    }
    
    /*
	 * @desc 根据id获取内容
	 */	
    public function getNewsById($newsId){
    	
    	return $this->_db->where('news_id='.$newsId)->find();
    }

	/*
	 * @desc 根据id进行更新
	 */	
    public function updateById($id, $data) {
//        if(!$id || !is_numeric($id) ) {
//            throw_exception("ID不合法");
//        }
//        if(!$data || !is_array($data)) {
//            throw_exception('更新数据不合法');
//        }

        return $this->_db->where('news_id='.$id)->save($data);
    }
    
    /*
	 * @desc 根据推荐选择的id进行更新
	 */	
    public function getNewsByNewsIdIn($newsIds) {
//        if(!is_array($newsIds)) {
//            throw_exception("参数不合法");
//        }

        $data = array(
            'news_id' => array('in',implode(',', $newsIds)),
        );

        return $this->_db->where($data)->select();
    }
    /*
     * @desc 前台主页列表
     */
    public function select($data = array(), $limit = 3) {

        $conditions = $data;
        $list = $this->_db->where($conditions)->order('count desc')->limit($limit)->select();
        return $list;
    }
    
    /*
     * @desc 获取文章排行前10
     */
    public function getTopCount($data,$limit = 10){
    	
    	return $this->_db->where($data)
    			->order('count desc,news_id desc')
    			->limit($limit)
    			->select();
    }
    
    /*
     * @desc 根据文章id获取文章的内容
     */
    public function find($id){
    	
    	return $this->_db->where('news_id='.$id)->find();
    }
    
    /*
     * @desc 更新文章的阅读量
     */
    public function updateCount($id,$count){
    	//参数校验 
    	$data['count'] = $count;
        return $this->_db->where('news_id='.$id)->save($data);
    }
    
    /*
     * @desc 获取文章最大阅读量
     */
    public function getNewsMaxRead(){
    	$data = array(
    		'status' => 1,
    	);
    	
    	return $this->_db->where($data)
    			->order('count desc')
    			->limit(1)->find();
    }
}
