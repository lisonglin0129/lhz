<?php defined('ShopMall') or exit('Access Invalid!');?>
<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3>联合物流运单管理</h3>
      <ul class="tab-base">
         <li><a href="index.php?act=logistics&op=logistics_all"><span><?php echo '所有物流运单';?></span></a></li>
        <li><a href="index.php?act=logistics&op=truck_list"><span><?php echo '车辆管理';?></span></a></li>
	    <li><a href="index.php?act=logistics&op=logistics_setting" class="current"><span><?php echo '物流设置';?></span></a></li>
		<li><a  href="index.php?act=logistics&op=add_logistics" ><span><?php echo '新增物流运单';?></span></a></li>
      </ul>
    </div>
  </div>
   <div class="fixed-empty"></div>
  <form id="add_form" method="post" enctype="multipart/form-data" action="<?php echo urlAdmin('logistics', 'logistics_setting_save');?>">
    <input type="hidden" id="submit_type" name="submit_type" />
    <table class="table tb-type2">
      <tbody>
        <tr class="noborder">
          <td colspan="2" class="required"><label class="validation">物流费用比率:</label></td>
        </tr>
        <tr class="noborder">
            <td class="vatop rowform">
                <input type="text" id="logistics_rate" name="logistics_rate" value="<?php echo $output['setting']['logistics_rate'];?>" class="txt">
            </td>
            <td class="vatop tips">按照订单的销售总金额的比率来计算物流费用。设置比率为 0-100 %范围，超出部分平均分摊</td>
        </tr>
        
        <tr class="noborder">
          <td colspan="2" class="required"><label class="validation">运费比率:</label></td>
        </tr>
        <tr class="noborder">
            <td class="vatop rowform">
                <input type="text" id="carry_rate" name="carry_rate" value="<?php echo isset($output['setting']['carry_rate']) ? $output['setting']['carry_rate']:0; ?>" class="txt">
            </td>
            <td class="vatop tips">按照订单的销售总金额的比率来计算运费比率。设置比率为 0-100 %范围</td>
        </tr>
        
        <tr class="noborder">
          <td colspan="2" class="required"><label class="validation">比率上限:</label></td>
        </tr>
        <tr class="noborder">
            <td class="vatop rowform">
                <input type="text" id="ratio_limit" name="ratio_limit" value="<?php echo isset($output['setting']['ratio_limit']) ? $output['setting']['ratio_limit']:0; ?>" class="txt">
            </td>
            <td class="vatop tips">运费上限，超过则按上限价</td>
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
<script>
$(document).ready(function(){
    $("#submitBtn").click(function(){
        $("#add_form").submit();
    });
    //页面输入内容验证
	$("#add_form").validate({
		errorPlacement: function(error, element){
			error.appendTo(element.parent().parent().prev().find('td:first'));
        },

        rules : {
        	logistics_rate: {
                required : true,
                digits : true,
                min : 0,
				max:100
            }
        },
        messages : {
      		logistics_rate: {
       			required : '必填',
       			digits : '数字',
                min : '最小',
				max:'最大'
            }
        }
	});
});
//submit函数
function submit_form(submit_type){
	$('#submit_type').val(submit_type);
	$('#add_form').submit();
}
</script>

