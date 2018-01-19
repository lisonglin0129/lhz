<form action='/admin/index.php?act=mobile_timplate&op=addCatgroy&submit=1' method='post'  enctype="multipart/form-data">
	<table>
		<tr style="height:40px;">
			<td>分类名称<input type='text' name='catgroy_name'/><br/></td>
		</tr>
		<tr style="height:40px;">
			<td>状态&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 开启<input type='radio' name='off' value = '1' checked/>&nbsp;&nbsp;&nbsp;关闭<input type='radio' name='off' value = '0'/></td>
		</tr>
		<tr style="height:40px;">
			<td>链接地址 <input type='text' name='link'/></td>
		</tr>
		<tr style="height:40px;">
			<td>文件 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='file' name='upload_file'/></td>
		</tr>
		<tr style="height:40px;">
			<td>排序 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='text' name='sort'/></td>
		</tr>
		<tr style="height:40px;">
			<td style="text-align:center;"><input type='submit' value='提交' style="width:100px;" /></td>
		</tr>
	</table>
</form>