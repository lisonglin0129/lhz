<script type='text/javascript' src='/js/chart.lib.js'></script>
<script type='text/javascript' src='/js/lib.js'></script>
<script type='text/javascript' src='/js/init.js'></script>
<script type='text/javascript' src='/js/date/date.js'></script>
<link href='/css/button.css' type='text/css' rel='stylesheet'/>
<script type="text/javascript">
$(function () {
    $(document).ready(function () {
    	  showChart(<?php echo $output['data']; ?>);
    });
});
</script>
<script src="/js/chart/highcharts.js"></script>
<style>
.seach_type { width: 100px; height:24px; overflow: hidden;  background: url(new_arrow.png) no-repeat right #FFF;
}
.date_input {width:100px;}
.pageground {width:100%; overflow: hidden;}
.one_page{width:200%; position:relative; right:0%;}
.one_datas{width:49%;  float:left;}
.tus {min-width: 310px; height: 400px; margin: 0 auto; margin-left:1%; width:49%; float:left;}
.item-title{margin-top:15px; padding-button:15px;}
.fixed-bar {height:70px;}
.seach_controler {height:55px; padding:5px;}
.seach_controler dl dt, .seach_controler dl dd {float:left; margin-left:15px;}
.seach_controler dl dt input ,.seach_controler dl dd input {width:100px;}

</style>
<div class='page'>
	<div class="fixed-bar">
	    <div class="item-title">
	       <h3 style='margin-top:10px; color:#000;'>优惠券使用人数分析</h3>
	       <h3 style='margin-top:10px;'><a id='discount_use_count' href='javascript:void(0)'>优惠券使用量分析</a></h3>
	      <input id='show_p' type='button' value='显示统计图' style='float:right; margin-right:28px;' class="button button-primary button-pill button-small"/>
	    </div>
    </div>
    <script>
		try {
	    	if(getCookie("discount_use_count_url").indexOf('use') >=0)
	    	{
	    		set.url(getCookie("discount_use_count_url"));
	        }
		}catch(e)
		{}
		get.Id('discount_use_count').onclick = function()
		{
			setCookie('discount_use_count_url','<?php echo urlAdmin('discountStatistics', 'usecount');?>');
			set.url('<?php echo urlAdmin('discountStatistics', 'usecount');?>');		
		}
    </script>
    <div style='clear:both; height:70px;'></div>
    <div id='pageground_id' class='pageground'>
	    <div id='show_page' class='one_page'>
		    <div class='one_datas'>
		    	<div class='seach_controler'>
		    		<dl id='seach_box' style='float:left;'>
		    			<dt>搜索范围:</dt>
		    			<dd id='control'>
		    				<select id='option' class='seach_type'>
				    			<option value='1'>按天</option>
				    			<option value='2'>按月</option>
				    			<option value='3'>按年</option>
				    		</select>
		    			</dd>
		    			<dt><input type='text' id='start_time'/></dt>
		    			<dd><input type='text' id='end_time'/></dd>
		    			<dt>
		    			   <select id='card_type' class='seach_type'>
				    			<option value='3'>全部</option>
				    			<option value='2'>折扣券</option>
				    			<option value='1'>优惠券</option>
				    		</select>
		    			</dt>
		    		</dl>
		    		<a href='javascript:void(0)' id='seachAction' style='float:right;' class='button button-primary button-pill button-small'>搜索</a>
		    	</div>
		    	<h1>使用量统计</h1>
		    	<table class='table tb-type2 nobdb'>
		    		<thead>
					   <tr class="thead sortbar-array">
				       	  <th class="align-center">优惠券名称</th>
				          <th class="align-center">优惠金额</th>
				          <th class="align-center">使用数量</th>
				      </tr>
				    </thead>
				    <tbody>
				      	<?php foreach ($output['resultcount'] AS $keydata => $valuedata) {?>
				      	   <?php foreach ($valuedata  AS $key => $value) { ?>
						    	<tr>
						    		<td  class="align-center"><?php echo $value[$key]['discount_name']; ?></td>
						    		<td  class="align-center"><?php echo $value['discount']['amount']; ?></td>
						    		<td  class="align-center"><?php echo $value['count']; ?></td>
						    	</tr>
					    	<?php } ?>
				    	<?php } ?>
				    </tbody>
		    	</table>	
		
		    	<div id='right_discount' class='bbb'></div>
		    	<h1>详情统计</h1>
				<table class='table tb-type2 nobdb'>
					<thead>
					   <tr class="thead sortbar-array">
				       	  <th class="align-center">优惠券累计总额</th>
				          <th class="align-center">优惠后的总额</th>
				          <th class="align-center">订单实际总额</th>
				          <th class="align-center">使用累计人数</th>
				          <th class="align-center">类型</th>
				          <th class="align-center">使用时间</th>
				      </tr>
				    </thead>
				    <tbody>
						<?php foreach ($output['discountStatisticsData']['data'] AS $discountStatistics) {?>
							<tr>
								<td align='center'><?php echo $discountStatistics['amount']; ?></td>
								<td align='center'><?php echo $discountStatistics['discount_price']; ?></td>
								<td align='center'><?php echo $discountStatistics['order_amount']; ?></td>
								<td align='center'><?php echo $discountStatistics['num']; ?>人</td>
								<td align='center'><?php echo $discountStatistics['type_info']; ?></td>
								<td align='center'><?php echo date('Y年m月d日',$discountStatistics['start_time']); ?></td>
							</tr>
						<?php } ?>
					    <tfoot>
					      <tr class="tfoot">
					        <td></td><td>合计：</td> 
					        <td></td><td align='center'><?php echo $output['discountStatisticsData']['discount_month']['num']; ?>人</td><td></td> 
					        <td></td>
					      </tr>
					    </tfoot>
					</tbody>
				</table>
			</div>
			<table class='tb-type1 noborder search left' style='margin-left:70px;'>
		    		<tbody>
		    			<tr>
		    				<td>	
		    					<select id='Yeah' style='float:left;'>
		    					</select>
					        </td>
		    				<td>	
		    					<select id='moth'>
		    						<option value='1'>1月</option>
		    						<option value='2'>2月</option>
		    						<option value='3'>3月</option>
		    						<option value='4'>4月</option>
		    						<option value='5'>5月</option>
		    						<option value='6'>6月</option>
		    						<option value='7'>7月</option>
		    						<option value='8'>8月</option>
		    						<option value='9'>9月</option>
		    						<option value='10'>10月</option>
		    						<option value='11'>11月</option>
		    						<option value='12'>12月</option>
		    					</select>
					        </td>
		    			</tr>
		    		</tbody>
		    	</table>
			<div id="container" class='tus'></div>
		</div>
	</div>
</div>
<div id='hiden' style="display:none;">
	<?php echo $output['Chart']; ?>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/jquery.ui.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/i18n/zh-CN.js" charset="utf-8"></script>
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />
<script type="text/javascript">
var dat = new Date();
var TimeStamp = new Object();
TimeStamp.Year = dat.getFullYear();
TimeStamp.month = dat.getMonth()+1;
TimeStamp.Date = dat.getDate();
var select = get.Id('moth');
var Year = get.Id("Yeah");
//---- 初始化UI
(function(){
	var  day = new Date(0,select.value>>0,0);
	var  today = day.getDate();
	setTimeout(function(){
		showChart(string.toJson(string.base64decode(get.Id('hiden').innerHTML)),today);
	},1);
})();
//--一切都从这开始
(function(index){
	for(var i=1900; i<=2800; i++)
	{
		Year.options.add(new Option(i+'年',i));
	}
	select.options[(TimeStamp.month>>0)-1].selected=true;
    Year.options[(TimeStamp.Year)-1900].selected=true;
		
	if(!getCookie('discountStatisticsData'))
	{
		$("#show_page").animate({right:"0%"});
		$("#pageground_id").css({height:""});
		$("#show_p").val('显示统计图')
	}else{
			
	    if(getCookie('discountStatisticsData') == '显示统计图')
		{
	    	$("#pageground_id").css({height:""});
			$("#show_page").css({right:"0%"});
			$("#show_p").val('显示统计图')
		}
		if(getCookie('discountStatisticsData') == '返回')
		{
			    $("#pageground_id").css({height:"450"});
				$("#show_page").css({right:"100%"});
				$("#show_p").val('返回');
		}	
	}
	$("#show_p").click(function(){
		if($(this).val() == '显示统计图')
	    {
		  setCookie('discountStatisticsData','返回');
		  $("#show_page").animate({right:"100%"});
		  $("#pageground_id").css({height:"450"});
		  var  day = new Date(0,select.value>>0,0);
		  $(this).val('返回');
		  var  today = day.getDate().toString();
		  if(today.length >= 2) {
			  setTimeout(function(){
					showChart(string.toJson(string.base64decode(get.Id('hiden').innerHTML)),today);
			  },2000);
		  }
		}else if($(this).val() == '返回'){
			setCookie('discountStatisticsData','显示统计图');
			$("#show_page").animate({right:"0%"});
			$("#pageground_id").css({height:""});
			$(this).val('显示统计图')
		}		
	});
	
})(1);

//--日期
(function(index){

	if(0 != getCookie('select_index')>>0)
	{
		var select_index = (getCookie('select_index')>>0)-1;
		get.Id("option").options[select_index].selected = true;
	}
	get.Id("option").onchange = function()
	{
		$("#start_time").val('');
		$("#end_time").val('');
		setCookie('select_index',this.value);
	}
	get.Id("start_time").onclick  = function(){
		var con = 'YYYY-MM-DD';
		switch(get.Id("option").value>>0) {
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
		switch(get.Id("option").value>>0) {
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
//--异步请求
(function(index){
	Year.onchange = function()
	{
		var Years = this.value;
		var Month = get.Id('moth').value;
		var timestamp = times.datetime_to_unix(Years+'-'+Month+'-01'+' 00:00:00');
		var t = new Object();
		t.date = timestamp;
		Call.Ajax({
			type:'post',
			url:'/admin/index.php?act=discountStatistics&op=AjaxTus',
			data:t,
			success:function(e)
			{
				  var  day = new Date(0,select.value>>0,0);
				  var  today = day.getDate();
				  showChart(string.toJson(e), today);
			}
		})
	}
	get.Id('moth').onchange = function(e)
	{
		var Years = Year.value;
		var Month = this.value;
		var timestamp = times.datetime_to_unix(Years+'-'+Month+'-01'+' 00:00:00');
		var t = new Object();
		t.date = timestamp;
		Call.Ajax({
			type:'post',
			url:'/admin/index.php?act=discountStatistics&op=AjaxTus',
			data:t,
			success:function(e)
			{
			
				  var  day = new Date(0,select.value>>0,0);
				  var  today = day.getDate();
				  showChart(string.toJson(e), today);
			}
		})
	}
})(3);
//--点击按钮搜索
(function(){
    get.Id('seachAction').onclick = function()
    {
    	var option = get.Id("option").value>>0;
		var start_time = get.Id("start_time").value;
		var end_time = get.Id("end_time").value;
		var card_type = get.Id('card_type').value;
	    var url = '/admin/index.php?act=discountStatistics&op=Seach&type='+option+'&start_time='+start_time+'&end_time='+end_time+'&cardType='+card_type;
		set.url(url);
	}
})()
$(function () {
    Highcharts.getOptions().colors = Highcharts.map(Highcharts.getOptions().colors, function (color) {
        return {
            radialGradient: { cx: 0.5, cy: 0.3, r: 0.7 },
            stops: [
                [0, color],
                [1, Highcharts.Color(color).brighten(-0.3).get('rgb')] // darken
            ]
        };
    });
    $('#right_discount').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false
        },
        title: {
            text: '优惠券'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    },
                    connectorColor: 'silver'
                }
            }
        },
        series: [{
            type: 'pie',
            name: '平均比例',
            data: [
                ['优惠券名称:770', 12],
                {
                    name: '优惠券名称:50-30',
                    y: 12.8,
                    sliced: true,
                    selected: true
                }
            ]
        }]
    });
});
</script>
