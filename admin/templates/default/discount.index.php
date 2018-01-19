<?php defined('ShopMall') or exit('Access Invalid!');?>
<script type="text/javascript" src='/js/layer/layer.js'></script>
<script type="text/javascript">
function ischeck(obj,id){
	var dat = new Object();
	dat.discount_id = id;
	var index = layer.load(1, {
		  shade: [0.3,'#fcfcfc'] //0.1透明度的白色背景
	});
	$.ajax({
		type:'post',
		url:'/admin/index.php?act=discount&op=ischeck',
		data:dat,
		dataType:'json',
		success:function(e)
		{
			layer.close(index);
			obj.parentNode.innerHTML = e.msg;
			if(e.status == 0)
			{
				setTimeout(function(){
					obj.innerHTML = '审核中';
				},2000);
			}
			
			
		}
	})
}
function del(id)
{
		
		var Message = layer.confirm('你确定删除？', {
		  btn: ['Yes','No'] //按钮
		}, function(){
			layer.close(Message);
			var index = layer.load(1, {
				  shade: [0.3,'#fcfcfc'] //0.1透明度的白色背景
			});
			var dat = new Object();
			dat.id = id;
			$.ajax({
				type:'post',
				url:'/admin/index.php?act=discount&op=del',
				data:dat,
				dataType:'json',
				success:function(e)
				{
					layer.close(index);
					layer.msg(e.msg,function(){
						window.location.reload();
					});
					
				}
			}) 
		}, function(){
		});
}
</script>
<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3>优惠券/折扣券管理</h3>
      <ul class="tab-base">
        <li><a href="JavaScript:void(0);" class="current"><span>管理</span></a></li>
        <li><a href="index.php?act=discount&op=new" ><span>添加</span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form method="get" name="formSearch">
    <input type="hidden" name="act" value="discount">
    <input type="hidden" name="op" value="discount">
    <table class="tb-type1 noborder search">
      <tbody>
        <tr>
          <th><label for="searchtitle"><?php echo $lang['activity_index_title']; ?></label></th>
          <td><input type="text" name="searchtitle" id="searchtitle" class="txt" value='<?php echo $_GET['searchtitle'];?>'></td>
          <td><select name="searchstate">
              <option value="0" <?php if (!$_GET['searchstate']){echo 'selected=selected';}?>><?php echo $lang['activity_openstate']; ?></option>
              <option value="2" <?php if ($_GET['searchstate'] == 2){echo 'selected=selected';}?>><?php echo $lang['activity_openstate_open']; ?></option>
              <option value="1" <?php if ($_GET['searchstate'] == 1){echo 'selected=selected';}?>><?php echo $lang['activity_openstate_close']; ?></option>
            </select>
          </td>
          <th colspan="1"><label for="searchstartdate"><?php echo $lang['activity_index_periodofvalidity']; ?></label></th>
          <td>
          	<input type="text" name="searchstartdate" id="searchstartdate" class="txt date" readonly='' value='<?php echo $_GET['searchstartdate'];?>'>~<input type="text" name="searchenddate" id="searchenddate" class="txt date" readonly='' value='<?php echo $_GET['searchenddate'];?>'></td>
          <td><a href="javascript:document.formSearch.submit();" class="btn-search " title="<?php echo $lang['nc_query']; ?>">&nbsp;</a></td>
        </tr>
      </tbody>
    </table>
  </form>
  <table class="table tb-type2" id="prompt">
    <tbody>
      <tr class="space odd">
        <th class="nobg" colspan="12"><div class="title">
            <h5><?php echo $lang['nc_prompts'];?></h5>
            <span class="arrow"></span></div></th>
      </tr>
      <tr>
        <td>
        	<ul>
	            <li><?php echo $lang['activity_index_help1'];?></li>
	            <li><?php echo $lang['activity_index_help2'];?></li>
	            <li><?php echo $lang['activity_index_help3'];?></li>
	            <li><?php echo $lang['activity_index_help4'];?></li>
            </ul>
          </td>
      </tr>
    </tbody>
  </table>
  <form id="listform" action="index.php" method='post'>
    <input type="hidden" name="act" value="activity" />
    <input type="hidden" id="listop" name="op" value="del" />
    <table class="table tb-type2">
      <thead>
        <tr class="thead">
          <th class="w28">&nbsp;</th>
          <th class="w48">名称</th>
          <th class="w270">店铺名称</th>
          <th class="w96">添加时间</th>
          <th class="align-center">剩余数量</th>
          <th class="align-center">开始时间</th>
          <th class="align-center">结束时间</th>
          <th class="align-center">是否审核</th>
          <th class="align-center">状态</th>
          <th class="w150 align-center">操作</th>
        </tr>
      </thead>
      <tbody id="treet1">
        <?php foreach($output['discountList'] as $k => $v){ ?>
        <tr class="hover edit row">
          <td><input type="checkbox" name='activity_id[]' value="<?php echo $v['discount_id'];?>" class="checkitem"></td>
      	  <td><?php echo $v['name']; ?></td>
      	  <td><?php echo $v['shop_name']; ?></td>
      	  <td><?php echo date('Y-m-d', $v['addtime']); ?></td>
      	  <td  align='center'><?php echo $v['num']; ?></td>
      	  <td  align='center'><?php echo date('Y-m-d', $v['start_time']); ?></td>
      	  <td  align='center'><?php echo date('Y-m-d', $v['end_time']); ?></td>
      	  <td  align='center'>
      	  	<?php 
      	  		switch($v['ischecked'])
      	  		{
      	  			case 1:{
      	  				echo "<a href='javascript:void(0)' onclick='ischeck(this,".$v['discount_id'].")'>审核中</a>";
      	  				break;	
      	  			}
      	  			case 2:{
      	  				echo '审核通过';
      	  				break;	
      	  			}
      	  			case 3:{
      	  				echo '审核未通过';
      	  				break;
      	  			}
      	  		}
      	  	?>
      	  </td>
      	  <td align='center'>
      	  	<?php 
				if(date('Ymd',$v['start_time']) > date('Ymd',time())) {
      	  			echo '未开始';
      	  		}else if(date('Ymd',$v['end_time']) >= date('Ymd',time()) && date('Ymd',$v['start_time']) <= date('Ymd',time())){
      	  			echo '活动中';
      	  		}else if(date('Ymd',$v['end_time'] < date('Ymd',time()))) {
      	  			echo '已结束';
      	  		}
      	  	?>
      	  </td>
      	  <td align='center'>
      	  	<a href='javascript:void(0);'>编辑</a>&nbsp;&nbsp;|&nbsp;
      	  	<a href='javascript:del(<?php echo $v['discount_id']; ?>);'>删除</a>
      	  </td>
        <?php } ?>
      </tbody>
      <tfoot>
	      <tr class="tfoot">
	        <td colspan="15" id="dataFuncs"><div class="pagination"> <?php echo $output['show_page'];?> </div></td>
	      </tr>
	  </tfoot>
    </table>
  </form>
</div>
<link type="text/css" rel="stylesheet" href="<?php echo RESOURCE_SITE_URL."/js/jquery-ui/themes/ui-lightness/jquery.ui.css";?>"/>
<script src="<?php echo RESOURCE_SITE_URL."/js/jquery-ui/jquery.ui.js";?>"></script> 
<script src="<?php echo RESOURCE_SITE_URL."/js/jquery-ui/i18n/zh-CN.js";?>" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.edit.js" charset="utf-8"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.goods_class.js" charset="utf-8"></script>
<script type="text/javascript">
$("#searchstartdate").datepicker({dateFormat: 'yy-mm-dd'});
$("#searchenddate").datepicker({dateFormat: 'yy-mm-dd'});
function submit_form(op){
	if(op=='del'){
		if(!confirm('<?php echo $lang['nc_ensure_del'];?>')){
			return false;
		}
	}
	$('#listop').val(op);
	$('#listform').submit();
}
</script>