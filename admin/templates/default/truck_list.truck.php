<?php defined('ShopMall') or exit('Access Invalid!');?>
<?php if(!empty($output['truck_list']) && is_array($output['truck_list'])){?>
	<ul class="goods-list">
  <?php foreach($output['truck_list'] as $key=>$val){?>
	<li>
	<dl class="goods-info">
      <dd><em> 商家名称: </em><?php echo $val['store_name'];?></dd>
	  <dd> <em>车牌号:</em><?php echo $val['truck_code'];?></dd>
	  <dd ><em>使用费（元）:</em><?php echo $val['shipping_fee'];?></dd>
      <dd><em>车型/品牌:</em><?php echo $val['truck_type'];?>/<?php echo $val['truck_brand'];?></dd>
      <dd ><em>载重（公斤）:</em><?php echo $val['Factor'];?></dd>
	 <dd ><em>箱积（立方米）:</em><?php echo $val['Area'];?></dd>
 	 <dd > <em>联系人:</em><?php echo $val['contact'];?></dd>
	 <dd ><em>联系方式: </em><?php echo $val['contactphone'];?></dd>
</dl>
    <a nctype="btn_add_groupbuy_goods"  data-goods-commonid="<?php echo $val['tru_id'];?>" href="javascript:void(0);" class="ncsc-btn-mini ncsc-btn-green"><i class="icon-ok-circle "></i>选择车辆</a> </li>
  <?php } ?>
</ul>
<div class="pagination" style="width:600px; margin:5px 0;"><?php echo $output['show_page']; ?></div>
<?php } else { ?>
<div><?php echo $lang['no_record'];?></div>
<?php } ?>
