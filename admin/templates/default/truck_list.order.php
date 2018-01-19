<?php defined('ShopMall') or exit('Access Invalid!');?>
<?php if(!empty($output['order_list']) && is_array($output['order_list'])){?>
	<ul class="goods-list">
  <?php foreach($output['order_list'] as $key=>$val){?>
	<li>
	<dl class="goods-info">
      <dd><em> 单号: </em><?php echo $val['order_sn'];?></dd>
	  <dd> <em>商家名称:</em><?php echo $val['store_name'];?></dd>
      <dd><em>客户名称:</em><?php echo $val['buyer_name'];?></dd>
      <dd ><em>商品金额:</em><?php echo $val['goods_amount'];?></dd>
	  <dd ><em>收货人:</em><?php echo $val['reciver_name'];?></dd>
 	 <dd > <em>收货人地址:</em><?php echo $val['reciver_info']['address'];?></dd>
	 <dd ><em>联系方式: </em><?php echo $val['reciver_info']['phone'];?></dd>
</dl>
    <a nctype="btn_add_order"  data-order="<?php echo $val['order_id'];?>" href="javascript:void(0);" class="ncsc-btn-mini ncsc-btn-green"><i class="icon-ok-circle "></i>选择订单</a> </li>
  <?php } ?>
</ul>
<div class="pagination" style="width:600px; margin:5px 0;"><?php echo $output['show_page']; ?></div>
<?php } else { ?>
<div><?php echo $lang['no_record'];?></div>
<?php } ?>
