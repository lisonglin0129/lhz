<?php defined('ShopMall') or exit('Access Invalid!');?>
<script type="text/javascript" charset="utf-8" src="/js/baidu/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="/js/baidu/ueditor.all.min.js"> </script>
<script type="text/javascript" charset="utf-8" src="/js/baidu/lang/zh-cn/zh-cn.js"></script>
<style>
	.table tr{margin-top:5px;}
	.table tr td{text-align: left;}
</style>
<script type="text/javascript" src='/js/lib.js'></script>
<div style='width:70%; text-align:center; padding:20px 0px; margin:0 auto;'>
	<table class='table'>
		<tr>
			<td>版本名称</td>
			<td><input id='app_vesion_name' type='text'/> </td>
		</tr>
		<tr>
			<td>版本号 （请填写整数）</td>
			<td><input id='app_vession' type='text'/></td>
		</tr>
		<tr>
			<td>App名称</td>
			<td><input id='app_name' type='text'/></td>
		</tr>
		<tr>
			<td>App类型</td>
			<td>
				<select id='type'>
					<option value='1'>客户版</option>
					<option value='2'>商家版</option>
				</select>
			</td>
		</tr>
		<tr>
			<td>App文件</td>
			<td>
				<input id='files' type='file'/>
				<input id='files_path' type='hidden'/>
				<input id='files_server_path' type='hidden'/>
				<input id='files_name' type='hidden'/>
				<div id='pg'>0%</div>
			</td>
		</tr>
		<tr>
			<td>App系统类型</td>
			<td>
				<select id='system_type'>
					<option value='0'>--请选择--</option>
					<option value='1'>Android</option>
					<option value='2'>IPONE</option>
				</select>
			</td>
		</tr>
		<tr > 
			<td colspan="2">
				 	<script id="editor" type="text/plain" style="height:500px;"></script>
			</td>
		</tr>
	</table>
	<button id='submit'>提交</button>
</div>
<script type="text/javascript">
(document).ready(function(){
//var ue = UE.getEditor('editor');
	$("#submit").click(function(){
		alert(1);
 		/* var dat = new Object();
		dat.vession_name = $("#app_vesion_name").val();
		dat.app_vession = $("#app_vession").val();
		dat.type = $("#type").val();
		dat.system_type = $("#system_type").val();	
		dat.file_path = $("#files_path").val();
		dat.files_server_path = $("#files_server_path").val();
		dat.files_name = $("#files_name").val();
		dat.content = UE.getEditor('editor').getContent();
		dat.content = encodeURI(dat.content);
		$.ajax({
			type:'post',
			url:'/admin/index.php?act=mb_update&op=save_appliction',
			data:dat,
			success:function(e){
				if(e.code == 200)
				{
					set.url("/admin/index.php?act=mb_update&op=mb_update_list");
				}
			}
		})  	 */
	});
	
/* 	get.Id("files").onchange = function(){
		var type = $("#type").val();
		var vession =  $("#app_vesion_name").val();

		if(vession == '') {return false;}
		file.upload({
			type:'post',
			dataType:'json',
			url:'/admin/index.php?act=mb_update&op=add_application&type='+type+'&vession='+vession,
			file:'files',
			progress:function(e){
				set.html(get.Id("pg"), file.getProgress(e));
			},
			success:function(e){
				if(e.code == 200) {
					$("#files_path").val(e.file_path);
					$("#files_server_path").val(e.success_path);
					$("#files_name").val(e.file_name);
				}
			}
		});
	} */
});

		
</script>

