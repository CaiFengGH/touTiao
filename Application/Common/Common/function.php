<?php
//ajax异步请求的公有方法,避免方法同名
function result($status,$message,$data=array()){
	//返回数组
	$result = array(
		'status' => $status,
		'message' => $message,
		'data' => $data,
	);
	//对数组进行json编码,默认返回一个对象
	exit(json_encode($result));
}

//将数字类型转换为具体类型
function getTypeName($type){
	return $type == 1 ? "后端菜单" : "前端导航" ;
}

//将数字状态转换为具体状态
function status($status){
	if($status == 0){
		$res = "关闭";
	}else if($status == 1){
		$res = "正常";
	}else if($status == -1){
		$res = "删除";
	}
	return $res;
}

//获取每个菜单的链接地址
function getAdminMenuUrl($nav){
	$url = '/admin.php?c='.$nav['c'].'$a='.$nav['a'];
	if($nav['f'] == 'index'){
		$url = '/admin.php?c='.$nav['c'];
	}
	return $url;
}

//实现点击的菜单高亮
function getActive($navc){
    $c = strtolower(CONTROLLER_NAME);
    if(strtolower($navc) == $c) {
        return 'class="active"';
    }
    return '';
}

//编辑器返回数据格式<基于kind的官方文档>
function showKind($status,$data) {
    header('Content-type:application/json;charset=UTF-8');
    if($status==0) {
        exit(json_encode(array('error'=>0,'url'=>$data)));
    }
    exit(json_encode(array('error'=>1,'message'=>'上传失败')));
}

//获取当前session中的登陆用户
function getLoginUsername(){
	return $_SESSION['adminUser']['username'] ? $_SESSION['adminUser']['username'] : '';
}


//文章管理列表中的 菜单id与菜单名字间的转换
function getCatName($navs, $id) {
    foreach($navs as $nav) {
        $navList[$nav['menu_id']] = $nav['name'];
    }
    return isset($navList[$id]) ? $navList[$id] : '';
}

//用于文章来源的转换
function getCopyFromById($id) {
    $copyFrom = C("COPY_FROM");
    return $copyFrom[$id] ? $copyFrom[$id] : '';
}

//用于封面图的转换
function isThumb($thumb) {
    if($thumb) {
        return '<span style="color:red">有</span>';
    }
    return '无';
}
