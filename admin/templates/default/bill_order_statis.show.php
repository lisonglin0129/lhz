<?php defined('ShopMall') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['bill_manage'];?>结算管理</h3>
		<ul class="tab-base">
		<li><a href="index.php?act=bill"><span>结算管理</span></a></li>
		<li><a class="current" href="JavaScript:void(0);"><span><?php echo !empty($_GET['os_month']) ? $_GET['os_month'].'期' : null;?> 商家账单列表</span></a></li>
		</ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form method="get" action="index.php" target="" name="formSearch" id="formSearch">
    <input type="hidden" name="act" value="bill" />
    <input type="hidden" name="op" value="show_statis" />
    <input type="hidden" name="os_month" value="<?php echo $_GET['os_month'];?>">
    <table class="tb-type1 noborder search">
      <tbody>
        <tr>
          <th>订单号</th>
          <td>
            <td class="w160"><input type="text" class="text w150" id='date' name="ob_no" value="<?php echo $_GET['ob_no']; ?>" /></td>
          </td>
          <td><a href="javascript:void(0);" id="submit" class="btn-search " title="<?php echo $lang['nc_query'];?>">&nbsp;</a>
          </td>
        </tr>
      </tbody>
    </table>
  </form>
  <table class="table tb-type2" id="prompt">
    <tbody>
      <tr class="space odd">
        <th colspan="12"><div class="title">
            <h5><?php echo $lang['nc_prompts'];?></h5>
            <span class="arrow"></span></div></th>
      </tr>
      <tr>
        <td><ul>
            <li>此处列出了详细的店铺账单信息，点击查看可以查看详细的订单信息、退单信息和店铺费用信息</li>
            <li>账单处理流程为：系统出账 > 商家确认 > 平台审核 > 财务支付(完成结算) 4个环节，其中平台审核和财务支付需要平台介入，请予以关注</li>
          </ul></td>
      </tr>
    </tbody>
  </table>
  <div style="text-align:right;"><a class="btns" href="index.php?<?php echo $_SERVER['QUERY_STRING'];?>&op=export_bill"><span><?php echo $lang['nc_export'];?>CSV</span></a></div>
  <table class="table tb-type2 nobdb">
    <thead>
      <tr class="thead">
        <th>账单编号</th>
        <th class="align-center">日期</th>
        <th class="align-center">订单金额</th>
   		<th class="align-center">实际订单金额</th>
        <th class="align-center">实施支付金额</th>
        <th class="align-center">运费</th>
        <th class="align-center">佣金金额</th>
        <th class="align-center">退款金额</th>
        <th class="align-center">店铺费用</th>
        <th class="align-center"><?php echo $lang['nc_handle'];?></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($output['bill_order_list'] AS $bill) { ?>
	      <tr class="hover">
	        <td><?php echo $bill['pay_sn']; ?></td>
	        <td class="nowrap align-center"><?php echo $_GET['os_day'];?></td>
	        <td class="nowrap align-center"><?php echo $bill['order_amount']; ?></td>
	     	<td class="nowrap align-center"><?php echo $bill['original_price']; ?></td>
	        <td class="nowrap align-center"><?php echo $bill['pay_amount']; ?></td>
	        <td class="align-center"><?php echo $bill['express_price']; ?></td>
	        <td class="align-center"><?php echo $bill['commis_rate']; ?></td>
	        <!-- 平台运费 -->
	        <td class="align-center"><?php echo $bill['refund_amount']; ?></td>
	        <!-- 佣金金额 -->
	        <td class="align-center">2</td>
	        <td class="align-center">
	     	   <a href="index.php?act=bill&op=show_bill&pay_sn=<?php echo $bill['pay_sn']; ?>"><?php echo $lang['nc_view'];?></a>
	        </td>
	      </tr>
	  <?php } ?>
    </tbody>
    <tfoot>
      <tr class="tfoot">
        <td colspan="15" id="dataFuncs"><div class="pagination"> <?php echo $output['show_page'];?> </div></td>
      </tr>
    </tfoot>
  </table>
    <?php  $output['bill_page']->templateShowPage(); ?>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/jquery.ui.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/i18n/zh-CN.js" charset="utf-8"></script>
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />
<script type="text/javascript">
$("#submit").click(function(){
    var val=$("#date").val();
    window.location.href="/admin/index.php?act=bill&op=order_number_search&order_sn="+val;
})
</script>
