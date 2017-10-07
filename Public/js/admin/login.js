var login = {
	check: function(){
//		alert(1);
		//获取用户名和密码
		var username = $('input[name="username"]').val();
		var password = $('input[name="password"]').val();
		
		//校验用户名和密码
		if(!username){
			dialog.error("用户名为空");
			return ;
		}
		if(!password){
			dialog.error("密码为空");
			return ;
		}
		
		var data = {'username':username,'password':password};
		//跳转url
		var url = '/admin.php?c=login&a=check';
		//ajax异步请求
		$.post(url,data,function(result){
			if(result.status == 0){
				return dialog.error(result.message);
			}
			if(result.status == 1){
				return dialog.success(result.message,'/admin.php?c=index');
			}
		},'json');
	}
}