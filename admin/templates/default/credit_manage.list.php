<?php defined('ShopMall') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3>买家赊账管理</h3>
      <ul class="tab-base">
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo '买家赊账催缴';?></span></a></li>
        <li><a href="index.php?act=credit&op=credit_all"><span><?php echo '赊账记录';?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form method="get" action="index.php" name="formSearch" id="formSearch">
    <input type="hidden" name="act" value="credit" />
    <input type="hidden" name="op" value="credit_manage" />
    <table class="tb-type1 noborder search">
      <tbody>
        <tr>
        <th><select name="type">
             <option value="balance_sn" <?php if($_GET['type'] == 'balance_sn'){?>selected<?php }?>>结算单号</option>
            <option value="store_name" <?php if($_GET['type'] == 'store_name'){?>selected<?php }?>>商家名称</option>
             <option value="buyer_name" <?php if($_GET['type'] == 'buyer_name'){?>selected<?php }?>>买家</option>
          </select></th>
        <td><input type="text" class="text" name="key" value="<?php echo trim($_GET['key']); ?>" /></td>
          <th><label for="add_time_from"><?php echo '催结时间';?></label></th>
          <td><input class="txt date" type="text" value="<?php echo $_GET['add_time_from'];?>" id="add_time_from" name="add_time_from">
            <label for="add_time_to">~</label>
            <input class="txt date" type="text" value="<?php echo $_GET['add_time_to'];?>" id="add_time_to" name="add_time_to"/></td>
			<th>状态：</th>
        <td class="w100"><select name="stage">
            <option value="" <?php if (!$_GET['stage']){echo 'selected=selected';}?>><?php echo $lang['nc_please_choose'];?></option>
            <option value="0" <?php if ($_GET['stage'] == '0'){echo 'selected=selected';}?>>待付款</option>
            <option value="1" <?php if ($_GET['stage'] == '1'){echo 'selected=selected';}?>>已取消</option>
            <option value="2" <?php if ($_GET['stage'] == '2'){echo 'selected=selected';}?>>已结算</option>
           </select></td>
          <td><a href="javascript:void(0);" id="ncsubmit" class="btn-search " title="<?php echo $lang['nc_query'];?>">&nbsp;</a>
            </td>
        </tr>
      </tbody>
    </table>
  </form>
  <table class="table tb-type2" id="prompt">
    <tbody>
      <tr class="space odd">
        <th colspan="12"><div class="title"><h5><?php echo $lang['nc_prompts'];?></h5><span class="arrow"></span></div></th>
      </tr>
      <tr>
        <td>
        <ul>
            <li>买家提交赊账，商家发起赊账结算，卖家进行赊账支付。</li>
          </ul></td>
      </tr>
    </tbody>
  </table>
  <table class="table tb-type2 nobdb">
    <thead>
      <tr class="thead">
         <th>结算单号</th>
         <th>商家名称</th>
         <th>买家</th>  
         <th class="align-center">催结时间</th>	
	   	<th>赊账金额</th>
		 <th>支付方式</th>
		 <th class="align-center">支付时间</th>
         <th class="align-center">结算状态</th>
        <th class="align-center"><?php echo $lang['nc_handle'];?></th>
      </tr>
    </thead>
    <tbody>
      <?php if (is_array($output['credit_list']) && !empty($output['credit_list'])) { ?>
      <?php foreach ($output['credit_list'] as $key => $val) { ?>
		<tr class="bd-line" >
        <td><?php echo $val['balance_sn'];?></td>
         <td><?php echo $val['store_name']; ?></td>
		<td><?php echo $val['buyer_name']; ?></td>
        <td class="align-center"><?php echo date('Y-m-d H:i:s',$val['add_time']);?></td>
	  <td><?php echo $val['debt_amount']; ?></td>
	 <td><?php echo $val['payment_code']; ?></td>
		 <td class="align-center"><?php  if (! empty($val['payment_time'])){ echo date('Y-m-d H:i:s',$val['payment_time']);}?></td>
         <td class="align-center"><?php echo $output['bstate_array'][$val['payment_state']]?></td>
         <td  class="align-center"> 
         <?php if  ($val['payment_state']==0) { ?>
         <a href="index.php?act=credit&op=receive_pay&ban_id=<?php echo $val['ban_id']; ?>">
	收到赊账款</a>
				    <?php } ?>
    		 </td>
       </tr>
      <?php } ?>
    </tbody>
    <?php } else { ?>
    <tbody>
      <tr class="no_data">
        <td colspan="20"><?php echo $lang['no_record'];?></td>
      </tr>
    </tbody>
    <?php } ?>
      <?php if (is_array($output['credit_list']) && !empty($output['credit_list'])) { ?>
    <tfoot>
      <tr>
        <td colspan="20"><div class="pagination"><?php echo $output['show_page']; ?></div></td>
      </tr>
    </tfoot>
    <?php } ?>
  </table>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/jquery.ui.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/i18n/zh-CN.js" charset="utf-8"></script>
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />
<script type="text/javascript">
$(function(){
    $('#add_time_from').datepicker({dateFormat: 'yy-mm-dd'});
    $('#add_time_to').datepicker({dateFormat: 'yy-mm-dd'});
    $('#ncsubmit').click(function(){
    	$('#formSearch').submit();
    });
});
</script>
