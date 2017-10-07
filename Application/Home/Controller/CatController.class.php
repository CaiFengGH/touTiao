<?php
namespace Home\Controller;
use Think\Controller;

class CatController extends CommonController {
    
    public function index(){
    	
    	$menuId = $_GET['id'];
    	//如果没有获取id则跳转到错误页面
    	if(!$menuId){
    		return $this->error("没有传输前端导航的id");
    	}
    	
    	$barMenu = D("Menu")->find($menuId);

        if(!$barMenu || $barMenu['status'] !=1) {
            return $this->error('栏目id不存在或者状态不为正常');
        }

    	//点击分类栏目的index内容改变

    	//实现分页技术
        $page = $_REQUEST['p'] ? $_REQUEST['p'] : 1;
        $pageSize = 5;
        $conds = array(
            'status' => 1,
            'thumb' => array('neq', ''),
            'catid' => $menuId,
        );

		//文章的列表        
        $news = D("News")->getNews($conds,$page,$pageSize);
        $count = D("News")->getNewsCount($conds);
		$topCount = $this->getRank();
		
        $res  =  new \Think\Page($count,$pageSize);
        $pageres = $res->show();

        $this->assign('result', array(
            'catId' => $menuId,
            'listNews' => $news,
            'pageres' => $pageres,
            'topCount' => $topCount,
        ));
        return $this->display();
    }
}