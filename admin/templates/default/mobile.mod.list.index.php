<script type='text/javascript' src='/js/layer/jquery-1.11.0.min.js'></script>
<script type='text/javascript' src='/js/layer/layer.js'></script>
<style>
.table {width:700px;height:100%;}
.table thead tr th{ padding:2px; font-size:14px;}
.table thead  {border-bottom:1px solid #ABCDEF;}
</style>
<div>
<a href='/admin/index.php?act=mobile_timplate&op=addmod'>添加</a>
</div>
<script>
function del(id)
{
	layer.confirm('您确定要删除模块么？', 
	{icon: 3,skin: 'layer-ext-moon' ,closeBtn: 0,btn: ['是','否']},
	function(){
		$.ajax({
			type:'post',
			url:'/admin/index.php?act=mobile_timplate&op=modRemove',
			data:{"id":id},
			dataType:'json',
			success:function(e)
			{
				 layer.msg(e.msg, {
					    time: 20000, //20s后自动关闭
					    btn: ['明白了', '知道了']
				 },function(){
						window.parent.document.getElementById("iframe").src='';
						window.parent.document.getElementById("iframe").src='/wap/index.html';
						window.location.reload();
				 });
			}
		}); 
		
	}, function(){

	});

	
}
</script>
<table class='table'>
<thead>
<tr>
<th>名称</th>
<th>类型</th>
<th>排序</th>
<th>状态</th>
<th>操作</th>
</tr>
</thead>
	<?php foreach($output['template'] AS $temp) { ?>
		<tr>
			<td><?php echo $temp['name']; ?></td>
			<td> <img src='/admin/templates/default/images/<?php echo $temp['type']; ?>.png' style='width:30px; height:30px; display:inline-block; vertical-align: middle; margin-right:15px;'/><?php echo $temp['lang_type']; ?></td>
			<td><?php echo $temp['sort']; ?></td>
			<td><?php echo $temp['lang_state']; ?></td>
			<td>
				<a href='/admin/index.php?act=mobile_timplate&op=modUpdate&id=<?php echo $temp['id'];?>'>修改</a>&nbsp;&nbsp;&nbsp;
				<a href='/admin/index.php?act=mobile_timplate&op=addmodListChild&id=<?php echo $temp['id'];?>&type_id=<?php echo $temp['type'];?>'>添加</a>&nbsp;&nbsp;&nbsp;
				<a href='/admin/index.php?act=mobile_timplate&op=modListChild&id=<?php echo $temp['id'];?>&type_id=<?php echo $temp['type'];?>'>查看</a>&nbsp;&nbsp;&nbsp;
				<a href='javascript:del(<?php echo $temp['id'];?>);'>删除</a>
			</td>
		</tr>
	<?php } ?>
</table>