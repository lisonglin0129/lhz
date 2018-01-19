<form action='/admin/index.php?act=mobile_timplate&op=addmod&submit=1' method='post'  enctype="multipart/form-data">
	<table>
		<tr style="height:40px;">
			<td>名称 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='text' name='name'/><br/></td>
		</tr>
		<tr style="height:40px;">
			<td>类型&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
				<select id="selects" name='mode'>
					<option value='1'>模板1</option>
					<option value='2'>模板2</option>
					<option value='3'>模板3</option>
					<option value='4'>其他</option>
					<option value='5'>模板4</option>
				</select>
				<br/>
				<div style='width: 100%; text-align: center; margin-top:15px;'>
					<img id='layout' src='/admin/templates/default/images/1.png' style='width:100px; height:100px;'/>
				</div>
			</td>
			<script>
					var select = document.getElementById("selects");  
					select.options[0].selected = true;  
					select.onchange = function()
					{
						 document.getElementById("layout").src = '/admin/templates/default/images/'+this.value+'.png';
					}
					
			</script>
		</tr>
		<tr style="height:40px;">
			<td>状态&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 开启<input type='radio' name='off' value = '1' checked/>&nbsp;&nbsp;&nbsp;关闭<input type='radio' name='off' value = '0'/></td>
		</tr>
		<tr style="height:40px;">
			<td>链接地址 <input type='text' name='link'/></td>
		</tr>
		<tr style="height:40px;">
			<td>排序 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='text' name='sort'/></td>
		</tr>
		<tr style="height:40px;">
			<td style="text-align:center;"><input type='submit' value='提交' style="width:100px;" /></td>
		</tr>		
	</table>
</form>