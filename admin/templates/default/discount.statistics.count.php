<script type='text/javascript' src='/js/chart.lib.js'></script>
<script type='text/javascript' src='/js/lib.js'></script>
<script type='text/javascript' src='/js/init.js'></script>
<script type='text/javascript' src='/js/date/date.js'></script>
<link href='/css/button.css' type='text/css' rel='stylesheet'/>
<script src="/js/chart/highcharts.js"></script>
<style>
	.tus {min-width: 310px; height: 400px; margin: 0 auto; margin-left:1%; width:49%; float:left;}
	.item-title{margin-top:15px; padding-button:15px;}
	.fixed-bar {height:70px;}
	.page {width:100%; height:100%; padding-top:40px;}
	.content{width:100%; overflow: hidden;}
	.body {width:200%; height:600px; right:1%; position:relative;}
	.page1,.page2{float:left; width:50%;}
	.page1 {width:50%;}
	.page2 {}
	.Controller {margin-left:10px;  height:40px;}
	.Controller span{margin-left:10px; height:120px;}
	.seach_button{ float:right; margin-right:10px;}
</style>
<div class='page'>
	<div class="fixed-bar">
	    <div class="item-title">
	       <h3 style='margin-top:10px;'><a id='discount_use_count' href='<?php echo urlAdmin('discountStatistics', 'discountStatistics');?>'>优惠券使用人数分析</a></h3>
	       <h3 style='margin-top:10px;  color:#000;'>优惠券使用量分析</h3>
	       <input id='show_p' type='button' value='显示统计图' style='float:right; margin-right:28px;' class="button button-primary button-pill button-small"/>
	    </div>

	    <div id='page' class='page'>
	    	<div id='content' class='content'>
	    		<div class='body'>
	    			<div class='page1'>
	    				<div class='Controller'>
	    					<select  id='type' name='type'>
	    						<option value='1'>全部</option>
	    						<option value='2'>优惠券</option>
	    						<option value='3'>折扣券</option>
	    					</select>
	    					<span>开始时间：<input id='start_time' type='text' name='start_time'></span>
	    					<span>结束时间：<input id='end_time'   type='text' name='ends_time'></span>
	    					<select  id='rul' name='rul'>
	    						<option value='1'>按天</option>
	    						<option value='2'>按月</option>
	    						<option value='3'>按年</option>
	    					</select>
	    					<input id='Seach' type='button' value='查询' class='seach_button button button-primary button-pill button-small'/>
	    				</div>
	    				<table class='table tb-type2 nobdb'>
							<thead>
							   <tr class="thead sortbar-array">
						       	  <th class="align-center">优惠券名称</th>
						          <th class="align-center">优惠后的总额</th>
						          <th class="align-center">订单实际总额</th>
						          <th class="align-center">实际优惠价格</th>
						          <th class="align-center">使用量</th>
						          <th class="align-center">商家参与</th>
						      </tr>
						    </thead>
						    
						  	<tbody>
						  		<?php foreach($output['DiscountStatisticsList']['discount'] AS $discountStatistics) { ?>
						  			<tr>
						  				<td style="text-align: center;"><?php echo $discountStatistics['discount_name']; ?></td>
						  				<td style="text-align: center;">
						  					<?php echo $discountStatistics['amount'];  ?>
						  				</td>
						  				<td style="text-align: center;">
						  					<?php echo $discountStatistics['order_amount'];  ?>
						  				</td>
						  				<td style="text-align: center;">
						  					<?php echo $discountStatistics['discount_amount'];  ?>
						  				</td>
						  				<td style="text-align: center;">
						  					1人
						  				</td>
						  				<td style="text-align: center;">
						  					<?php echo $discountStatistics['store_num'];  ?>
						  				</td>
						  			</tr>
								<?php } ?>
						  	</tbody>
						</table>
	    			</div>
	    			<div class='page2'>
	    				
	    			</div>
	    		</div>
	    	</div>
	    </div>
    </div>
</div>
<script type="text/javascript">
(function(){
    get.Id('discount_use_count').onclick = function()
	{
		setCookie('discount_use_count_url','<?php echo urlAdmin('discountStatistics', 'discountStatistics');?>');
		set.url('<?php echo urlAdmin('discountStatistics', 'discountStatistics');?>');		
	}
})();
//--日期
(function(index){
	if(0 != getCookie('select_rul')>>0)
	{
		var select_index = (getCookie('select_rul')>>0)-1;
		get.Id("rul").options[select_index].selected = true;
	}
	get.Id("rul").onchange = function()
	{
		$("#start_time").val('');
		$("#end_time").val('');
		setCookie('select_rul',this.value);
	}
	get.Id("start_time").onclick  = function(){
		var con = 'YYYY-MM-DD';
		switch(get.Id("rul").value>>0) {
				case 1:{
					con = 'YYYY-MM-DD';
					break;
				}
				case 2:{
					con = 'YYYY-MM';
					break;
				}
				case 3:{
					con = 'YYYY';
					break;
				}
		}
		get.dateDialog({
			dateCell:"#start_time",
			format:con,
			isTime:false, 
		});
	}
	get.Id("end_time").onclick  = function(){
		var con = 'YYYY-MM-DD';
		switch(get.Id("rul").value>>0) {
				case 1:{
					con = 'YYYY-MM-DD';
					break;
				}
				case 2:{
					con = 'YYYY-MM';
					break;
				}
				case 3:{
					con = 'YYYY';
					break;
				}
		}
		get.dateDialog({
			dateCell:"#end_time",
			format:con,
			isTime:false, 
		}); 
		return;
	}
})(2);
//--优惠券查询类型初始化
(function(){
	if(0 != getCookie('select_type')>>0)
	{
		var select_index = (getCookie('select_type')>>0)-1;
		get.Id("type").options[select_index].selected = true;
	}
	get.Id("type").onchange = function()
	{
		setCookie('select_type',this.value);
	}
})();
//--搜索
(function(){
	get.Id("Seach").onclick = function()
	{
		var dat = new Object();
		dat.start_time = get.Id("start_time").value;
		dat.end_time = get.Id("end_time").value;
		dat.type = get.Id("type").value;
		dat.rul = get.Id("rul").value;
		dat.url = "&start_time="+dat.start_time+"&end_time="+dat.end_time+"&type="+dat.type+"&rul="+dat.rul;
		set.url("<?php echo urlAdmin('discountStatistics', 'useSeach');?>"+dat.url);
	}
})();
</script>
