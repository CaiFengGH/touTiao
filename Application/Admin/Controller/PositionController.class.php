<?php
namespace Admin\Controller;
use Think\Controller;

class PositionController extends CommonController {
    
    public function index()
    {
        $data['status'] = array('neq',-1);
        $positions = D("Position")->select($data);
        $this->assign('positions',$positions);
//        $this->assign('nav','推荐位管理');
        $this->display();
    }
    
	/**
     * @desc 添加页面
     */
    public function add() {
        if(IS_POST) {
            if(!isset($_POST['name']) || !$_POST['name']) {
                return result(0, '推荐位名称为空');
            }
            
            if($_POST['id']) {
                return $this->save($_POST);
            }
            try {
                $id = D("Position")->insert($_POST);
                if($id) {
                    return result(1,'新增成功',$id);
                }
                return result(0,'新增失败',$id);

            }catch(Exception $e) {
                return result(0, $e->getMessage());
            }
            return result(0, '新增失败',$newsId);
        }else {
            $this->display();
        }
    }
    
    /**
     * @desc 编辑页面
     */
    public function edit() {
        $data = array(
            'status' => array('neq',-1),
        );
        $id = $_GET['id'];
        $position = D("Position")->find($id);
        $this->assign('vo', $position);
        $this->display();
    }
    
    /**
     * @desc 编辑保存
     */
    public function save($data) {
        $id = $data['id'];
        unset($data['id']);
        try {
            $id = D("Position")->updateById($id,$data);
            if($id === false) {
                return result(0,'更新失败');
            }
            return result(1,'更新成功');
        }catch (Exception $e) {
            return result(0,$e->getMessage());
        }
    }
    
    /**
     * @desc 设置状态
     */
    public function setStatus(){
        try {
            if ($_POST) {
                $id = $_POST['id'];
                $status = $_POST['status'];
                $res = D("Position")->updateStatusById($id, $status);
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