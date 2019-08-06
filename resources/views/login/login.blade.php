<!DOCTYPE html>
<meta name="csrf-token" content="{{ csrf_token() }}">
<html>
<head>
	<title>登陆</title>
</head>
<body>
	用户名:<input type="text" name="" id="name">
	<br>
	密码:<input type="password" name="" id="password">
	<br>
	<button onclick="login()">登陆</button>
</body>
</html>
<script src="https://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js">
</script>
<script type="text/javascript">
	function login() {
		var name=$('#name').val()
		var password=$('#password').val()
		var token="18862202991qweq"
		$.ajax({
			url:"<?php echo url('user');?>",
			data:{
				 '_token': $('meta[name=csrf-token]').attr("content"),
				name:name,
				password:password,
			},
			type:'post',
			dataType:'json',
			success:function (res) {
				console.log(res)
				if (res.code=='0') {
					//alert(res.data)
					location.href='<?php echo url("show") ?>'
				}else{
					alert(res.data)
				}
				

			}
		})
	}
</script>