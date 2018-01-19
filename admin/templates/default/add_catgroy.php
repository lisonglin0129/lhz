<?php defined('ShopMall') or exit('Access Invalid!');?>
<div id="append_parent"></div>
<div id="ajaxwaitid"></div>
<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><a href="index.php?act=mobile_catgroy&op=catgroy">分类管理</a></h3>
      <ul class="tab-base">
        <li><a href="JavaScript:void(0);" class="current"><span>新增</span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form id="user_form" enctype="multipart/form-data" method="post" action="/admin/index.php?act=mobile_catgroy&op=add">
    <input name="form_submit" value="ok" type="hidden">
    <table class="table tb-type2">
      <tbody>
        <tr class="noborder" style="background: rgb(255, 255, 255) none repeat scroll 0% 0%;">
          <td colspan="2" class="required"><label class="validation" for="name">分类名称:</label></td>
        </tr>
        <tr class="noborder" style="background: rgb(255, 255, 255) none repeat scroll 0% 0%;">
          <td class="vatop rowform"><input value="" name="name" id="name" class="txt" type="text"></td>
          <td class="vatop tips"></td>
        </tr>
        <tr style="background: rgb(255, 255, 255) none repeat scroll 0% 0%;">
          <td colspan="2" class="required"><label> 是否显示:</label></td>
        </tr>
        <tr class="noborder" style="background: rgb(255, 255, 255) none repeat scroll 0% 0%;">
          <td class="vatop rowform"><ul>
              <li>
                <label>
                  <input checked="checked" value="1" name="state" type="radio">
                  显示</label>
              </li>
              <li>
                <label>
                  <input value="2" name="state" type="radio">
                  隐藏</label>
              </li>
            </ul></td>
          <td class="vatop tips"></td>
        </tr>
        <tr style="background: rgb(255, 255, 255) none repeat scroll 0% 0%;">
          <td colspan="2" class="required"><label class="validation" for="logo">分类logo:</label></td>
        </tr>
        <tr class="noborder" style="background: rgb(255, 255, 255) none repeat scroll 0% 0%;">
          <td class="vatop rowform">
			<span class="type-file-show">
			<img class="show_image" src="/admin/templates/default/images/preview.png">
			<div class="type-file-preview" style="display:none;"><img id="view_img"></div>
			</span>
            <span class="type-file-box">
              <input name="member_avatar" id="member_avatar" class="type-file-text" type="text">
              <input name="button" id="button" value="" class="type-file-button" type="button">
              <input name="_pic" class="type-file-file" id="_pic" size="30" hidefocus="true" type="file">
            </span>
            </td>
          <td class="vatop tips">支持格式gif,jpg,jpeg,png</td>
        </tr>
      </tbody>
      <tfoot>
        <tr class="tfoot">
          <td colspan="15"><a href="JavaScript:void(0);" class="btn" id="submitBtn"><span>添加</span></a></td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
<script type="text/javascript" src="/data/resource/js/dialog/dialog.js" id="dialog_js" charset="utf-8"></script><link href="/data/resource/js/dialog/dialog.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="/data/resource/js/jquery-ui/jquery.ui.js"></script>
<script type="text/javascript" src="/data/resource/js/ajaxfileupload/ajaxfileupload.js"></script>
<script type="text/javascript" src="/data/resource/js/jquery.Jcrop/jquery.Jcrop.js"></script>
<link href="/data/resource/js/jquery.Jcrop/jquery.Jcrop.min.css" rel="stylesheet" type="text/css" id="cssfile2">
<script type="text/javascript">
//裁剪图片后返回接收函数
function call_back(picname){
	$('#member_avatar').val(picname);
	$('#view_img').attr('src','/data/upload/admin/mobile/'+picname);
}
$(function(){
	$('input[class="type-file-file"]').change(uploadChange);
	function uploadChange(){
		var filepatd=$(this).val();
		var extStart=filepatd.lastIndexOf(".");
		var ext=filepatd.substring(extStart,filepatd.lengtd).toUpperCase();		
		if(ext!=".PNG"&&ext!=".GIF"&&ext!=".JPG"&&ext!=".JPEG"){
			alert("图片格式不正确！");
			$(this).attr('value','');
			return false;
		}
		if ($(this).val() == '') return false;
		ajaxFileUpload();
	}	
	function ajaxFileUpload()
	{
		$.ajaxFileUpload
		(
			{
				url:'index.php?act=common&op=pic_upload&form_submit=ok&uploadpath=admin/mobile',
				secureuri:false,
				fileElementId:'_pic',
				dataType: 'json',
				success: function (data, status)
				{
					if (data.status == 1){
						ajax_form('cutpic','裁剪','index.php?act=common&op=pic_cut&type=member&x=120&y=120&resize=1&ratio=1&url='+data.url,690);
					}else{
						alert(data.msg);
					}
					$('input[class="type-file-file"]').bind('change',uploadChange);
				},
				error: function (data, status, e)
				{
					alert('上传失败');
					$('input[class="type-file-file"]').bind('change',uploadChange);
				}
			}
		)
	};
	//按钮先执行验证再提交表单
	$("#submitBtn").click(function(){
    if($("#user_form").valid()){
      if($("#_pic").val())
      {
        $("#user_form").submit();
      }else{
        alert('分类logo不能为空！');  
      }
     
	}
	});
    $('#user_form').validate({
        errorPlacement: function(error, element){
			error.appendTo(element.parent().parent().prev().find('td:first'));
        },
        rules : {
			name: {
				required : true,
				minlength: 2,
				maxlength: 5,
				remote   : {
                    url :'/admin/index.php?act=mobile_catgroy&op=catgroy_name',
                    type:'get',
                    data:{
                        name : function(){
                          return $('#name').val();
                        },
                    }
                }
            },
    },
        messages : {
			name: {
				required : '分类名称不能为空',
				maxlength: '分类名称必须在2-5字符之间',
				minlength: '分类名称必须在2-5字符之间',
				remote   : '分类名称有重复，请您换一个'
			},}
    });
});
</script>