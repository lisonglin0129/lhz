
<link href='/shop/templates/default/css/seller_center.css' type='text/css' rel='stylesheet'/>
<link href='/css/tables.css' type='text/css' rel='stylesheet'/>
<style>
	.page {text-align: center;}
	.page ul  {display:inline-block;  }
	.page ul li {position:relative; float:left; padding:5px;}
</style>
<script type="text/javascript" src='/js/layer/jquery-1.11.0.min.js'></script>
<script type="text/javascript" src='/js/layer/layer.js'></script>
<script type="text/javascript" src='/js/lib.js'></script>
<script type="text/javascript">
var index = parent.layer.getFrameIndex(window.name); 
function setGoods(id,img)
{
	var imgs = window.parent.frames["workspace"].frames["contents"].contentWindow.document.getElementById("imgs");
	var links = window.parent.frames["workspace"].frames["contents"].contentWindow.document.getElementById("links");
	
	if(img.length>5)
	{
		var indexof = img.indexOf("_");
		var newpubht = img.substr(0,indexof);
		var path =  "http://"+Host+"/data/upload/shop/store/goods/"+newpubht+"/"+img;
		set.html(imgs,"<img src='"+path+"' style='width:100%; height:100%;'/>");
	}else{
		var path =  "http://"+Host+"/data/upload/shop/common/05157800252468670_360.png";
		set.html(imgs,"<img src='"+path+"' style='width:100%; height:100%;'/>");
	}

	links.value = "http://"+Host+'/wap/tmpl/product_detail.html?goods_id='+id;
	$("#layui-layer-shade"+index, parent.document).remove();
	$("#layui-layer"+index, parent.document).remove();
}
</script>
<div class="table_header">
	<table>
	 	<tbody>
	 		<tr class="t1">
		 		<td class="sheach">
			 		<input id="seachButton" type="button" class="submit seachButton" value="搜索" >
					<input id="seachText" type="text" class="seachInput" style="height: 20px;">
					
			 		<select id="select">
			 			 	<option value="0">全部</option>
			 			<?php foreach($output['store'] AS $store) { ?>
			 		  		<option value="<?php echo $store['store_id']; ?>"><?php echo $store['store_name']; ?></option>
			 		  	<?php } ?>
			 		</select>
			 		<select id="price">
		 			 	<option value="0">按价格</option>
		 				<option value="1">顺序（低到高）</option>
		 		  		<option value="2">倒序（高到低）</option>
			 		</select>
					<select id="times">
		 			 	<option value="0">按时间</option>
		 				<option value="1">升序</option>
		 		  		<option value="2">降序</option>
			 		</select>
			 	</td>
	 		</tr>
		</tbody>
	</table>
	<table>
	  <tbody><tr class="t1">
	    <th style="width:33%;">商品名称</th>
	    <th style="width:32%;">条形码</th>
	    <th style="width:10%;">商品价格</th>
	    <th style="width:10%;">含税价</th>
	    <th style="width:10%;">操作</th>
	  </tr>
	</tbody></table>
</div>
<div class='table_data'>
	<table id='tb'>
		<tbody>
			<?php foreach($output['goods'] AS $goods) { ?>
				<tr class='t1'>
					<td style="width:33%;"><span class='goods_name'><?php echo $goods['goods_name']; ?></span></td>
					<td style="width:32%;"><?php echo $goods['goods_barcode']; ?></td>
					<td style="width:10%;"><?php echo $goods['goods_price']; ?></td>
					<td style="width:10%;"><?php echo $goods['goods_promotion_taxprice']; ?></td>
					<td style="width:10%;"><input type="button" class="submit seachButton" onclick='javascript:setGoods("<?php echo $goods['goods_id']; ?>","<?php echo $goods['goods_image']; ?>");' value="选择" ></td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
	<div class='page'>
		<?php echo $output['page']; ?>
	</div>
</div>

<script>
	document.getElementById("seachButton").onclick = function()
	{
		var keyword = document.getElementById("seachText").value;
		var selectValue = document.getElementById("select").value;
		var selectPrice = document.getElementById("price").value;
		var selectTimes = document.getElementById("times").value;
		window.location.href="/admin/index.php?act=mobile_timplate&op=getgoodsList&orderPrice="+selectPrice+"&orderTime="+selectTimes+"&seach=1&keyword="+keyword+"&selectValue="+selectValue;
	}
</script>