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
<form action='/admin/index.php?act=mobile_timplate&op=addmodListChild&submit=1' method='post'  enctype="multipart/form-data">
		<input type='hidden' name='id' value='<?php echo $_GET['id']?>'/>
		<input type='hidden' name='type_id' value='<?php echo $_GET['type_id']?>'/>
	<table>
		<tr style="height:40px;">
			<td>名称 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='text' name='name'/><br/></td>
		</tr>
		<tr style="height:40px;">
			<td>文件&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
				<input type='file' name='upload_file' style='width:40%;'>
				<span>
				<?php switch($_GET['type_id']){
							case '1':
								echo '(文件像素125px*125px)';
								break;
							case '2':
								echo '(文件像素1:188px*188px; 2:183px*92px)';
								break;
							case '3':
								echo '(文件像素74px*74px)';
								break;
							case '4':
								echo '(文件像素375px*75px)';
								break;
							case '5':
								echo '(文件像素186px*186px)';
								break;
							default:
								break;
				} ?>				
				</span>
			</td>
		</tr>
		<tr style="height:40px;">
			<td>状态&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 开启<input type='radio' name='off' value = '1' checked/>&nbsp;&nbsp;&nbsp;关闭<input type='radio' name='off' value = '0'/></td>
		</tr>
		<tr style="height:40px;">
			<td>链接地址 <input id='links' type='text' name='link'/><a href='javascript:select_goods("link");' class='btns'>选择商品</a><br/><br/>
				<div id="imgs" style='width:200px;  height:170px;'></div>
			</td>
		</tr>
		<tr style="height:40px;">
			<td>排序 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='text' name='sort'/></td>
		</tr>
		<tr style="height:40px;">
			<td style="text-align:center;"><input type='submit' value='提交' style="width:100px;" /></td>
		</tr>		
	</table>
</form>