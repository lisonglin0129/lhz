<?php defined('ShopMall') or exit('Access Invalid!');?>
<script type='text/javascript' src='/js/lib.js'></script>
<script type='text/javascript' src='/js/date/date.js'></script>
<style>
	 .text{ 
	    width:350px;
	    white-space:nowrap;
	    text-overflow:ellipsis;
	    -o-text-overflow:ellipsis;
	    overflow: hidden;
	 }  
</style>

<div class="page">
	 <!-- 头部浮动 -->
	  <div class="fixed-bar">
	    <div class="item-title">
	      <h3>订单商品</h3>
	    </div>
	  </div>
	  <div class="fixed-empty"></div>
	  <form method="get" action="index.php" name="formSearch" id="formSearch">
	    <input type="hidden" name="act" value="discountOrder">
	    <input type="hidden" name="op" value="discountOrder">
	    <input type="hidden" name="" value="">
	    <div class="w100pre" style="width: 100%;">
	      <table class="tb-type1 noborder search left">
	        <tbody>
	          <tr style="background: rgb(255, 255, 255);">
	            <th>时间</th>
	            <td><input name="date" type='text' id='date' value = "<?php echo isset($_GET['date'])?$_GET['date']:'';?>"/></td>
	            <td><a href="javascript:void(0);" id="ncsubmit" class="btn-search tooltip" title="查询">&nbsp;</a></td>
	          </tr>
	        </tbody>
	      </table>
	      <span class="right" style="margin:12px 0px 6px 4px;"> </span> </div>
	  </form>
	  <div class="stat-info">
	  		<span>订单总数量：<strong><?php echo $output['order_list']['num']; ?></strong></span>
	  		<span>订单商品总金额：<strong><?php echo $output['order_list']['goods_amount']; ?></strong>元</span>
	  		<span>订单优惠后总金额：<strong><?php echo $output['order_list']['order_amount']; ?></strong>元</span>
	  		<span>订单实际总金额：<strong><?php echo $output['order_list']['pay_amount']; ?></strong>元</span>
	  		<span>订单原订单总金额：<strong><?php echo $output['order_list']['original_price'];?></strong>元</span>
	  </div>	
	  <div id="container" class="w100pre close_float" style="height:50px"></div>
	  <div style="text-align:right;">
    	<input type="hidden" id="export_type" name="export_type" data-param="{&quot;url&quot;:&quot;index.php?act=stat_trade&amp;op=income&amp;search_year=2017&amp;search_month=03&amp;exporttype=excel&quot;}" value="excel">
    	<a class="btns" href="javascript:void(0);" id="export_btn"><span id='print'>打印</span></a> 
      </div>
      <div id="printf">
	      <table class="table tb-type2 nobdb">
	      	<thead>
		      <tr class="thead">
		        <th class="align-center">店铺名称</th>
		        <th class="align-left">商品名称</th>
		        <th class="align-center">交易时间</th>
		        <th class="align-center">交易金额</th>
		        <th class="align-center">规格,品种</th>
		        <th class="align-center">数量</th>
		      </tr>
		    </thead>
		    <tbody class="datatable">
		        <?php foreach($output['order_goods'] AS $goods_info) { ?>
		            <?php if(isset($goods_info['rec_id'])) { ?>
			    	    <tr class="hover">
			    	    	<td class="align-center"> <?php echo $goods_info['order_info']['store_name']; ?></td>
			    	    	<td class="align-left"><?php echo $goods_info['goods_name']; ?></td>
			    	    	<td class="align-center"><?php echo $goods_info['order_info']['payment_time'] >0 ? date("Y-m-d H:i:s", $goods_info['order_info']['payment_time']):'未交易'; ?></td>
			    	    	<td class="align-center"> <?php echo $goods_info['order_info']['original_price']; ?></td>
			    	    	<td class="align-center">
			    	    		<?php 
			    	    			if(!empty($goods_info['goods_info']['goods_spec'])) {
				    	    		    $sp = "";
					    	    		foreach ($goods_info['goods_info']['goods_spec'] AS $sp) {
					    	    			 $sp=$sp . trim($sp);
					    	    		}
					    	    		echo trim($sp);
			    	    			}
			    	    		?>
			    	    	</td>
			    	    	<td class="align-center"> <?php echo $goods_info['goods_num']; ?></td>
			    	    </tr>
		    	    <?php }?>
		    	<?php }?>
		    </tbody>
	      </table>
	</div>
</div>
<script>
	
	get.Id("date").onclick = function()
	{
		var con = 'YYYY-MM';
		get.dateDialog({
			dateCell:"#date",
			format:con,
			isTime:false, 
		});
	}
	get.Id("ncsubmit").onclick = function()
	{
		get.Id("formSearch").submit();
	}

	get.Id("print").onclick = function()
	{
		   sys.print({
				id:'printf',
				css:["http://www.lhz.com/admin/templates/default/css/skin_0.css"],
				style:".text{width:350px; white-space:nowrap;text-overflow:ellipsis;  -o-text-overflow:ellipsis; overflow: hidden;",
				title:"<img src='http://www.lhz.com/data/upload/shop/common/logo.png'/>",
				footer:"<table class='table tb-type2 nobdb'><tr style='width:100%'><td><span style='display:block; width:200px;float:right;'>合计：<?php echo $output['order_list']['pay_amount']; ?>元</span></td></table>"
		   });
	}
</script>