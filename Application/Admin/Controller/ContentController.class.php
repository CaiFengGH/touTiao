<?php
namespace Admin\Controller;
use Think\Controller;
use Think\Exception;

class ContentController extends CommonController {
	
    public function index(){
		
		$conds = array();
        $title = $_GET['title'];
        
        if($title) {
            $conds['title'] = $title;
        }
        
        if($_GET['catid']) {
            $conds['catid'] = intval($_GET['catid']);
        }

        $page = $_REQUEST['p'] ? $_REQUEST['p'] : 1;
        $pageSize = 6;

        $news = D("News")->getNews($conds,$page,$pageSize);
        $count = D("News")->getNewsCount($conds);

        $res  =  new \Think\Page($count,$pageSize);
        $pageres = $res->show();    	
    	
        $positions = D("Position")->getNormalPositions();
    	
    	$this->assign('pageres',$pageres);
        $this->assign('news',$news);
    	$this->assign('barMenus',D("Menu")->getBarMenus());
        $this->assign('positions', $positions);
        		    	
    	return $this->display();
    }
    /*
	 * @desc 文章添加
	 */
    public function add(){
    	if($_POST){
    		//验证标题是否存在
            if(!isset($_POST['title']) || !$_POST['title']) {
                return result(0,'标题不存在');
            }
            //验证短标题是否存在
            if(!isset($_POST['small_title']) || !$_POST['small_title']) {
                return result(0,'短标题不存在');
            }
            //验证文档栏目是否存在
            if(!isset($_POST['catid']) || !$_POST['catid']) {
                return result(0,'文章栏目不存在');
            }
            //验证关键字是否存在
            if(!isset($_POST['keywords']) || !$_POST['keywords']) {
                return result(0,'关键字不存在');
            }
            //验证内容是否存在
            if(!isset($_POST['content']) || !$_POST['content']) {
                return result(0,'content不存在');
            }
            
            //编辑按钮的检查
            if($_POST['news_id']){
                return $this->save($_POST);
            }
            
            $newsId = D("News")->insert($_POST);
            if($newsId) {
                $newsContentData['content'] = $_POST['content'];
                $newsContentData['news_id'] = $newsId;
                $cId = D("NewsContent")->insert($newsContentData);
                if($cId){
                    return result(1,'新增成功');
                }else{
                    return result(1,'主表插入成功，副表插入失败');
                }

            }else{
                return result(0,'新增失败');
            }
    	}else{
    		
	    	//获取前端导航
	    	$barMenus = D("Menu")->getBarMenus();
	    	//获取颜色
	    	$titleColor = C("TITLE_FONT_COLOR");
	    	//获取来源
	    	$copyFrom = C("COPY_FROM");
	    	
	    	//模板渲染
	    	$this->assign('barMenus',$barMenus);
	    	$this->assign('titleColor',$titleColor);
	    	$this->assign('copyFrom',$copyFrom);
	    	
	    	return $this->display();
    	}
    }
    
    /*
	 * @desc 文章编辑时保存
	 */
    public function save($data) {
        $newsId = $data['news_id'];
        unset($data['news_id']);

        try {
            $id = D("News")->updateById($newsId, $data);
            
            $newsContentData['content'] = $data['content'];
            
            $condId = D("NewsContent")->updateNewsById($newsId, $newsContentData);
            
            if($id === false || $condId === false) {
                return result(0, '更新失败');
            }
            return result(1, '更新成功');
        }catch(Exception $e) {
            return result(0, $e->getMessage());
        }
    }
    
    /*
	 * @desc 文章状态更新
	 */
    public function setStatus(){
    	try{
    		if($_POST){
    			$id = $_POST['id'];
    			$status = $_POST['status'];
    			if(!$id){
    				return result(0,'ID不存在');
    			}
    			$res = D("News")->updateStatusById($id,$status);
//    			print_r($res);exit;
    			if($res){
    				return result(1,'更新成功');
    			}else{
    				return result(0,'更新失败');
    			}
    		}
    		return result(0,'没有提交内容');
    	}catch(Exception $e){
    		return result(0,$e->getMessage());
    	}
    }
    
    /*
	 * @desc 文章编辑
	 */
	public function edit(){
		//获取get请求的id
		$newsId = $_GET['id'];
		
		if(!$newsId){
			return $this->redirect('/amdin.php?c=content');
		}
		//根据id获取news
		$news = D("News")->getNewsById($newsId);
		
		if(!$news){
			return $this->redirect('/admin.php?c=content');
		}
		//根据id获取newsContent
		$newsContent = D("NewsContent")->getNewsContentById($newsId);
//		print_r($newsContent);exit;
		if($newsContent){
			$news['content'] = $newsContent['content'];
		}
		
//		print_r($news);exit;
		//将基本内容填充到页面中		
		$barMenus = D("Menu")->getBarMenus();
        $this->assign('barMenus', $barMenus);
        $this->assign('titleColor', C("TITLE_FONT_COLOR"));
        $this->assign('copyfrom', C("COPY_FROM"));
        $this->assign('news',$news);
        
        return $this->display();
	}
	
	/*
	 * @desc 文章推送
	 */
	public function push(){
		
		$jumpUrl = $_SERVER['HTTP_REFERER'];
		
		//获取推荐位id和文章id
		$positionId = intval($_POST['position_id']);
		$newsId = $_POST['push'];
		
		//数据校验
		if(!$newsId || !is_array($newsId)){
			return result(0,'请选择推荐文章');
		}
		if(!$positionId){
			return result(0,'请选择推荐位');
		}
		try{
			//由文章id获取文章基本信息
			$news = D("News")->getNewsByNewsIdIn($newsId);
			if(!$news){
				return result(0,'文章内容为空');
			}
			//将文章的基本信息添加到推荐位内容中去
			foreach ($news as $new) {
	        	$data = array(
	            	'position_id' => $positionId,
	                'title' => $new['title'],
	                'thumb' => $new['thumb'],
	                'news_id' => $new['news_id'],
	                'status' => 1,
	                'create_time' => $new['create_time'],
	            );
	        	$position = D("PositionContent")->insert($data);
	        }
		}catch(Exception $e){
			return result(0,$e->getMessage());
		}
		return result(1, '推荐成功',array('jump_url'=>$jumpUrl));
	}
}