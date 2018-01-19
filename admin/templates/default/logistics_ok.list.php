<?php defined('ShopMall') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3>物流订单管理</h3>
      <ul class="tab-base">
        <li><a href="index.php?act=logistics&op=logistics_manage"><span><?php echo '待接单';?></span></a></li>
		<li><a href="JavaScript:void(0);" class="current"><span><?php echo '待确认单';?></span></a></li>
        <li><a href="index.php?act=logistics&op=logistics_all"><span><?php echo '所有物流订单';?></span></a></li>
        <li><a href="index.php?act=logistics&op=truck_list"><span><?php echo '车辆管理';?></span></a></li>
		<li><a href="index.php?act=logistics&op=add_logistics"><span><?php echo '新增物流订单';?></span></a></li>

      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form method="get" action="index.php" name="formSearch" id="formSearch">
    <input type="hidden" name="act" value="logistics" />
    <input type="hidden" name="op" value="logistics_ok" />
    <table class="tb-type1 noborder search">
      <tbody>
        <tr>
        <th><select name="type">
            <option value="logis_sn" <?php if($_GET['type'] == 'order_sn'){?>selected<?php }?>>运单号</option>
			<option value="delivery_store_name" <?php if($_GET['type'] == 'store_name'){?>selected<?php }?>>送货商家</option>
            <option value="delivery_name" <?php if($_GET['type'] == 'delivery_name'){?>selected<?php }?>>送货人</option>
            <option value="delivery_mobphone" <?php if($_GET['type'] == 'delivery_mobphone'){?>selected<?php }?>>接单人手机号</option>
            <option value="delivery_info" <?php if($_GET['type'] == 'delivery_info'){?>selected<?php }?>>配送说明</option>
          </select></th>
        <td><input type="text" class="text" name="key" value="<?php echo trim($_GET['key']); ?>" /></td>
          <th><label for="add_time_from"><?php echo '订单时间';?></label></th>
          <td><input class="txt date" type="text" value="<?php echo $_GET['add_time_from'];?>" id="add_time_from" name="add_time_from">
            <label for="add_time_to">~</label>
            <input class="txt date" type="text" value="<?php echo $_GET['add_time_to'];?>" id="add_time_to" name="add_time_to"/></td>
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
            <li>平台发起物流订单，有物流能力的商家进行抢单配送。</li>
          </ul></td>
      </tr>
    </tbody>
  </table>
  <table class="table tb-type2 nobdb">
    <thead>
      <tr class="thead">
        <th>物流订单号</th>
        <th>要求完成时间</th>
		<th>送货费</th>
         <th class="align-center">订单时间</th>
         <th class="align-center">订单状态</th>
        <th class="align-center"><?php echo $lang['nc_handle'];?></th>
      </tr>
    </thead>
    <tbody>
      <?php if (is_array($output['logistics_list']) && !empty($output['logistics_list'])) { ?>
      <?php foreach ($output['logistics_list'] as $key => $val) { ?>
      <tr class="bd-line" >
        <td><?php echo $val['order_sn'];?></td>
        <td><?php echo $val['deliverytime'];?></td>  
	    <td><?php echo $val['order_amount']; ?></td>
           <td class="align-center"><?php echo date('Y-m-d H:i:s',$val['add_time']);?></td>
         <td class="align-center"><?php echo  $output['state_array'][$val['order_state']];?></td>
        <td class="align-center"><a href="index.php?act=logistics&op=edit_logistics&order_id=<?php echo $val['order_id']; ?>"> 确认信息 </a></td>
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
      <?php if (is_array($output['logistics_list']) && !empty($output['logistics_list'])) { ?>
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
