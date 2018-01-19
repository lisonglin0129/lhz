<link href='templates/default/css/mobile.css' type='text/css' rel='stylesheet'/>
<script type="text/javascript" src='/js/lib.js'></script>

<script>
function add_goods(json)
{
	window.parent.dialogPage(json);
}
</script>
<!-- <div class='page'>
	<div class="fixed-bar">
	  <div class="item-title">
	      <h3>手机模板设置</h3>
	  </div>
	  <div></div>
	</div>
	<div class='banner_box'>
	   	<ul id='banner' class='banner'>
	   		<?php foreach($output['img_resource'] AS $value) { ?>
	   			<li title='鼠标双击删除' class="lidel" onclick='eidt(<?php echo $value['id']; ?>)' ondblclick='del(<?php echo $value['id']; ?>)'><img  src='<?php echo $value['success_path']; ?>'/></li>
	   		<?php } ?>
	  		<li onclick='showUpload()' title='鼠标单击添加'><img src="<?php echo RESOURCE_SITE_URL;?>/images/tianjia.png"></li>
  		</ul> 
	</div>
</div> -->
<div class='run_app'>
	<div class='content'>
		<iframe id='iframe' src='/wap/index.html' class='iframe' ></iframe>
	</div>
</div>
<div class='option_box'>
	<ul id='menu' class='menu'>
		<li>banner设置</li>
		<li>分类设置</li>
		<li>版块设置</li>
		<li>热销商品设置</li>
	</ul>
	<div style='clear:both; width:100%; height:1px; background:#ABCDEF;'></div>
	<div id='tab_sc'>
		<iframe id='contents' class='iframe2' src='/admin/index.php?act=mobile_timplate&op=solideList'> </iframe>
	</div>
</div>
<script type="text/javascript">
(function(){
	var li = get.Tag(get.Id('menu'),'li');
	li[0].className = 'checked_list';
	for(var i = 0; i<li.length; i++)
	{
		(function(index){
			li[i].onclick  = function(){
				for(j  =  0; j < li.length; j++)
				{
					li[j].className = '';
				}
				this.className = 'checked_list';
				switch(index)
				{		
					case 0 :{
						get.Id('contents').src = '/admin/index.php?act=mobile_timplate&op=solideList';
						//---这里代表是 banner选项卡
						break;
					}
					case 1 :{
						get.Id('contents').src = '/admin/index.php?act=mobile_timplate&op=catgroyList';
						//---这里代表是分类
						break;
					}
					case 2 :{
						get.Id('contents').src = '/admin/index.php?act=mobile_timplate&op=modList';
						break;
					}
					case 3 :{
						get.Id('contents').src = '/admin/index.php?act=mobile_timplate&op=sellingList';
						break;
					}
				}
			}
	
		})(i);

	}
})()

</script>
<script>
var ifa = document.getElementById('iframe');
var main_container 
var intval = setInterval(function(){
	banner_box = ifa.contentWindow.document.getElementById('banner_box');
	if(banner_box) {
		var imgs = banner_box.getElementsByTagName("img");
	
		if(imgs.length > 0)
		{
			clearInterval(intval);
			banner_box.onmouseover  = function()
			{
				//$(this).css({"border":"1px solid #ffae00"})
			
			}
			banner_box.onmouseout  = function()
			{
			
				/* $(this).css({
					"border":""
				}) */
			}
		}
	}
},100);

</script>