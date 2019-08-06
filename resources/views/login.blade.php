<!DOCTYPE html>
<meta name="csrf-token" content="{{ csrf_token() }}">
<html>
<head>
	<title>主页</title>
</head>
<body>
	用户：{{($user)}}
	<a href="<?php echo url("user/loginout") ?>"><button>退出</button></a>
	<br>
	<br>
	国家:<input type="text" name="" id="name">
	手机号:<input type="text" name="" id="ipone">
	<button onclick="add()">添加</button>
	<br>
	<br>
	<table border="1">
		<thead>
			<tr>
				<td>ID</td>
				<td>国家</td>
				<td>手机号</td>
				<td onclick="">操作</td>
			</tr>
		</thead>
		<tbody>
					
		</tbody>
	</table>
	<br><br><br>
	<div id="div">
		<input type="hidden" name="" id="code1">
		<input type="text" name="" id="name1">
		<input type="text" name="" id="population1">
		<button onclick="updateadd()">修改</button>
	</div>
</body>
</html>
<script src="https://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js">
</script>
<script type="text/javascript">
	show()
	function show() {
		$("#div").hide()
		$.ajax({
			url:"<?php echo url('showaction');?>",
			data:{
				'_token': $('meta[name=csrf-token]').attr("content"),
			},
			type:'post',
			dataType:'json',
			success:function (res) {
				console.log(res)
				var data=res.data
				var tr=''
				for (var i = 0; i < data.length; i++) {
					tr=tr+"<tr><td>"+data[i].code+"</td><td>"+data[i].name+"</td><td>"+data[i].population+"</td><td><a onclick='updateaction("+data[i].code+")'>修改</a>||<a onclick='deleteaction("+data[i].code+")'>删除</a></td></tr>";
				}
				$("table tbody").html(tr);
			}
		})
	}
	function updateaction(id) {
		$("#div").show()
		$.ajax({
			url:"<?php echo url('update');?>",
			data:{
				'_token': $('meta[name=csrf-token]').attr("content"),
				id:id,
			},
			type:'post',
			dataType:'json',
			success:function (res) {
				var data=res.data
				 
				$("#code1").val(data[0].code);
				$("#name1").val(data[0].name);
				$("#population1").val(data[0].population);
			}
		})
	}
	function updateadd() {
		var code=$('#code1').val()
		var name=$('#name1').val()
		var population=$('#population1').val()
		$.ajax({
			url:"<?php echo url('updateadd');?>",
			data:{
				'_token': $('meta[name=csrf-token]').attr("content"),
				code:code,
				name:name,
				population:population,
			},
			type:'post',
			dataType:'json',
			success:function (res) {
				show()
				alert(res.data)
			}
		})
	}
	function deleteaction(id) {
		$.ajax({
			url:"<?php echo url('delete');?>",
			data:{
				'_token': $('meta[name=csrf-token]').attr("content"),
				id:id,
			},
			type:'post',
			dataType:'json',
			success:function (res) {
				console.log(res)
				show()
				alert(res.data)

			}
		})
	}
	function add() {
		var name=$('#name').val()
		var ipone=$('#ipone').val()
		$.ajax({
			url:"<?php echo url('add');?>",
			data:{
				'_token': $('meta[name=csrf-token]').attr("content"),
				name:name,
				ipone:ipone,
			},
			type:'post',
			dataType:'json',
			success:function (res) {
				show()
				alert(res.data)
			}
		})
	}
</script>