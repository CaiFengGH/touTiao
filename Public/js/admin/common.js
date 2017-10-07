//菜单管理中的添加按钮
$("#button-add").click(function(){
	var url = SCOPE.add_url;
	window.location.href = url;
});

//将菜单管理中的添加操作的表单数据进行传递
$("#singcms-button-submit").click(function(){
	//将表单数据序列化为数组，其中存储对象
	var data = $("#singcms-form").serializeArray();
	
	postData = {};
	$(data).each(function(i){
		//将data中的值进行转化
		postData[this.name] = this.value;
	});
//	alert(postData["name"]);

	//获取异步提交的url
	var url = SCOPE.save_url;
	var jumpUrl = SCOPE.jump_url;
	//ajax异步数据提交
	$.post(url,postData,function(result){
		if(result.status == 1){
			return dialog.success(result.message,jumpUrl);
		}else if(result.status == 0){
			return dialog.success(result.message);
		}
	},'json');
});

//实现菜单列表的编辑操作
$(".singcms-table #singcms-edit").on('click',function(){
	var id = $(this).attr("attr-id");
	var url = SCOPE.edit_url + "&id=" + id;
	window.location.href = url;
});

//删除操作
$('.singcms-table #singcms-delete').on('click',function(){
    var id = $(this).attr('attr-id');
    var a = $(this).attr("attr-a");
    var message = $(this).attr("attr-message");
    var url = SCOPE.set_status_url;

    data = {};
    data['id'] = id;
    data['status'] = -1;

    layer.open({
        type : 0,
        title : '是否提交？',
        btn: ['yes', 'no'],
        icon : 3,
        closeBtn : 2,
        content: "是否确定"+message,
        scrollbar: true,
        yes: function(){
            // 执行相关跳转
            todelete(url, data);
        },

    });

});
function todelete(url, data) {
    $.post(
        url,
        data,
        function(s){
            if(s.status == 1) {
                return dialog.success(s.message,'');
                // 跳转到相关页面
            }else {
                return dialog.error(s.message);
            }
        }
    ,"JSON");
}

//文章内容推送
$("#singcms-push").click(function(){
	//获取推荐位id
    var id = $("#select-push").val();
    if(id==0) {
        return dialog.error("请选择推荐位");
    }
    push = {};
    postData = {};
    //将选择框中内容获取
    $("input[name='pushcheck']:checked").each(function(i){
        push[i] = $(this).val();
    });
    
    //组装ajax异步数据
    postData['push'] = push;
    postData['position_id']  =  id;
    
//    console.log(postData);return;
    
    var url = SCOPE.push_url;
    $.post(url, postData, function(result){
        if(result.status == 1) {
            return dialog.success(result.message,result['data']['jump_url']);
        }
        if(result.status == 0) {
            return dialog.error(result.message);
        }
    },"json");
});




