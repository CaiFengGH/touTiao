<?php
namespace Admin\Controller;
use Think\Controller;

class PositioncontentController extends CommonController {
    
    public function index(){
    	
    	$positions = D("Position")->getNormalPositions();
    	
    	$data['status'] = array('neq',-1);
    	//获取搜索的推荐位id
    	$data['position_id'] = $_GET['position_id'] ? intval($_GET['position_id']) : $positions[0]['id'];
    	
    	//获取文章标题搜索
    	if($_GET['title']){
    		$data['title'] = trim($_GET['title']);
    		$this->assign('title',$data['title']);
    	}
		
		$contents = D("PositionContent")->select($data);
//		print_r($contents);exit;
				
    	$this->assign('positions',$positions);
    	$this->assign('contents',$contents);
        $this->assign('positionId',$data['position_id']);
        
        return $this->display();
    }
    
    /**
     * @desc 设置状态
     */
    public function setStatus(){
        try {
            if ($_POST) {
                $id = $_POST['id'];
                $status = $_POST['status'];
                $res = D("PositionContent")->updateStatusById($id, $status);
                if ($res) {
                    return result(1, '操作成功');
                } else {
                    return result(0, '操作失败');
                }
            }
        }catch (Exception $e) {
            return result(0, $e->getMessage());
        }
        return result(0, '没有提交的内容');
    }
}