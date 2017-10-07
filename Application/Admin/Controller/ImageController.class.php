<?php
namespace Admin\Controller;
use Think\Controller;
use Think\Upload;

class ImageController extends CommonController {
	
	private $_uploadObj;
	
	public function __construct(){
		
	}	
    /*
     * @desc 异步图片上传类
     */
    public function ajaxuploadimage(){
//    	print_r("here");exit;
    	$upload = D("UploadImage");
        $res = $upload->imageUpload();
        if($res===false) {
            return result(0,'上传失败','');
        }else{
            return result(1,'上传成功',$res);
        }
    }
    
    /*
     * @desc 编辑器中图片上传类
     */
    public function kindupload(){
        $upload = D("UploadImage");
        $res = $upload->upload();
        if($res === false) {
            return showKind(1,'上传失败');
        }
        return showKind(0,$res);
    }
}