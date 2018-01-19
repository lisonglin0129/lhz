<?php defined('ShopMall') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['bill_manage'];?>结算管理</h3>
        <ul class="tab-base">
        <li><a class="current" href="JavaScript:void(0);"><span>结算管理</span></a></li>
        <li><a href="index.php?act=bill&op=show_statis"><span>商家账单列表</span></a></li></ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form method="get" action="index.php" target="" name="formSearch" id="formSearch">
    <input type="hidden" name="act" value="bill" />
    <input type="hidden" name="op" value="index" />
    <table class="tb-type1 noborder search">
      <tbody>
        <tr>
          <th>按年份搜索</th>
          <td>
			<select name="query_year" class="querySelect">
			<option value=""><?php echo $lang['nc_please_choose'];?></option>
			<?php for($i = date('Y',TIMESTAMP)-5; $i <= date('Y',TIMESTAMP)+2; $i++) { ?>
			<option value="<?php echo $i;?>" <?php if ($_GET['query_year'] == $i) {?>selected<?php } ?>><?php echo $i;?></option>
			<?php } ?>
			</select>
          </td>
           <td>
			<select name="os_month" class="querySelect">
				<option value=""><?php echo $lang['nc_please_choose'];?></option>
				<?php for($j = 1; $j <= 12; $j++) { ?>
					<option value="<?php echo $j;?>" <?php if ($_GET['os_month'] == $j) {?>selected<?php } ?>><?php echo $j.'月';?></option>
				<?php } ?>
			</select>
          </td>
         <td><a href="javascript:void(0);" id="ncsubmit" class="btn-search " title="<?php echo $lang['nc_query'];?>">&nbsp;</a>
            </td>
            <td></td>
            <td></td>
            <th>订单号</th>
            <td>
            <td class="w160"><input type="text" class="text w150" id='date2' name="ob_no" value="<?php echo $_GET['ob_no']; ?>" /></td>
            </td>
            <td><a href="javascript:void(0);" id="submit2" class="btn-search " title="<?php echo $lang['nc_query'];?>">&nbsp;</a>
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
            <li>此处列出了平台每月的结算信息汇总，点击查看可以查看本月详细的店铺账单信息列表</li>
          </ul></td>
      </tr>
    </tbody>
  </table>
  <table class="table tb-type2 nobdb">
    <thead>
      <tr class="thead">
        <th>下单时间</th>
        <th class="align-center">支付金额</th>
        <th class="align-center">实际订单金额</th>
        <th class="align-center">订单金额</th>
        <th class="align-center">运费</th>
        <th class="align-center">收取佣金</th>
        <th class="align-center">退单金额</th>
        <th class="align-center"><?php echo $lang['nc_handle'];?></th>
      </tr>
    </thead>
    <tbody>
      <?php if(!empty($output['bill_count_list'])) {  ?>
		    <?php  foreach($output['bill_count_list'] AS $bill_count_list) { ?>
			      <tr class="hover">
			        <td><?php echo $bill_count_list['add_time'];?></td>
			       	<td class="nowrap align-center"><?php echo $bill_count_list['pay_amount'];?></td>
			        <td class="nowrap align-center"><?php echo $bill_count_list['original_price'];?></td>
			        <td class="nowrap align-center"><?php echo $bill_count_list['order_amount'];?></td>
			        <td class="align-center"><?php echo $bill_count_list['express_price'];?></td>
			        <td class="align-center"><?php echo $bill_count_list['commis_rate'];?></td>
			        <td class="align-center"><?php echo $bill_count_list['refund_amount'];?></td>
			        <td class="align-center">
			       	 <a href="index.php?act=bill&op=show_statis&os_day=<?php echo $bill_count_list['add_time'];?>"><?php echo $lang['nc_view'];?></a>
			        </td>
			      </tr>
			<?php } ?>
	  <?php } ?>
    </tbody>
    <tfoot>
        <tr class="tfoot">
          <td colspan="16">
            <?php  $output['bill_page']->templateShowPage(); ?>
          </td>
        </tr>
      </tfoot>
  </table>
</div>
<div>
	
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/jquery.ui.js"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/i18n/zh-CN.js" charset="utf-8"></script>
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />
<script>
    $("#submit2").click(function(){
       //接收订单号的值
       var val = $("#date2").val();
        window.location.href="/admin/index.php?act=bill&op=order_number_search&order_sn="+val;
    });
	$("#ncsubmit").click(function(){
		$("#formSearch").submit();
	})
</script>
