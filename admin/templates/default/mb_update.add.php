<?php defined('ShopMall') or exit('Access Invalid!');?>
<script type="text/javascript" charset="utf-8" src="/js/baidu/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="/js/baidu/ueditor.all.min.js"> </script>
<script type="text/javascript" charset="utf-8" src="/js/baidu/lang/zh-cn/zh-cn.js"></script>
<style>
	.table tr{margin-top:5px;}
	.table tr td{text-align: left;}
	.dis{
		background:#fff;
		position: absolute; 
		width:40%;
		height:25px;
		left:30%;
		opacity:0;
		
	}
</style>
<script type="text/javascript" src='/js/lib.js'></script>
<div style='width:70%; text-align:center; padding:20px 0px; margin:0 auto;'>

	<table class='table'>
		<tr>
			<td>版本名称</td>
			<td><input id='app_vesion_name' value="" name="app_vesion_name" type='text'/> </td>
		</tr>
		<tr>
			<td>版本号 （请填写整数）</td>
			<td><input id='app_vession' value="" name="app_vession" type='text'/></td>
		</tr>
		<tr>
			<td>App名称</td>
			<td><input id='app_name' value="" name="app_name" type='text'/></td>
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
		<tr class="dis"></tr>
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
$(document).ready(function(){
var ue = UE.getEditor('editor');
	$("#submit").click(function(){
		var app_vesion_name=$("#app_vesion_name").val();
		var app_vession=$("#app_vession").val();
		var app_name=$("#app_name").val();
		var files=$("#files").val();
		var files_str=files.slice(-3);
		var system_type=$("#system_type").val();	
		var i=0;
		var i_name=0;
		var reg = /^-?\d+$/; //验证是否为整数
		
		if(UE.getEditor('editor').getContent()==""){
			i++;
			i_name="备注内容不能为空";				
		}if(system_type==0){
			i++;
			i_name="请选择App系统类型";	
		}if(files_str!=="apk"){
			i++;
			i_name="请上传正确的apk文件";				
		}if(files==''){
			i++;
			i_name="请上传app文件";	
		}if(app_name==''){
			i++;
			i_name="app名称不能为空";			
		}if(!reg.test(app_vession)){
			i++;
			i_name="版本号请填写整数";
		}if(app_vession==''){
			i++;
			i_name="版本号不能为空";
		}if(app_vesion_name==''){
			i++;
			i_name="版本名称不能为空";
		}
		if(i==0 && i_name==0){
			i_name="提交成功";
			var dat = new Object();
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
			})
			alert(i_name);
			history.go(0); 			
		}else{
			alert(i_name);
		}
	 
	});
	  $("input").blur(function(){
			var app_vesion_name=$("#app_vesion_name").val();
			var app_vession=$("#app_vession").val();
			var app_name=$("#app_name").val();
			if(app_vesion_name!=='' && app_vession!=='' && app_name!==''){
				$(".dis").attr("style","display:none;");
			}
	  });
	  
	  
	  
 	get.Id("files").onchange = function(){
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
	} 
});

		
</script>

