<style>
.table {width:700px;height:100%;}
.table thead tr th{ padding:2px; font-size:14px;}
.table thead  {border-bottom:1px solid #ABCDEF;}
</style>
<div>
<a href='/admin/index.php?act=mobile_timplate&op=addCatgroy'>添加</a>
</div>
<script type="text/javascript" src='/js/mt/init.js'></script>
<script>
function del(id)
{
	$.ajax({
		type:'post',
		url:'/admin/index.php?act=mobile_catgroy&op=Del',
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
<th>名称</th>
<th>排序</th>
<th>上传日期</th>
<th>状态</th>
<th>操作</th>
</tr>
</thead>
<?php foreach($output['catgroy'] AS $list) {?>
		<tr>
			<td><img src='<?php echo $list['success_path']; ?>' style='width:30px; height:30px;'></td>
			<td><?php echo $list['catgroy_name']; ?></td>
			<td><?php echo $list['sort']; ?></td>
			<td><?php echo $list['add_time']; ?></td>
			<td><?php echo $list['catgroy_state'] == 1? "开启":'关闭'; ?></td>
			<td><a href="/admin/index.php?act=mobile_catgroy&op=upd_catgroy&id=<?php echo $list['mobile_catgroy_id']; ?>">修改 </a><a href='javascript:del(<?php echo $list['mobile_catgroy_id']; ?>)'> 删除</a></td>
		</tr>
	<?php } ?>
</table>
