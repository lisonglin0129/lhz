<?php defined('ShopMall') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3>会员级别</h3>
      <ul class="tab-base">
        <li><a href="JavaScript:void(0);" class="current"><span>级别管理</span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <table class="table tb-type2" id="prompt">
    <tbody>
      <tr class="space odd">
        <th colspan="12"><div class="title"><h5><?php echo $lang['nc_prompts'];?></h5><span class="arrow"></span></div></th>
      </tr>
      <tr>
        <td>
        <ul>
        	<li class="tips">“会员级别设置”提交后，当会员符合某个级别后将自动升至该级别，请谨慎设置会员级别</li>
            <li class="tips">建议：一、级别应该是逐层递增，例如“级别2”所需经验值高于“级别1”；二、设置的第一个级别所需经验值应为0；三、信息应填写完整</li>
          </ul></td>
      </tr>
    </tbody>
  </table>
  <form method="post" id="mg_form" name="mg_form" enctype="multipart/form-data">
    <input type="hidden" name="form_submit" value="ok" />          
    <table class="table tb-type2">
        <thead>
          <tr class="thead">
            <th colspan="5">会员级别设置：</th>
          </tr>
          <tr class="thead">
            <th colspan="5"></th>
          </tr>
          <tr class="thead">
            <th class="align-center">级别</th>
            <th class="align-left">经验值</th>
		    <th class="align-left">是否允许赊账</th>
		    <th class="align-left">允许压款最大金额</th>
          </tr>
        </thead>
        <tbody id="mg_tbody">
            <tr id="row_0">
        		<td class="w108 align-center">V0</td>
        		<td class="align-left"><input type="text" name="mg[0][exppoints]" value="<?php echo $output['list_setting']['member_grade'][0]['exppoints'];?>" class="w60" readonly/></td>
            <td class="vatop onoff">
          	<label for="mg[0][iscredit_1]" class="cb-enable <?php if($output['list_setting']['member_grade'][0]['iscredit'] == '1'){ ?>selected<?php } ?>" ><span><?php echo $lang['member_edit_allow'];?></span></label>
            <label for="mg[0][iscredit_2]" class="cb-disable <?php if($output['list_setting']['member_grade'][0]['iscredit'] == '0'){ ?>selected<?php } ?>" ><span><?php echo $lang['member_edit_deny'];?></span></label>
            <input id="mg[0][iscredit_1]" name="mg[0][iscredit]" <?php if($output['list_setting']['member_grade'][0]['iscredit'] == '1'){ ?>checked="checked"<?php } ?>  value="1" type="radio" disabled>
            <input id="mg[0][iscredit_2]" name="mg[0][iscredit]" <?php if($output['list_setting']['member_grade'][0]['iscredit'] == '0'){ ?>checked="checked"<?php } ?> value="0" type="radio" disabled>
			 </td>				
			<td class="align-left"><input type="text" name="mg[0][maxcredit]" value="<?php echo $output['list_setting']['member_grade'][0]['maxcredit'];?>" class="w60" readonly/></td>
			</tr>
        	<tr id="row_1">
        		<td class="w108 align-center">V1</td>
        		<td class="align-left"><input type="text" name="mg[1][exppoints]" value="<?php echo $output['list_setting']['member_grade'][1]['exppoints'];?>" class="w60" nc_type="verify" data-param='{"name":"经验值","type":"int"}'/></td>
              <td class="vatop  onoff">
          	<label for="mg[1][iscredit_1]" class="cb-enable <?php if($output['list_setting']['member_grade'][1]['iscredit'] == '1'){ ?>selected<?php } ?>" ><span><?php echo $lang['member_edit_allow'];?></span></label>
            <label for="mg[1][iscredit_2]" class="cb-disable <?php if($output['list_setting']['member_grade'][1]['iscredit'] == '0'){ ?>selected<?php } ?>" ><span><?php echo $lang['member_edit_deny'];?></span></label>
            <input id="mg[1][iscredit_1]" name="mg[1][iscredit]" <?php if($output['list_setting']['member_grade'][1]['iscredit'] == '1'){ ?>checked="checked"<?php } ?>  value="1" type="radio">
            <input id="mg[1][iscredit_2]" name="mg[1][iscredit]" <?php if($output['list_setting']['member_grade'][1]['iscredit'] == '0'){ ?>checked="checked"<?php } ?> value="0" type="radio">
			 </td>
     		 <td class="align-left"><input type="text" name="mg[1][maxcredit]" value="<?php echo $output['list_setting']['member_grade'][1]['maxcredit'];?>" class="w60" nc_type="verify" data-param='{"name":"允许赊账金额","type":"intzero"}'/></td>
			</tr>
        	<tr id="row_2">
        		<td class="w108 align-center">V2</td>
        		<td class="align-left"><input type="text" name="mg[2][exppoints]" value="<?php echo $output['list_setting']['member_grade'][2]['exppoints'];?>" class="w60" nc_type="verify" data-param='{"name":"经验值","type":"int"}'/></td>
            <td class="align-left vatop  onoff">
          	<label for="mg[2][iscredit_1]" class="cb-enable <?php if($output['list_setting']['member_grade'][2]['iscredit'] == '1'){ ?>selected<?php } ?>" ><span><?php echo $lang['member_edit_allow'];?></span></label>
            <label for="mg[2][iscredit_2]" class="cb-disable <?php if($output['list_setting']['member_grade'][2]['iscredit'] == '0'){ ?>selected<?php } ?>" ><span><?php echo $lang['member_edit_deny'];?></span></label>
            <input id="mg[2][iscredit_1]" name="mg[2][iscredit]" <?php if($output['list_setting']['member_grade'][2]['iscredit'] == '1'){ ?>checked="checked"<?php } ?>  value="1" type="radio">
            <input id="mg[2][iscredit_2]" name="mg[2][iscredit]" <?php if($output['list_setting']['member_grade'][2]['iscredit'] == '0'){ ?>checked="checked"<?php } ?> value="0" type="radio">
			 </td>
    			 <td class="align-left"><input type="text" name="mg[2][maxcredit]" value="<?php echo $output['list_setting']['member_grade'][2]['maxcredit'];?>" class="w60" nc_type="verify" data-param='{"name":"允许赊账金额","type":"intzero"}'/></td>
			</tr>
        	<tr id="row_3">
        		<td class="w108 align-center">V3</td>
        		<td class="align-left"><input type="text" name="mg[3][exppoints]" value="<?php echo $output['list_setting']['member_grade'][3]['exppoints'];?>" class="w60" nc_type="verify" data-param='{"name":"经验值","type":"int"}'/></td>
            <td class="vatop  onoff">
          	<label for="mg[3][iscredit_1]" class="cb-enable <?php if($output['list_setting']['member_grade'][3]['iscredit'] == '1'){ ?>selected<?php } ?>" ><span><?php echo $lang['member_edit_allow'];?></span></label>
            <label for="mg[3][iscredit_2]" class="cb-disable <?php if($output['list_setting']['member_grade'][3]['iscredit'] == '0'){ ?>selected<?php } ?>" ><span><?php echo $lang['member_edit_deny'];?></span></label>
            <input id="mg[3][iscredit_1]" name="mg[3][iscredit]" <?php if($output['list_setting']['member_grade'][3]['iscredit'] == '1'){ ?>checked="checked"<?php } ?>  value="1" type="radio">
            <input id="mg[3][iscredit_2]" name="mg[3][iscredit]" <?php if($output['list_setting']['member_grade'][3]['iscredit'] == '0'){ ?>checked="checked"<?php } ?> value="0" type="radio">
			 </td>
				<td class="align-left"><input type="text" name="mg[3][maxcredit]" value="<?php echo $output['list_setting']['member_grade'][3]['maxcredit'];?>" class="w60" nc_type="verify" data-param='{"name":"允许赊账金额","type":"intzero"}'/></td>
			</tr>
        </tbody>
        <tfoot>
        	<tr>
        		<td colspan="4"><a href="JavaScript:void(0);" class="btn" id="submitBtn"><span><?php echo $lang['nc_submit'];?></span></a></td>
        	</tr>
        </tfoot>
 	</table>
</form>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/dialog/dialog.js" id="dialog_js" charset="utf-8"></script>
<script type="text/javascript">
$(function(){
	$('#submitBtn').click(function(){
		var result = true;
		var error = new Array();
		$("#mg_tbody").find("[nc_type='verify']").each(function(){
			if(result){
				data = $(this).val();
				if(!data){
					result = false;
					//error.push('请将信息填写完整');
					error = '请将信息填写完整';
				}
				//验证类型
				if(result){
					var data_str = $(this).attr('data-param');
				    if(data_str){
				    	eval( "data_str = "+data_str);
				    	switch(data_str.type){
				    	   case 'int':
				    		   result = (data = parseInt(data)) > 0?true:false;
				    		   error = (result == false)?(data_str.name + '应为整数'):'';
						   case 'intzero':
				    		   result = (data =parseInt(data)) >= 0?true:false;
				    		   error = (result == false)?(data_str.name + '应为整数'):'';
				    	}
				    }
				}				
			}
		});
		if(result){
			$('#mg_form').submit();
		} else {
			showDialog(error);
		}
    });
})
</script>