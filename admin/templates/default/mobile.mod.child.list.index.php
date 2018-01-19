<style>
.table {width:700px;height:100%;}
.table thead tr th{ padding:2px; font-size:14px;}
.table thead  {border-bottom:1px solid #ABCDEF;}
</style>
<div>
<a href='/admin/index.php?act=mobile_timplate&op=addmodListChild&id=<?php echo $_GET['id'];?>&type_id=<?php echo  $_GET['type_id'];?>'>添加</a>
</div>
<script>
function del(id)
{
	$.ajax({
		type:'post',
		url:'/admin/index.php?act=mobile_timplate&op=modChildRemove',
		data:{"id":id},
		dataType:'json',
		success:function(e)
		{
			if(e.code == 'SUCCESS')
			{
				window.parent.document.getElementById("iframe").src='';
				window.parent.document.getElementById("iframe").src='/wap/index.html';
				window.location.reload();
			}
		}
			
	}); 
}
</script>
<table class='table'>
<thead>
<tr>
<th>预览图</th>
<th>类型</th>
<th>排序</th>
<th>状态</th>
<th>操作</th>
</tr>
</thead>
	<?php foreach($output['tmp_common'] AS $temp){ ?>
		<tr>
			<td><img src='<?php echo $temp['success_path']; ?>' style='width:50px; height:50px;'></td>
			<td><?php echo $temp['lang_template_type']; ?></td>
			<td><?php echo $temp['sort']; ?></td>
			<td><?php echo $temp['lang_state']; ?></td>
			<td>
			<a href='/admin/index.php?act=mobile_timplate&op=modChildUpdate&typeid=<?php echo $temp['id']; ?>&template_id=<?php echo $temp['template_id']; ?>'>修改</a> 
			<a href='javascript:del(<?php echo $temp['id']; ?>);'>删除</a>
			</td>
		</tr>
	<?php } ?>
</table>