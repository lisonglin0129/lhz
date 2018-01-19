<form action='/admin/index.php?act=mobile_timplate&op=modUpdate&submit=1' method='post'  enctype="multipart/form-data">
	<input type='hidden' name='templates_id' value="<?php echo $output['template']['id']; ?>"/>
	<table>
		<tr style="height:40px;">
			<td>名称 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='text' name='name' value='<?php echo $output['template']['name']; ?>'/><br/></td>
		</tr>
		<tr style="height:40px;">
			<td>类型&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
				<select id='selects' name='mode'>
					<option value='1'>模板1</option>
					<option value='2'>模板2</option>
					<option value='3'>模板3</option>
					<option value='4'>其他</option>
					<option value='5'>模板5</option>
			
				</select>
				<div style='width: 100%; text-align: center; margin-top:15px;'>
					<img id='layout' src='/admin/templates/default/images/1.png' style='width:100px; height:100px;'/>
				</div>
				<script>
					var select = document.getElementById("selects");  
					select.options[<?php echo $output['template']['type']-1; ?>].selected = true;  
					document.getElementById("layout").src = '/admin/templates/default/images/<?php echo $output['template']['type']; ?>.png';
					select.onchange = function()
					{
						 document.getElementById("layout").src = '/admin/templates/default/images/'+this.value+'.png';
					}
					
				</script>
			</td>
		</tr>
		<tr style="height:40px;">
			<td>状态&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
				<?php if($output['template']['state']) { ?>
			 	  	开启<input type='radio' name='off' value = '1' checked/>&nbsp;&nbsp;&nbsp; 
			 	  	关闭<input type='radio' name='off' value = '0'/></td>
			    <?php }else { ?>
			    	开启<input type='radio' name='off' value = '1'/>&nbsp;&nbsp;&nbsp; 
			 	  	关闭<input type='radio' name='off' value = '0'  checked/></td>
			    <?php }?>
				
		</tr>
		<tr style="height:40px;">
			<td>链接地址 <input type='text' name='link' value="<?php echo $output['template']['url']; ?>"/></td>
		</tr>
		<tr style="height:40px;">
			<td>排序 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='text' name='sort' value="<?php echo $output['template']['sort']; ?>"/></td>
		</tr>
		<tr style="height:40px;">
			<td style="text-align:center;"><input type='submit' value='提交' style="width:100px;" /></td>
		</tr>		
	</table>
</form>