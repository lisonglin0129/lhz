<?php defined('ShopMall') or exit('Access Invalid!');?>
<script type='text/javascript' src='/js/lib.js'></script>
<script type='text/javascript' src='/js/date/date.js'></script>
<!—[if IE 6 ]><html class=“ie ielt9 ielt8 ielt7 ie6” lang=“en-US”><![endif]—>
<!—[if IE 7 ]><html class=“ie ielt9 ielt8 ie7” lang=“en-US”><![endif]—>
<!—[if IE 8 ]><html class=“ie ielt9 ie8” lang=“en-US”><![endif]—>
<!—[if IE 9 ]><html class=“ie ie9” lang=“en-US”><![endif]—>
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
    	<a class="btns" href="javascript:void(0);" id="p" style='background:transparent url(/admin/templates/default/images/sky/bg_position.gif) no-repeat scroll 0 0px;'><span >打印</span></a> 
      </div>
      <div id="printf">
	      <table class="table tb-type2 nobdb" style='width: 100%'>
	      	<thead>
		      <tr class="thead">
		        <th class="align-center" style="width:26%">会员名称</th>
		        <th class="align-left" style="width:43%">商品名称</th>
		        <th class="align-center" style="width:14%">交易时间</th>
		        <th class="align-center" style="width:10%">交易金额</th>
		        <th class="align-center" style="width:7%">数量</th>
		      </tr>
		    </thead>
		    <tbody class="datatable">
		        <?php foreach($output['order_goods'] AS $goods_info) { ?>
		            <?php if(isset($goods_info['rec_id'])) { ?>
			    	    <tr class="hover">
			    	    	<td class="align-left"> <?php echo $goods_info['order_info']['buyer_name']; ?></td>
			    	    	<td class="align-left"><?php echo $goods_info['goods_name']; ?></td>
			    	    	<td class="align-left"><?php echo $goods_info['order_info']['payment_time'] >0 ? date("Y-m-d", $goods_info['order_info']['payment_time']):'未交易'; ?></td>
			    	    	<td class="align-left"> <?php echo $goods_info['goods_pay_price']; ?></td>
			    	    	<td class="align-left"> <?php echo $goods_info['goods_num']; ?></td>
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
	get.Id("p").onclick = function()
	{
		   $.ajax({
			    type:'get',
				url:"http://"+Host+"/css/p.css",
				success:function(e){
					  sys.print({
							id:'printf',
						    style:e,
							title:"<img class='log' src='http://"+Host+"/data/upload/shop/common/logo.png'/>",
							footer:"<div class='footer'><span style='display:block; width:200px;float:right;'><b>合计：<?php echo $output['order_list']['goods_amount']; ?>元</b></span></div>"
					  });
				}
			})
		
	}
</script>