<?php defined('ShopMall') or exit('Access Invalid!');?>
<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3>联合物流运单管理</h3>
      <ul class="tab-base">
         <li><a href="index.php?act=logistics&op=logistics_all"  class="current" ><span><?php echo '所有物流运单';?></span></a></li>
        <li><a href="index.php?act=logistics&op=truck_list"><span><?php echo '车辆管理';?></span></a></li>
		<li><a href="index.php?act=logistics&op=logistics_setting"><span><?php echo '物流设置';?></span></a></li>
 		<li><a  href="index.php?act=logistics&op=add_logistics" ><span><?php echo '新增物流运单';?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form id="post_form" method="post" name="form1">
    <input type="hidden" name="form_submit" value="ok" />
    <table class="table tb-type2">
      <tbody>
	 
	<tr class="noborder">
	<td colspan="2" class="required"><label class=" validation" for="reason_info">配送要求:</label></td>
	</tr>
	<tr class="noborder">
          <td colspan="2" class="vatop rowform"> 配送要求: <?php echo $output['logistics_orderinfo']['delivery_info']?></td>
     </tr>
          <tr class="noborder">
          <td colspan="2" class="required"><label class="validation " for="reason_info">承运车信息:</label></td>
          </tr>
          <tr class="noborder">
         <td colspan="2" class="vatop rowform">  <label style="padding-right:20px" for="sort">承运车信息:</label><span id="truckInfo">  
		<?php if (!empty($output['logistics_truck'])){?>
		   车牌号：<?php echo $output['logistics_truck']['truck_code']?>     载重：<?php echo $output['logistics_truck']['Factor']?>      箱积：<?php echo $output['logistics_truck']['Area']?>      使用费：<?php echo $output['logistics_truck']['shipping_fee']?>     联系方式：<?php echo $output['logistics_truck']['contact']?>（<?php echo $output['logistics_truck']['contactphone']?>）
			<?php } ?>
		</span>
          </td>
          </tr>
          
          <tr class="noborder">
          <td colspan="2" class="required"><label class=" validation" for="reason_info">费用情况:</label></td>
          </tr>
          <tr class="noborder">
          <td class="vatop rowform">  <label  style="padding-right:20px"  for="sort">车辆运费:</label>￥<?php echo $output['logistics_orderinfo']['order_amount']?></td>
          <td class="vatop rowform"> <label style="padding-right:20px"  for="sort">附加费:</label>￥<?php echo $output['logistics_orderinfo']['extra_amount']?></td>
          </tr>
          <tr class="noborder">
          <td colspan="2" class="required"><label class="validation " for="reason_info">其他说明:</label></td>
          </tr>
          <tr class="noborder">
          <td class="vatop rowform"> <label style="padding-right:20px"  for="sort">承运所在地区:</label> <?php echo $output['logistics_orderinfo']['area_info']?></td>
          <td class="vatop rowform">  <label style="padding-right:20px"  for="sort">要求完成时间:</label> <?php echo $output['logistics_orderinfo']['deliverytime']?></td>
          </tr>
         
      	<tr class="noborder">
          <td colspan="2" class="required"><label class="validation" for="reason_info">承运订单:</label></td>
        </tr>
        <tr class="noborder">
          <td colspan="2"  class="vatop rowform">
		<?php if (!empty($output['logistics_detail'])){?>
	<table class="table tb-type2 mtw">
	<thead class="thead">
	<tr style="background: rgb(255, 255, 255);">
	<th>单号</th>
 	<th>商家名称</th>
	<th>箱积（立方米）</th>
	<th>重量（公斤）</th>
	<th class="align-center">物流单号</th>
	<th>承担运费  </th>
	</tr>
	</thead>
	<tbody >
	  
 	 <?php foreach ($output['logistics_detail'] as $key => $v) { ?>
	<tr class="hover edit" style="background: rgb(255, 255, 255);">
	<td class="w48"><label><?php echo $v['order_sn']?></label></td>
	<td class="w48"><label><?php echo $v['store_name']?></label></td>
	<td class="w48"><label><?php echo $v['Area']?> </label></td>
	<td class="w48"><label><?php echo $v['Factor']?> </label></td>
	<td class="w48"><label><?php echo $v['shipping_code']?> </label></td>
	<td class="w48"><label><?php echo $v['shipping_fee']?> </label></td>
	</tr>
	<?php } ?>
	</tbody>
	</table>
		<?php } ?>
		</td>
           
        </tr>
		
		
		 <tr>
          <td colspan="2" class="required"><label class="validation" for="sort">状态确认:</label>
            </td>
        </tr>
        <tr class="noborder">
          <td class="vatop">
		     <select name="order_state"  id ="order_state" >
			<?php if($output['logistics_orderinfo']['order_state']<=10){?>   
             <option value="10" <?php if($output['logistics_orderinfo']['order_state'] == '10'){?>selected<?php }?>>配送待发</option> 
		   <?php }?>
		<?php if($output['logistics_orderinfo']['order_state']<=20){?>   
             <option value="20" <?php if($output['logistics_orderinfo']['order_state'] == '20'){?>selected<?php }?>>配送中</option>
				   <?php }?>
		<?php if($output['logistics_orderinfo']['order_state']<=30){?>   
             <option value="30" <?php if($output['logistics_orderinfo']['order_state'] == '40'){?>selected<?php }?>>客户已收货</option>
				   <?php }?>
		<?php if($output['logistics_orderinfo']['order_state']<=40){?>   
             <option value="40" <?php if($output['logistics_orderinfo']['order_state'] == '40'){?>selected<?php }?>>送货完成</option>    
				   <?php }?>
		<?php if($output['logistics_orderinfo']['order_state']<=20){?>    
		     <option value="50" <?php if($output['logistics_orderinfo']['order_state'] == '50'){?>selected<?php }?>>送货取消</option>     
		  <?php }?>      
			</select>
		</td>
          <td class="vatop tips"></td>
        </tr>
      </tbody>
    
      <tfoot>
        <tr class="tfoot">
          <td colspan="15" ><a href="JavaScript:void(0);" class="btn" id="submitBtn"><span><?php echo $lang['nc_submit'];?></span></a></td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/jquery.ui.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/i18n/zh-CN.js" charset="utf-8"></script>
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/common_select.js" charset="utf-8"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.mousewheel.js"></script> 


<script>
//按钮先执行验证再提交表单
$(function(){
 $('#deliverytime').datepicker({dateFormat: 'yy-mm-dd'});
regionInit("region");
	$("#submitBtn").click(function(){
        if($("#post_form").valid()){
            $("#post_form").submit();
    	}
	});
	$("#post_form").validate({
		errorPlacement: function(error, element){
			error.appendTo(element.parent().parent().prev().find('td:first'));
        },
        rules : {
            delivery_info : {
                required : true
            },
			 deliverytime : {
                required : true
            },
			order_amount : {
                required : true
            },
			  address : {
                required : true
            },
			area_info : {
                required : true
            }
        },
        messages : {
            delivery_info : {
                required : "配送要求不能为空"
            },
			  deliverytime : {
                required : "配送接单时间不能为空"
            },
			order_amount: {
                required : "送货费用不能为空"
            },
				address: {
                required : "接货地址不能为空"
            },
	     area_info: {
                required : "商家所在区域不能为空"
            }
            
        }
	});
});

</script>
