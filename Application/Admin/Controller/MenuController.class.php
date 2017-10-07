<?php
namespace Admin\Controller;
use Think\Controller;
use Think\Exception;

class MenuController extends CommonController {
    
    public function index(){
    	$data = array();
    	//获取请求的类型
    	if(isset($_REQUEST['type']) && in_array($_REQUEST['type'],array(0,1)) ){
    		$data['type'] = intval($_REQUEST['type']);
    		$this->assign('type',$data['type']);
    	}else{
    		$this->assign('type',-1);
    	}
    	
    	//获取页面数和指定页面大小数
    	$page = $_REQUEST['p'] ? $_REQUEST['p'] : 1;
    	$pageSize = $_REQUEST['pageSize'] ? $_REQUEST['pageSize'] : 4;
    	
    	//从数据库获取结果
 		$menus = D('Menu')->getMenus($data,$page,$pageSize);
 		$menuCount = D('Menu')->getMenuCount($data);
 		
 		//引入think中的分页技术
 		$res = new \Think\Page($menuCount,$pageSize);
 		$pageRes = $res->show();   	
 		
    	$this->assign('pageRes',$pageRes);
    	$this->assign('menus',$menus);
    	
    	$this->display();
    }
    
    /*
     * @desc 菜单管理中添加操作
     */
    public function add(){
    	if($_POST){
//	    	print_r($_POST);
			//对提取到的数据进行校验
			if(!isset($_POST['name']) || !$_POST['name']) {
                return result(0,'菜单名不能为空');
            }
            if(!isset($_POST['m']) || !$_POST['m']) {
                return result(0,'模块名不能为空');
            }
            if(!isset($_POST['c']) || !$_POST['c']) {
                return result(0,'控制器不能为空');
            }
            if(!isset($_POST['f']) || !$_POST['f']) {
                return result(0,'方法名不能为空');
            }
            
            //此处用于更新
            if($_POST['menu_id']){
            	return $this->save($_POST);
            }

            $menuId = D("Menu")->add($_POST);
//            print_r($menuId);exit;
            if($menuId) {
                return result(1,'新增成功',$menuId);
            }
            return result(0,'新增失败',$menuId);
            
    	}else{
	    	$this->display();
    	}
    }
    
    /*
     * @desc 菜单管理中添加操作
     */
    public function edit(){
    	//获取传递的id
    	$id = $_GET['id'];
    	$menu = D('Menu')->find($id);
    	$this->assign('menu',$menu);
    	$this->display();
    } 
    
    /*
     * @desc 菜单管理中编辑操作的更新
     */
    public function save($data){
 		//获取数据
    	$menuId = $data['menu_id'];
		unset($data['menu_id']);    	
    	
    	try{
    		$res = D("Menu")->updateMenuById($menuId,$data);
//    		print_r($res);exit;
    		if($res == false){
    			return result(0,'更新失败');
    		}else{
    			return result(1,'更新成功');
    		}
    	}catch(Exception $e){
    		return result(0,$e->getMessage());
    	}
    }
    
    /*
     * @desc 更改菜单列表的状态
     */
    public function setStatus(){
    	try{
    		if($_POST){
				//获取提交的数据
				$menuId = $_POST['id'];
				$status = $_POST['status'];
				
				$res = D('Menu')->updateStatusById($menuId,$status);
//				print_r($res);exit;
				
				if($res == false){
    				return result(0,'删除失败');
    			}else{
    				return result(1,'删除成功');
    			}
    		}
    	}catch(Exception $e){
    		return result(0,$e->getMessage());
    	}
    }
}