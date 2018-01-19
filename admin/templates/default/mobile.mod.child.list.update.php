<style>
body .btns{
	text-align:center;
	width: 80px;
	height: 25px;
	line-height: 25px;
	padding-right:3px;
	color:#FFF;
	background:#3598dc;
}
</style>
<script type="text/javascript">
function select_goods(names)
{
	window.parent.add_goods({
		  type: 2,
		  area: ['1000px', '530px'],
		  fixed: false, //不固定
		  maxmin: true,
		  content: '/admin/index.php?act=mobile_timplate&op=getgoodsList'
	});
}
</script>
<form action='/admin/index.php?act=mobile_timplate&op=modChildUpdate&submit=1' method='post'  enctype="multipart/form-data">
		<input type='hidden' name='typeid' value='<?php echo $_GET['typeid']?>'/>
		<input type='hidden' name='template_id' value='<?php echo $_GET['template_id']?>'/>
		<table>
			<tr style="height:40px;">
				<td>名称 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='text' name='name' value='<?php echo $output['template_common']['name']; ?>'/><br/></td>
			</tr>
			<tr style="height:40px;">
				<td>
					<img src="<?php echo  $output['template_common']['success_path']; ?>"/><br/><br/>
					文件&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
					<input type='file' name='upload_file'>
				</td>
			</tr>
			<tr style="height:40px;">
				<td>状态&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
				<?php if($output['template_common']['state'] == 1) { ?>
					开启<input type='radio' name='off' value = '1' checked/>&nbsp;&nbsp;&nbsp;
					关闭<input type='radio' name='off' value = '0'/></td>
				<?php } else { ?>
					开启<input type='radio' name='off' value = '1'/>&nbsp;&nbsp;&nbsp;
					关闭<input type='radio' name='off' value = '0'  checked/></td>
				<?php } ?>
			</tr>
			<tr style="height:40px;">
				<td>链接地址 <input type='text' id='links' name='link' value="<?php echo $output['template_common']['url']; ?>"/>
				<a href='javascript:select_goods("link");' class='btns'>选择商品</a><br/><br/>
				<div id="imgs" style='width:200px;  height:170px;'></div>
				</td>
			</tr>
			<tr style="height:40px;">
				<td>排序 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='text' name='sort' value="<?php echo $output['template_common']['sort']; ?>"/></td>
			</tr>
			<tr style="height:40px;">
				<td style="text-align:center;"><input type='submit' value='提交' style="width:100px;" /></td>
			</tr>		
		</table>
</form>
