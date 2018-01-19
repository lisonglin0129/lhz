<?php defined('ShopMall') or exit('Access Invalid!');?>
<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['nc_voucher_price_manage'];?></h3>
      <ul class="tab-base">
        <?php   foreach($output['menu'] as $menu) {  if($menu['menu_key'] == $output['menu_key']) { ?>
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $menu['menu_name'];?></span></a></li>
        <?php }  else { ?>
        <li><a href="<?php echo $menu['menu_url'];?>" ><span><?php echo $menu['menu_name'];?></span></a></li>
        <?php  } }  ?>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form id="add_form" method="post" action="index.php?act=voucher&op=templateadd"  enctype="multipart/form-data">
    <input type="hidden" id="form_submit" name="form_submit" value="ok"/>
     <table class="table tb-type2">
      <tbody>
      	<tr class="noborder">
          <td colspan="2" class="required"><label><?php echo '消费券名称'.$lang['nc_colon'];?></label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform">
		 <input type="text" class="w300 text" name="txt_template_title" value="<?php echo $output['t_info']['voucher_t_title'];?>">
        </td>
          <td class="vatop tips"></td>
        </tr>
        <tr class="noborder">
          <td colspan="2" class="required"><label>商品分类<?php echo $lang['nc_colon'];?></label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform">
		   <select name="sc_id"   class="class-select">
	           <option value="0">无限制</option>
	           <?php foreach ($output['store_class'] as $k=>$v){?>
	           <option value="<?php echo $v['gc_id'];?>" <?php if ($output['t_info']['voucher_t_sc_id']==$v['gc_id']){ echo 'selected';}?>><?php echo $v['gc_name'];?></option>
	           <?php }?>
	        </select>
           <td class="vatop tips">分类下商品满足相应消费额使用，未选分类即店铺全全场商品使用 </td>
        </tr>
        
        <tr class="noborder">
          <td colspan="2" class="required"><label><?php echo '有效期'.$lang['nc_colon'];?></label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform">
 					<input type="text" id="txt_template_enddate" name="txt_template_enddate" class="txt date"/>
 		   </td>
          <td class="vatop tips"></td>
        </tr>
        <tr class="noborder">
          <td colspan="2" class="required"><label><?php echo '面额'.$lang['nc_colon'];?></label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"> 
		   <select id="select_template_price" name="select_template_price" class="class-select">
	          <?php if(!empty($output['pricelist'])) { ?>
	          	<?php foreach($output['pricelist'] as $voucher_price) {?>
	          	<option value="<?php echo $voucher_price['voucher_price'];?>" <?php echo $output['t_info']['voucher_t_price'] == $voucher_price['voucher_price']?'selected':'';?>><?php echo $voucher_price['voucher_price'];?></option>
	          <?php } } ?>
	        </select>
			</td>
          <td class="vatop tips"></td>
        </tr>
        <tr class="noborder">
          <td colspan="2" class="required"><label><?php echo $lang['admin_voucher_template_total'].$lang['nc_colon'];?></label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform">
		<input type="text" class=" txt"  name="txt_template_total"   id=" txt_template_total"  value ="<?php echo $output['t_info']['voucher_t_total'];?>" ></td>
          <td class="vatop tips"></td>
        </tr>
        <tr class="noborder">
          <td colspan="2" class="required"><label><?php echo $lang['admin_voucher_template_eachlimit'].$lang['nc_colon'];?></label></td>
		 <td class="vatop tips"></td>
		
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><select name=" txt_template_limit" class="class-select">
	      		<option value="0"><?php echo '不限';?></option>
	      		<?php for($i=1;$i<=intval(C('promotion_voucher_buyertimes_limit'));$i++){?>
	      		<option value="<?php echo $i;?>" <?php echo $output['t_info']['voucher_t_eachlimit'] == $i?'selected':'';?>><?php echo $i;?><?php echo  '张';?></option>
	      		<?php }?>
	        </select></td>
          <td class="vatop tips"></td>
        </tr>
        <tr class="noborder">
          <td colspan="2" class="required"><label><?php echo $lang['admin_voucher_template_orderpricelimit'].$lang['nc_colon'];?></label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform">
		<input type="text" name="txt_template_limit" class="text w70" value="<?php echo $output['t_info']['voucher_t_limit'];?>"><em class="add-on"><i class="icon-renminbi"></i></em></td>
          <td class="vatop tips">消费金额即满足该金额才能使用该券，消费金额应大于券的面值！ </td>
        </tr>
        <tr class="noborder">
          <td colspan="2" class="required"><label><?php echo $lang['admin_voucher_template_describe'].$lang['nc_colon'];?></label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform">  
		<textarea  name="txt_template_describe" class="textarea w400 h600"><?php echo $output['t_info']['voucher_t_desc'];?></textarea></td>
          <td class="vatop tips"></td>
        </tr>
        <tr class="noborder">
          <td colspan="2" class="required"><label><?php echo $lang['admin_voucher_template_image'].$lang['nc_colon'];?></label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform">
           <span class="type-file-show"> <img class="show_image" src="<?php echo ADMIN_TEMPLATES_URL;?>/images/preview.png">
            <div class="type-file-preview" style="display: none;"><img id="view_img"></div>
            </span> <span class="type-file-box">
            <input type='text' name=customimg_pic' id='customimg_pic' class='type-file-text' />
            <input type='button' name='button' id='button' value='' class='type-file-button' />
            <input name="_pic" type="file" class="type-file-file" id="_pic" size="30" hidefocus="true" />
            </span>
          </td>
          <td class="vatop tips">该图片将在积分中心的消费券模块中显示，建议尺寸为160*160px。</td>
        </tr>
       </tbody>
      <tfoot>
        <tr class="tfoot">
          <td colspan="15"><a href="JavaScript:void(0);" class="btn" id="submitBtn"><span><?php echo $lang['nc_submit'];?></span></a></td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
<link type="text/css" rel="stylesheet" href="<?php echo RESOURCE_SITE_URL."/js/jquery-ui/themes/ui-lightness/jquery.ui.css";?>"/>
<script src="<?php echo RESOURCE_SITE_URL."/js/jquery-ui/jquery.ui.js";?>"></script> 
<script src="<?php echo RESOURCE_SITE_URL."/js/jquery-ui/i18n/zh-CN.js";?>" charset="utf-8"></script> 

<script>
 	//按钮先执行验证再提交表单
$(function(){$("#submitBtn").click(function(){
    if($("#add_form").valid()){
     $("#add_form").submit();
	}
	});
});

$(document).ready(function(){
 	$("#txt_template_enddate").datepicker({dateFormat: 'yy-mm-dd'});

  	//页面输入内容验证
	$("#add_form").validate({
		errorPlacement: function(error, element){
			error.appendTo(element.parent().parent().prev().find('td:first'));
	    },
	    rules : {
	    	 txt_template_title: {
                required : true,
                rangelength:[0,100]
            },
            txt_template_total: {
                required : true,
                digits : true
            },
            txt_template_limit: {
                required : true,
                number : true
            },
            txt_template_describe: {
                required : true
            }
	    },
	    messages : {
	      txt_template_title: {
                required : '模版名称不能为空且不能大于50个字符 ',
                rangelength : '模版名称不能为空且不能大于50个字符 '
            },
            txt_template_total: {
                required : '可发放数量不能为空且必须为整数 ',
                digits : '可发放数量不能为空且必须为整数 '
            },
            txt_template_limit: {
                required : '模版使用消费限额不能为空且必须是数字 ',
                number : '模版使用消费限额不能为空且必须是数字 '
            },
            txt_template_describe: {
                required : '模版描述不能为空且不能大于255个字符 '
            }
	    }
	});

});
</script> 